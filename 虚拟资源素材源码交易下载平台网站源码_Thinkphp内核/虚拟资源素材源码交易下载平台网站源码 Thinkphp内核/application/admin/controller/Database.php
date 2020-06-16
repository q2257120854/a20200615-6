<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Database extends AdminBase
{
    public static $path = "./data/backup/";
    public function index($type = null)
    {
    	
        switch ($type) {
            case 'import':
                //使用系统变量直接构造备份目录绝对路径
                $path = ROOT_PATH  . 'data'. DS . 'backup'. DS ;
                if(!is_dir($path)){
                    //目录不存在,创建一个
                    dir_create($path);
                }
                $flag = \FilesystemIterator::KEY_AS_FILENAME;
                $glob = new \FilesystemIterator($path,  $flag);
                $list = array();
                foreach ($glob as $name => $file) {
                    if(preg_match('/^\d{8,8}-\d{6,6}-.{16}-\d+\.sql(?:\.gz)?$/', $name)){
                       // print_r($name);
                       // die();
                        $name2 = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%16s-%d');

                        $date = "{$name2[0]}-{$name2[1]}-{$name2[2]}";
                        $time = "{$name2[3]}:{$name2[4]}:{$name2[5]}";
                        $part = $name2[7];
                        $info['name']=$name;
                        if(isset($list["{$date} {$time}"])){
                            $info = $list["{$date} {$time}"];
                            $info['part'] = max($info['part'], $part);
                            $info['size'] = $info['size'] + $file->getSize();
                        } else {
                            $info['part'] = $part;
                            $info['size'] = $file->getSize();
                        }
                        $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                        $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                        $info['time']     = strtotime("{$date} {$time}");

                        $list["{$date} {$time}"] = $info;
                    }
                }
                krsort($list);
                break;
            case 'export':
                $list = Db::query('SHOW TABLE STATUS');
                $list = array_map('array_change_key_case', $list);
                break;
            default:
               // $this->error('参数错误！');
                return json(array('code' => 0, 'msg' => '参数错误'));
        }
        $this->assign('list', $list);
        return $this->fetch($type);
    }
    public function optimize()
    {
        if (isset($_POST['tables'])) {
            $tables = $_POST['tables'];
            $tables = implode('`,`', $tables);
            $list = Db::query("OPTIMIZE TABLE `{$tables}`");
            if ($list) {
               // $this->success("数据表优化完成！");
                return json(array('code' => 200, 'msg' => '数据表优化完成'));
            } else {
               // $this->error("数据表优化出错请重试！");
                return json(array('code' => 0, 'msg' => '数据表优化出错请重试'));
            }
        } else {
            $this->error("请指定要优化的表！");
           // return json(array('code' => 0, 'msg' => '请指定要优化的表'));
        }
    }
    public function repair()
    {
        if (isset($_POST['tables'])) {
            if (!isset($_POST['tables'])) {
                //$this->error("请指定要修复的表！");
                return json(array('code' => 0, 'msg' => '请指定要修复的表'));
            }
            $tables = $_POST['tables'];
            $tables = implode('`,`', $tables);
            $list = Db::query("REPAIR TABLE `{$tables}`");
            if ($list) {
               // $this->success("数据表修复完成！");
                return json(array('code' => 200, 'msg' => '数据表修复完成'));
            } else {
                //$this->error("数据表修复出错请重试！");
                return json(array('code' => 0, 'msg' => '数据表修复出错请重试'));
            }
        } else {
           // $this->error("请指定要优化的表！");
            return json(array('code' => 0, 'msg' => '请指定要优化的表'));
        }
    }
    public function delete($time)
    {
       // $time = intval($_GET['time']);
        $name = date('Ymd-His', $time) . '-*.sql*';
        $path = realpath(self::$path) . DIRECTORY_SEPARATOR . $name;
        array_map("unlink", glob($path));
        if (!count(glob($path))) {
            //$this->success("删除成功！");
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
          //  $this->error('删除失败');
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function export()
    {
        if (isset($_POST['tables'])) {
            $tables = $_POST['tables'];
            dir_create(self::$path);
            $config = ['path' => realpath(self::$path) . DS,
			           'part' => '20971520',
					   'compress' => '1',
					   'level' => '9'];
            $lock = "{$config['path']}backup.lock";
            if (is_file($lock)) {
               // $this->error('检测到有一个备份任务正在执行，请稍后再试！');
                return json(array('code' => 0, 'msg' => '检测到有一个备份任务正在执行，请稍后再试！'));
            } else {
                file_put_contents($lock, time());
            }
            if(!is_writeable($config['path'])){
            	return json(array('code' => 0, 'msg' => '备份目录不存在或不可写，请检查后重试！'));
            }
            session('backup_config', $config);
            //$file = ['name' => date('Ymd-His', time()), 'part' => 1];
            $file = ['name' => date('Ymd-His', time()).'-'.generate_password(16), 'part' => 1];
            session('backup_file', $file);
            session('backup_tables', $tables);
          
            $Databack = new \org\Databack($file, $config);
            if (false !== $Databack->create()) {
                
                return json(array('code' => 200, 'msg' =>'初始化成功！','url'=>url('admin/database/export').'?id=0&start=0'));
            } else {
            	return json(array('code' => 0, 'msg' => '初始化失败，备份文件创建失败！'));
            }
        } elseif (isset($_GET['id']) && isset($_GET['start'])) {
            $tables = session('backup_tables');
            $id = intval($_GET['id']);
            $start = intval($_GET['start']);
            $Databack = new \org\Databack(session('backup_file'), session('backup_config'));
            $r = $Databack->backup($tables[$id], $start);
            if (false === $r) {
              //  $this->error('备份出错！');
                return json(array('code' => 0, 'msg' => '备份出错！'));
            } elseif (0 === $r) {
                if (isset($tables[++$id])) {
                	return json(array('code' => 200, 'name'=>$tables[$id-1], 'msg' =>'备份完成！','url'=>url('Database/export').'?id='.$id.'&start=0'));
                   // return $this->success($tables[$id - 1] . '备份完成！', url('Database/export', ['id' => $id, 'start' => 0]));
                } else {
                    @unlink(session('backup_config.path') . 'backup.lock');
                    session('backup_tables', null);
                    session('backup_file', null);
                    session('backup_config', null);
                    return json(array('code' => 200, 'msg' => '备份完成！','name'=>$tables[$id-1]));
                   // return $this->success('备份完成！', url('Database/index', ['type' => 'export']));
                }
            } else {
                $rate = floor(100 * ($r[0] / $r[1]));
                return json(array('code' => 200, 'name'=>$tables[$id],'msg' =>"正在备份...({$rate}%)",'url'=>url('Database/export').'?id='.$id.'&start='.$r[0]));
                //return $this->success($tables[$id] . "正在备份...({$rate}%)", url('Database/export', ['id' => $id, 'start' => $r[0]]));
            }
        } else {
        	return json(array('code' => 0, 'msg' => '请指定要备份的表！'));
            //$this->error("请指定要备份的表！");
        }
    }
    public function import()
    {
        if (isset($_GET['time'])) {
            $time = intval($_GET['time']);
            $name = date('Ymd-His', $time) . '-*.sql*';
            $path = realpath(self::$path) . DIRECTORY_SEPARATOR . $name;
            $files = glob($path);
            $list = [];
            foreach ($files as $name) {
                $basename = basename($name);
                $match = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%16s-%d');
                $gz = preg_match('/^\\d{8,8}-\\d{6,6}-.{16}-\\d+\\.sql.gz$/', $basename);
                $list[$match[7]] = [$match[7], $name, $gz];
            }
            ksort($list);
            $last = end($list);
            if (count($list) === $last[0]) {
                session('backup_list', $list);
                //return $this->success('正在还原...！', url('Database/import', ['part' => 1, 'start' => 0]));
                return json(array('code' => 200, 'msg' =>'正在还原...！','url'=>url('Database/import').'?part=1&start=0'));
            } else {
            	return json(array('code' => 0, 'msg' => '备份文件可能已经损坏，请检查'));
               // return $this->error('备份文件可能已经损坏，请检查！');
            }
        } elseif (isset($_GET['part']) && isset($_GET['start'])) {
            $part = intval($_GET['part']);
            $start = intval($_GET['start']);
            $list = session('backup_list');
            $db = new \org\Databack($list[$part], ['path' => realpath(self::$path), 'compress' => $list[$part][2]]);
            $r = $db->import($start);
            if (false === $r) {
            	return json(array('code' => 0, 'msg' => '还原数据出错'));
              //  $this->error('还原数据出错！');
            } elseif (0 === $r) {
                if (isset($list[++$part])) {
                	return json(array('code' => 200, 'msg' =>"正在还原...#{$part}",'url'=>url('Database/import').'?part='.$part.'&start=0'));
                   // return $this->success("正在还原...#{$part}", url('Database/import', ['part' => $part, 'start' => 0]));
                } else {
                    session('backup_list', null);
                    return json(array('code' => 200, 'msg' =>'还原完成！'));
                   // return $this->success('还原完成！', url('Database/index', ['type' => 'import']));
                }
            } else {
				
                if ($r[1]) {
                    $rate = floor(100 * ($r[0] / $r[1]));
                    return json(array('code' => 200, 'msg' =>"正在还原...#{$part} ({$rate}%)",'url'=>url('Database/import').'?part='.$part.'&start='.$r[0]));
                    //return $this->success("正在还原...#{$part} ({$rate}%)", url('Database/import', ['part' => $part, 'start' => $r[0]]));
                } else {
                	return json(array('code' => 200, 'msg' =>"正在还原...#{$part}",'url'=>url('Database/import').'?part='.$part.'&start='.$r[0]));
                    //return $this->success("正在还原...#{$part}", url('Database/import', ['part' => $part, 'start' => $r[0]]));
                }
            }
        } else {
        	return json(array('code' => 0, 'msg' => '参数错误'));
          //  $this->error('参数错误！');
        }
    }
    
}
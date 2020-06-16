<?php

class SearchController extends CommonAction {
    public function index(){
        $cid = I('cid');
        $style = I('style');
        $bid = I('bid');
        $getattr = I('attr');

        //商品查询
        $s = D('GoodsSearch');
        $s -> cid = $cid;
        $s -> bid = $bid;
        $s -> attr = $getattr;
        $s -> sort = I('sort');
        $s -> price = I('price');
        $s -> stockfilter = I('stockfilter');
        $s -> searchval = I('searchval');
        $total = $s -> count();
        $pages = new \Home\Model\PageModel($total,40);
        $page = $pages -> fpage();
        $s -> limit = $pages -> limit;
        $goods = $s -> select();
        foreach ($goods as $key => $value) {
            $pics = explode(',', $value['gpic']);
            $goods[$key]['gpic'] = $pics[0];
        }
        //搜索结果分类
        $c = D('ClassView');
        $curr = $c -> findClass($cid);
        $newcid = explode('-', $curr['bpath']);

        //面包屑导航
        $breadnav = $c -> allParent($cid);

        //左侧分类导航
        if (!empty($newcid[1])) {
            $nowcid = $newcid[1];
        }else{
            $nowcid = $cid;
        }
        $allclass = $c -> childClass($nowcid);
        foreach ($allclass as $key => $value) {
            $allclass[$key]['child'] = $c -> childEnd($value['cid']);
        }
        
        //子分类
        $childs = $c -> childClass($cid);

        //所有品牌
        $brands = $c -> childBrand($cid);

        //属性
        $a = D('AttrView');
        $attr = $a -> allAttr($cid);

        //热销榜
        $hotsales = $this->hotSales($cid);

        //当前选中的品牌和属性
        if ($bid >0 || $getattr >0) {
            $currselect = $a -> findAttr($getattr);
            $m = M('brand');
            $currbrand = $m -> field('bid,bname') ->find($_GET['bid']);
        }

        //基本配置
        $web = D("WebConfig");
        $webdata = $web -> web();
		$classifydata = M('classify');
		$classdata = $classifydata->field('cid,cname')->where('parentid=0')->select();

		$this->assign('classdata',$classdata);
        $this -> assign("web",$webdata);
        $this -> assign('title',$curr['cname']);
        $this -> assign('currselect',$currselect);
        $this -> assign('currbrand',$currbrand);
        $this -> assign('bnav',$breadnav);
        $this -> assign('cid',$cid);
        $this -> assign('curr',$curr);
        $this -> assign('childs',$childs);
        $this -> assign('allclass',$allclass);
        $this -> assign('attr',$attr);
        $this -> assign('brands',$brands);
        $this -> assign('goods',$goods);
        $this -> assign('hotsales',$hotsales);
        $this -> assign('page',$page);
        $this -> display();
    }

    //热销商品查询
    public function hotSales($cid){
        $c = D('ClassView');
        $curr = $c -> findClass($cid);
        $currs = explode('-', $curr['bpath']);
        $currcid = $currs[1];
        $s = D('GoodsSearch');
        $s -> cid = $currcid;
        $s -> sort = 1;
        $s -> limit = ' LIMIT 0,5';
        $goods = $s -> select();
        foreach ($goods as $key => $value) {
            $pics = explode(',', $value['gpic']);
            $goods[$key]['gpic'] = $pics[0];
        }
        return $goods;
    }
}

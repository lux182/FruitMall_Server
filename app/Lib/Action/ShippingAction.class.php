<?php

/**
 * 配送地址Action
 *
 * @author Zonkee
 * @version 1.0.0
 * @since 1.0.0
 */
class ShippingAction extends AdminAction {

    /**
     * 添加配送地址
     */
    public function add() {
        if ($this->isAjax()) {
            $city = isset($_POST['city']) ? trim($_POST['city']) : $this->redirect('/');
            $district = isset($_POST['district']) ? trim($_POST['district']) : $this->redirect('/');
            $road_number = isset($_POST['road_number']) ? trim($_POST['road_number']) : $this->redirect('/');
            $community = isset($_POST['community']) ? trim($_POST['community']) : $this->redirect('/');
            $building = isset($_POST['building']) ? trim($_POST['building']) : $this->redirect('/');
            $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : $this->redirect('/');
            $shipping_fee = isset($_POST['shipping_fee']) ? floatval($_POST['shipping_fee']) : $this->redirect('/');
            $discount = isset($_POST['discount']) ? trim($_POST['discount']) : $this->redirect('/');
            $this->ajaxReturn(D('ShippingAddress')->addShippingAddress($city, $district, $road_number, $community, $building, $branch_id, $shipping_fee, $discount));
        } else {
            $this->assign('branch', M('Branch')->select());
            $this->display();
        }
    }

    /**
     * 删除配送地址
     */
    public function delete() {
        if ($this->isAjax()) {
            $id = isset($_POST['id']) ? explode(',', $_POST['id']) : $this->redirect('/');
            $this->ajaxReturn(D('ShippingAddress')->deleteShippingAddress((array) $id));
        } else {
            $this->redirect('/');
        }
    }

    /**
     * 所有地址
     */
    public function index() {
        if ($this->isAjax()) {
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $pageSize = isset($_GET['pagesize']) ? $_GET['pagesize'] : 20;
            $order = isset($_GET['sortname']) ? $_GET['sortname'] : 'id';
            $sort = isset($_GET['sortorder']) ? $_GET['sortorder'] : 'ASC';
            $shippingAddress = D('ShippingAddress');
            $total = $shippingAddress->getShippingAddressCount();
            if ($total) {
                $rows = $shippingAddress->getShippingAddressList($page, $pageSize, $order, $sort);
                foreach ($rows as &$v) {
                    $v['add_time'] = date("Y-m-d H:i:s", $v['add_time']);
                    $v['update_time'] = $v['update_time'] ? date("Y-m-d H:i:s", $v['update_time']) : $v['update_time'];
                }
            } else {
                $rows = null;
            }
            $this->ajaxReturn(array(
                'Rows' => $rows,
                'Total' => $total
            ));
        } else {
            $this->display();
        }
    }

    /**
     * 更新配送地址
     */
    public function update() {
        $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->redirect('/');
        if ($this->isAjax()) {
            $city = isset($_POST['city']) ? trim($_POST['city']) : $this->redirect('/');
            $district = isset($_POST['district']) ? trim($_POST['district']) : $this->redirect('/');
            $road_number = isset($_POST['road_number']) ? trim($_POST['road_number']) : $this->redirect('/');
            $community = isset($_POST['community']) ? trim($_POST['community']) : $this->redirect('/');
            $building = isset($_POST['building']) ? trim($_POST['building']) : $this->redirect('/');
            $branch_id = isset($_POST['branch_id']) ? intval($_POST['branch_id']) : $this->redirect('/');
            $shipping_fee = isset($_POST['shipping_fee']) ? floatval($_POST['shipping_fee']) : $this->redirect('/');
            $discount = isset($_POST['discount']) ? trim($_POST['discount']) : $this->redirect('/');
            $this->ajaxReturn(D('ShippingAddress')->updateShippingAddress($id, $city, $district, $road_number, $community, $building, $branch_id, $shipping_fee, $discount));
        } else {
            $this->assign('shippingAddress', M('ShippingAddress')->where(array(
                'id' => $id
            ))->find());
            $this->assign('branch', M('Branch')->select());
            $this->display();
        }
    }

}
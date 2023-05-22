<?php 
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");


    // CARDVIP.VN
    if(isset($_GET['status']) && isset($_GET['requestid'])){
        $status = check_string($_GET['status']);
        //$message = check_string($_GET['message']);
        $request_id = check_string($_GET['requestid']);
        $declared_value = check_string($_GET['pricesvalue']); //Giá trị khai báo
        $value = check_string($_GET['value_receive']); //Giá trị thực của thẻ
        $amount = check_string($_GET['value_customer_receive']); //Số tiền nhận được
        $code = check_string($_GET['card_code']);
        $serial = check_string($_GET['card_seri']);
        //$trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
        $callback_sign = check_string($_GET['callback_sign']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        
        if($row['loaithe'] == 'Vietnamobile')
        {
            $telco = 'VNMOBI';
        }
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 200)
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        else if($status == 201)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        else
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'thatbai',
                'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }
    }

    // GACHTHE1S.COM
    if(isset($_GET['request_id']) && isset($_GET['callback_sign'])){
        $status = check_string($_GET['status']);
        $message = check_string($_GET['message']);
        $request_id = check_string($_GET['request_id']); // request id
        $declared_value = check_string($_GET['declared_value']); //Giá trị khai báo
        $value = check_string($_GET['value']); //Giá trị thực của thẻ
        $amount = check_string($_GET['amount']); //Số tiền nhận được
        $code = check_string($_GET['code']);
        $serial = check_string($_GET['serial']);
        $telco = check_string($_GET['telco']);
        $trans_id = check_string($_GET['trans_id']); //Mã giao dịch bên chúng tôi
        $callback_sign = check_string($_GET['callback_sign']);
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        if(!$row){
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly'){
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 1){
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL){
                if($CMSNT->site('status_ref') == 'ON'){
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            die('Thẻ đúng !');
        }
        else if($status == 2)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        else
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'thatbai',
                'ghichu'    => $message,
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");

            
            sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
            exit('Thẻ không hợp lệ !');
        }
    }

    // CARDV2 - CARD48.NET
    if(isset($_GET['status']) && isset($_GET['content']))
    {
        $status = check_string($_GET['status']);
        //$message = check_string($_GET['message']);
        $request_id = check_string($_GET['content']);
        $value = check_string($_GET['menhgiathuc']); //Giá trị thực của thẻ
        $amount = check_string($_GET['thucnhan']); //Số tiền nhận được
        $row = $CMSNT->get_row("SELECT * FROM `card_auto` WHERE `code` = '$request_id' ");
        $getUser = $CMSNT->get_row("SELECT * FROM `users` WHERE `username` = '".$row['username']."' ");
        $telco = $row['loaithe'];
        if(!$row)
        {
            exit('Request ID không tồn tại');
        }
        if($row['trangthai'] != 'xuly')
        {
            exit('Thẻ này đã được xử lý rồi');
        }
        if($status == 'hoantat')
        {
            $CMSNT->update("card_auto", [
                'amount'    => $amount,
                'trangthai' => 'hoantat',
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            /**
             * CỘNG TIỀN CHO USER
             */
            $CMSNT->cong("users", "money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $row['thucnhan'], " `username` = '".$row['username']."' ");
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $row['thucnhan'],
                'sotiensau'     => $getUser['money'] + $row['thucnhan'],
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'hoantat', $row['thucnhan'], $value);
            exit('Thẻ đúng !');
        }
        if($status == 'hoantat' && $row['menhgia'] != $value)
        {
            $ck = $CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$telco' AND `menhgia` = '$value'  ")['ck'];
            $thucnhan = $value - $value * $ck / 100;
            $thucnhan = $thucnhan / 2;
            $CMSNT->update("card_auto", [
                'trangthai' => 'hoantat',
                'thucnhan'  => $thucnhan,
                'amount'    => $amount,
                'ghichu'    => 'Sai mệnh giá -50%, mệnh giá thực '.format_cash($value),
                'capnhat'   => gettime()
            ], " `code` = '$request_id' ");
            $CMSNT->cong("users", "money", $thucnhan, " `username` = '".$row['username']."' ");
            $CMSNT->cong("users", "total_money", $thucnhan, " `username` = '".$row['username']."' ");
            /* CẬP NHẬT DÒNG TIỀN */
            $CMSNT->insert("dongtien", array(
                'sotientruoc'   => $getUser['money'],
                'sotienthaydoi' => $thucnhan,
                'sotiensau'     => $getUser['money'] + $thucnhan,
                'thoigian'      => gettime(),
                'noidung'       => 'Đổi thẻ seri ('.$serial.')',
                'username'      => $getUser['username']
            ));
            /**
             * XỬ LÝ HOA HỒNG CHO BẠN BÈ
             */
            if($getUser['ref'] != NULL)
            {
                if($CMSNT->site('status_ref') == 'ON')
                {
                    $hoahong = $value * $CMSNT->site('ck_ref') / 100;
                    $getUser_ref = $CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '".$getUser['ref']."' ");
                    /**
                     * CỘNG TIỀN CHO REFERRAL
                     */
                    $CMSNT->cong("users", "money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->cong("users", "total_money", $hoahong, " `username` = '".$getUser_ref['username']."' ");
                    $CMSNT->insert("dongtien", array(
                        'sotientruoc'   => $getUser_ref['money'],
                        'sotienthaydoi' => $hoahong,
                        'sotiensau'     => $getUser_ref['money'] + $hoahong,
                        'thoigian'      => gettime(),
                        'noidung'       => 'Hoa hồng bạn bè ('.$getUser['username'].')',
                        'username'      => $getUser_ref['username']
                    ));
                }
            }

            sendCallBack($row['callback'], $row['request_id'], 'thatbai', $thucnhan, $value);
            exit('Thẻ sai mệnh giá !');
        }
        $CMSNT->update("card_auto", [
            'amount'    => $amount,
            'trangthai' => 'thatbai',
            'ghichu'    => 'Thẻ không hợp lệ hoặc đã được sử dụng.',
            'capnhat'   => gettime()
        ], " `code` = '$request_id' ");

        sendCallBack($row['callback'], $row['request_id'], 'thatbai', 0, $value);
        exit('Thẻ không hợp lệ !');
    }







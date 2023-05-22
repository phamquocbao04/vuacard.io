<?php
    require_once(__DIR__."/config/config.php");
    require_once(__DIR__."/config/function.php");
    $title = 'HOME | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/public/client/Header.php");
    require_once(__DIR__."/public/client/Nav.php");
?>
<?php
if($CMSNT->site('status_ref') == 'ON'){
    if(isset($_GET['ref']) ){
        $ref_id = check_string($_GET['ref']);
        if($CMSNT->get_row("SELECT * FROM `users` WHERE `id` = '$ref_id' ")['ip'] != myip()){
            $CMSNT->cong("users", "ref_click", 1, " `id` = '$ref_id' ");
            $_SESSION['ref'] = check_string($_GET['ref']);
        }
        else{
            $_SESSION['ref'] = NULL;
        }
    }
}

if(empty($_SESSION['ref']))
{
    $_SESSION['ref'] = NULL;
}
?>

<?php if(getSite('display_carousel') == 'ON') { ?>
<div id="myCarousel" class="carousel slider slide" data-ride="carousel"
    style="background: <?=$CMSNT->site('theme_color');?>">
    <div class="container slide">
        <div class="carousel-inner">
            <div class="item active">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="https://i.imgur.com/5iS0szI.png"
                            alt="Tích hợp API gạch thẻ tự động cho Shop" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Tích hợp API gạch thẻ tự động cho Shop</h3>
                            <p class="hidden-xs" style="color: #ffffff">Cam kết không nuốt thẻ, không bảo trì, có nhân
                                viện trực hỗ trợ 24/24, rút tiền sau 1 phút. Hotline: <?=$CMSNT->site('hotline');?></p>
                            <a href="<?=BASE_URL('Ket-noi-api');?>" class="btn btn-warning text-uppercase hidden-xs">
                                Xem ngay </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="row">
                    <div class="col-sm-6 pull-right"><img src="https://i.imgur.com/5iS0szI.png"
                            alt="Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi" /></div>
                    <div class="col-sm-6">
                        <div class="slide-text">
                            <h3 style="color: #ffffff">Đổi thẻ cào thành tiền mặt nhanh chóng - tiện lợi</h3>
                            <p class="hidden-xs" style="color: #ffffff">Gạch thẻ siêu rẻ chiết khấu 15 - 20%. Rút free
                                phí về các ngân hàng Nội địa Việt Nam, Ví điện tử Momo</p>
                            <a href="" class="btn btn-warning text-uppercase hidden-xs"> Đổi Thẻ Ngay </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right"></span>
    </a>
</div>
<?php }?>
<section class="main">
        <div class="section">
            <div class="container">
                <div class="fullColumn">
                    <br>
                    <div class="blockContent">
                        

                        <div class="tabpage tab">
                            <div class="tab-content col-md-12 p-0">
                                <section class="main">

    <div class="blockContent">
        <div class=" right-seperate">
            <div class="card-game-panel">
                <h2 class="text-center" style="font-size: 30px">Đổi thẻ cào</h2>
                <style type="text/css">
        div.td-box{
          border-bottom: 1px solid #e5e8ed;
        }
        span.td-tag{
          background-color: #DC3545;
          color: #fff;
          margin: 0 8px 0 0;
          padding: 0 7px;
          font-size: 12px;
          line-height: 20px;
          white-space: nowrap;
          box-sizing: border-box;
          font-variant: tabular-nums;
          list-style: none;
          font-feature-settings: "tnum","tnum";
          display: inline-block;
          border: 1px solid #d9d9d9;
          border-radius: 4px;
          cursor: default;
          opacity: 1;
          transition: all .3s cubic-bezier(.78,.14,.15,.86);
        }
 
        div.td-content{
          padding: 0.5rem 0!important;
        }
        a.td-link{
          color: #5b6987;
          font-size: 12px;
          font-weight: 700;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
          cursor: pointer;
        }
        a.td-link:hover{
          color: #DC3545!important;
          text-decoration: underline;
          transition: all .2s;
        }
      </style>
                     <div class="container td-content">
          <center><span class="td-tag" style=""> Thông báo: </span> 
          <a class="td-link">
Đảm bảo chiết khấu thật, không nuốt thẻ vì chúng tôi không phải trung gian đổi thẻ. <font color="#CC0000"> <?=$CMSNT->site('tenweb');?> rút tiền miễn phí min 1k, rút về MOMO, ATM cực nhanh.</font></a></center><a class="td-link">
          </a>
      </div>
      </div>

                    <div class="section-heading_desc">
                        <div style="background:#eeeeee;border:1px solid #cccccc;padding:5px 10px;"><strong><em>►</em>&nbsp;Có thể bạn chưa biết: <?=$CMSNT->site('tenweb');?> gạch rút trong 3 giây nhanh hơn tốc độ lật mặt của nyc bạn!<img alt="" src="https://chat.lazi.vn/emoji/gif_lively/179.gif" style="height:10px; width:20px" /></strong>
                       
                         </div>
    <?=$CMSNT->site('thongbao');?>
 <br>
                                            <div id="thongbao"></div>
                                            <div class="form-frontpage form-sm" style="margin-top: 20px;">
                                                <form>
                                                    <div class="row-group">
                                                        <div id="list-taythecham">
                                                            <div class="irow row row-group"
                                                                style="margin-bottom: 10px;">
                                                                <div class="col-sm-3 select">
                                                                    <select id="loaithe" class="telco form-control">
                                                                        
                                                                    </select>
                                                                </div>
                                                                
                                                                <div class="col-sm-3">
                                                                    <input id="pin" style="color: red;" class="form-control" type="text"
                                                                        placeholder="Mã thẻ">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <input id="seri" style="color: purple;" class="form-control" type="text"
                                                                        placeholder="Seri">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <select id="menhgia" class="charging-amount form-control" data-row="1">
                                            <option value="0">Vui Lòng Chọn Loại Thẻ</option>
                                        </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="clear-fix"></div>
                                                        </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="token" value="<?=$getUser['token'];?>">
                                                        <div align="center" class="col-md-12">
                                                            <div class="clearfix"></div>
                                                            <button type="submit" id="NapTheAuto"
                                                                class="btn btn-warning btn-lg"><i class="fa fa-upload"
                                                                    aria-hidden="true"></i> GỬI THẺ CÀO
                                                            </button>
                                                        </div>
                                                       
                </div>
            </div>
            
                        <div class="col-md-12 table-responsive">
            <script type="text/javascript">
           
            
            $("#NapTheAuto").on("click", function() {
                $("#loading_box").show();
                 $('#NapTheAuto').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
                $.ajax({
                    url: "<?=BASE_URL("assets/ajaxs/NapThe.php");?>",
                    method: "POST",
                    data: {
                        type: 'NapTheAuto',
                        token: $("#token").val(),
                        seri: $("#seri").val(),
                        pin: $("#pin").val(),
                        loaithe: $("#loaithe").val(),
                        menhgia: $("#menhgia").val()
                    },
                    success: function(response) {
                        $("#loading_box").hide();
                        $("#thongbao").html(response);
                        $('#NapTheAuto').html(
                                '<i class="fa fa-upload" aria-hidden="true"></i> GỬI THẺ CÀO')
                            .prop('disabled', false);
                    }
                });
            });
            </script>
            <script type="text/javascript">
            $(document).ready(function() {
                setTimeout(e => {
                    GetCard24()
                }, 0)
            });
            function GetCard24() {
                $.ajax({
                    url: "<?=BASE_URL('api/loaithe.php');?>",
                    method: "GET",
                    success: function(response) {
                        $("#loaithe").html(response);
                    }
                });
            }
            </script>
            <script type="text/javascript">
            $('#loaithe').change(function() {
                $.ajax({
                    url: "<?=BASE_URL("assets/ajaxs/menhgia.php");?>",
                    method: "GET",
                    data: {
                        loaithe: $("#loaithe").val()
                    },
                    success: function(response) {
                        $("#menhgia").html(response);
                    }
                });
            });
            </script>
            <script type="text/javascript">
            $('#menhgia').change(function() {
                var ketqua = 'Đang tính thực nhận';
                document.getElementById("thucnhan").value = (ketqua.toString().replace(
                    /(.)(?=(\d{3})+$)/g, '$1.'));
                $.ajax({
                    url: "<?=BASE_URL("assets/ajaxs/thucnhan.php");?>",
                    method: "GET",
                    data: {
                        loaithe: $("#loaithe").val(),
                        menhgia: $("#menhgia").val()
                    },
                    success: function(response) {
                        var ketqua = response;
                        document.getElementById("thucnhan").value = (ketqua.toString().replace(
                            /(.)(?=(\d{3})+$)/g, '$1.') + 'đ');
                    }
                });
            });
 
                         </script>
              
           
            <section class="main softcard-page">
                <div class="blockContent row">
                    <div class="col-sm-12">
                        <h1 class="text-center" style="font-size: 20px;font-weight:bold">BẢNG PHÍ ĐỔI THẺ CÀO</h1>
                    </div>
                                                            
                    <div class="panel-body">
                        <div class="tabpage" id="bang-phi">
                            <ul class="nav nav-tabs">
                                <?php foreach($list_loaithe as $loaithe) { ?>
                                <li class="<?=$loaithe == 'VIETTEL' ? 'active' : '';?>">
                                    <a data-toggle="tab" href="#discount-<?=$loaithe;?>">
                                        <span class="title" style="color: <?=$CMSNT->site('theme_color');?>"><b><?=$loaithe;?></b></span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                            <div class="tab-content" style="padding-top: 20px;">
                                <?php foreach($list_loaithe as $loaithe) { ?>
                                <div class="table-responsive tab-pane fadess in  <?=$loaithe == 'VIETTEL' ? 'active' : '';?>"
                                    id="discount-<?=$loaithe;?>">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Nhóm thành viên
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 10,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 20,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 30,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 50,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 100,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 200,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 300,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ 500,000đ
                                                </th>
                                                <th class="text-center" style="color: <?=$CMSNT->site('theme_color');?>">Thẻ
                                                    1,000,000đ</b>
                                                </th>
                                            </tr>
                                        </thead>
                                         <tbody class="text-center">
                                            
                                            </tr>
                                                                                                <tr class="text-center"style="color: red">
                                                        
                                                <td><b><span class="label label-info copy">Thành viên/Api</b></td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '10000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '20000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '30000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '50000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '100000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '200000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '300000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '500000' ")['ck'];?>%</b>
                                                </td>
                                                <td><b><?=$CMSNT->get_row("SELECT * FROM `ck_card_auto` WHERE `loaithe` = '$loaithe' AND `menhgia` = '1000000' ")['ck'];?>%</b>
                                                
                                              
                                            
                                               </tr>
                                        </tbody>
                                    </table>
                                </div>
                                
                           <?php }?>       
                            </div>
                        </div>
       
</div>
</div>   
                                </div>
                            </div>
                        </div>
                    </div>
    <section class="main softcard-page">
                <div class="blockContent row">
                    <div class="col-sm-12">
                        <h1 class="text-center" style="font-size: 20px;font-weight:bold">Mua mã thẻ</h1>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Viettel.png" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Viettel</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Mobifone.png" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Vinaphone</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Vinaphone.png" alt="Vinaphone" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Vietnamobile</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Vietnamobile.png" alt="Vietnamobile" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Zing</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Zing.png" alt="Zing" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Viettel</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Gate.png" alt="Gate" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Gate</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Garena.png" alt="Garena" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Garena</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Vcoin.png" alt="Vcoin" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Vcoin</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Scoin.png" alt="Scoin" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Scoin</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Kul.png" alt="Kul" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Kul</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Funcard.png" alt="Funcard" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Funcard</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Appota.png" alt="Appota" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Appota</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Soha.png" alt="Soha" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Soha</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Goku.png" alt="Goku" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Goku</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Oncash.png" alt="Oncash" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Oncash</b></div>
                                    </a>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <div class="thumbnail" style="margin-bottom: 10px; margin-top: 20px;">
                                        <a href="/BuyCard">
                                            <img src="https://trumgachcard.pro/Assets/images/the-cao/the-Vega.png" alt="Vega" style="height: 60px; width: auto">
                                        </a>
                                    </div>
                                    <a href="/BuyCard" style="color: black">
                                        <div class="text-center"><b> Thẻ Vega</b></div>
                                    </a>
                                </tr>
                                                
                                </div>
                            </div>
                        </div>
                    </div>
               

<script type="text/javascript">
$("#UpdateHistory").on('change', function() {
    if (document.getElementById('UpdateHistory').checked == true) {
        PlaySound('tu_dong_cap_nhat_ket_qua_dang_duoc_bat');

        function loadHistoryCard() {
            $.ajax({
                url: "<?=BASE_URL('assets/ajaxs/loadHistoryCard.php');?>",
                type: "GET",
                dateType: "text",
                data: {

                },
                success: function(result) {
                    $('#loadHistoryCard').html(result);
                }
            });
        }
        var refreshIntervalId = setInterval(function() {
            $('#loadHistoryCard').load(loadHistoryCard());
        }, 3000);

    } else {
        PlaySound('assets/sound/vui_long_tai_lai_trang.mp3');
        clearInterval(refreshIntervalId);
    }
});
</script>

<script>
function PlaySound(type) {
    var audio = new Audio('<?=BASE_URL('assets/sound/click.mp3');?>');
    audio.pause();
    audio.play();
}
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
});
</script>
<?php 
    require_once(__DIR__."/public/client/Footer.php");
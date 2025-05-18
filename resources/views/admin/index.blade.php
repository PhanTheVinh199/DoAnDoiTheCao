@include('admin.sidebar');
<div class="main" style="margin-top: 100px; padding: 30px; ">
  <div class="container">
    <div class="row d-flex">
      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Thành viên</h4>
          <h2 style="color:red; margin-top:30px;">{{ $memberCount }}</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>👥</p>
            <a href="{{ route('admin.thanhvien.danhsach') }}" style="font-size: 20px; position: absolute;">Chi tiết</a>
          </div>
          
        </div>
      </div>

      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Đơn Đổi Thẻ (Chờ xử lý <span style="color:red;">{{$exchangePending}}</span>) </h4>
          <h2 style="color: red; margin-top: 30px;">{{$exchangeCount }}</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>🛒</p>
            <a href="{{ route('admin.doithecao.donhang.index') }}" style="font-size: 20px; position: absolute;">Chi tiết</a>
          </div>
        </div>
      </div>

      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Đơn Mua Thẻ (Chờ xử lý <span style="color:red;">{{$purchasePending}}</span>) </h4>
          <h2 style="color: red; margin-top: 30px;">{{$purchaseCount}}</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>🛒</p>
            <a href="{{route('admin.mathecao.donhang.index')}}" style="font-size: 20px; position: absolute;">Chi tiết</a>
          </div>
        </div>
      </div>
    </div> <br>
    <div class="row d-flex">
      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Đơn nạp tiền(Chờ duyệt <span style="color:red;">{{$depositCountPending}}</span>)</h4>
          <h2 style="color: red; margin-top: 30px;">{{ $depositCount}}</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>💵</p>
            <a href="{{ route('admin.nganhang.naptien.index') }}" style="font-size: 20px; position: absolute;">Chi tiết</a>
          </div>
        </div>
      </div>

      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Đơn rút tiền (Chờ duyệt <span style="color:red;">{{$withdrawPending}}</span>)</h4>
          <h2 style="color: red; margin-top: 30px;">{{$withdrawCount }}</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>💲</p>
            <a href="{{ route('admin.nganhang.ruttien.index') }}" style="font-size: 20px; position: absolute;">Chi tiết</a>
          </div>
        </div>
      </div>

      <div class="col-4  ">
        <div class="card-body  main-thongke" style="width:350px; height: 120px">
          <h4 class="card-title">Tổng Doanh Thu</h4>
          <h2 style="color: red; margin-top: 30px;">{{$revenueTotal}} VND</h2>
          <div class="main-coin" style="margin-left: 80%; margin-top: -25%; font-size: 30px;">
            <p>💎</p>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
</div>
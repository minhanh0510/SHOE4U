<style>
.history-page{padding:40px 0 80px;background:var(--bg);}
.page-head{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:14px;}
.page-head h2{font-family:'Sora',sans-serif;font-size:26px;font-weight:800;color:var(--navy);display:flex;align-items:center;gap:10px;}
.page-head h2 i{color:var(--blue);}
.stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px;}
.stat-card{background:#fff;border:1.5px solid var(--border);border-radius:var(--radius-lg);padding:18px 20px;text-align:center;border-top:3px solid;transition:var(--trans);box-shadow:0 2px 10px rgba(62,182,232,.06);}
.stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow);}
.sc-all     {border-top-color:var(--blue);}
.sc-pending {border-top-color:var(--warning);}
.sc-shipping{border-top-color:#5B9BD5;}
.sc-done    {border-top-color:var(--success);}
.stat-num{font-family:'Sora',sans-serif;font-size:30px;font-weight:800;color:var(--navy);}
.stat-lbl{font-size:12px;color:var(--muted);margin-top:2px;font-weight:600;}
.filter-tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px;}
.ftab{padding:8px 18px;border:1.5px solid var(--border);border-radius:20px;background:#fff;font-size:13px;font-weight:700;cursor:pointer;color:var(--sub);transition:var(--trans);}
.ftab:hover,.ftab.active{border-color:var(--blue);background:var(--blue-light);color:var(--blue);}
/* Table */
.orders-card{background:#fff;border:1.5px solid var(--border);border-radius:var(--radius-xl);overflow:hidden;box-shadow:0 4px 20px rgba(62,182,232,.07);}
.orders-table{width:100%;border-collapse:collapse;}
.orders-table thead{background:linear-gradient(135deg,var(--navy),var(--navy2));}
.orders-table thead th{padding:14px 18px;text-align:left;font-size:12px;font-weight:700;color:rgba(255,255,255,.7);letter-spacing:.5px;text-transform:uppercase;}
.orders-table tbody tr{border-bottom:1px solid var(--bg);transition:background .15s;}
.orders-table tbody tr:hover{background:var(--blue-light);}
.orders-table tbody tr:last-child{border-bottom:none;}
.orders-table td{padding:14px 18px;font-size:13px;color:var(--text);vertical-align:middle;}
.order-id{font-family:'Sora',sans-serif;font-weight:700;color:var(--navy);font-size:14px;}
.price-cell{font-weight:700;color:var(--blue-dark);}
.btn-detail{padding:6px 16px;background:var(--blue-light);color:var(--blue-dark);border:1.5px solid #B8DFF0;border-radius:8px;font-size:12px;font-weight:700;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:var(--trans);}
.btn-detail:hover{background:var(--blue);color:#fff;border-color:var(--blue);}
.empty-state{text-align:center;padding:80px 20px;background:#fff;border-radius:var(--radius-xl);border:1.5px solid var(--border);}
.empty-state i{font-size:60px;color:var(--border);margin-bottom:16px;display:block;}
.empty-state h3{font-family:'Sora',sans-serif;font-size:20px;color:var(--navy);margin-bottom:8px;}
.empty-state p{color:var(--muted);font-size:14px;margin-bottom:24px;}
@media(max-width:768px){.stats-strip{grid-template-columns:repeat(2,1fr);}.orders-table{font-size:12px;}.orders-table td,.orders-table th{padding:10px 12px;}}
@media(max-width:480px){.orders-table thead{display:none;}.orders-table td{display:block;padding:8px 16px;}.orders-table tr{display:block;border:1.5px solid var(--border);border-radius:var(--radius);margin-bottom:12px;}}
</style>

<?php
$total_all       = count($orders);
$total_pending   = count(array_filter($orders, fn($o)=>$o['status']==='Pending'));
$total_shipping  = count(array_filter($orders, fn($o)=>$o['status']==='Shipping'));
$total_completed = count(array_filter($orders, fn($o)=>$o['status']==='Completed'));
?>

<div class="history-page">
  <div class="container">
    <div class="page-head">
      <h2><i class="fas fa-box-open"></i> Đơn hàng của tôi</h2>
      <a href="index.php?controller=product&action=category" class="btn-primary" style="padding:10px 20px;font-size:13px;"><i class="fas fa-shopping-bag"></i> Mua sắm thêm</a>
    </div>

    <div class="stats-strip">
      <div class="stat-card sc-all">     <div class="stat-num"><?= $total_all ?></div>      <div class="stat-lbl">Tất cả</div></div>
      <div class="stat-card sc-pending"> <div class="stat-num"><?= $total_pending ?></div>  <div class="stat-lbl">Chờ xử lý</div></div>
      <div class="stat-card sc-shipping"><div class="stat-num"><?= $total_shipping ?></div> <div class="stat-lbl">Đang giao</div></div>
      <div class="stat-card sc-done">    <div class="stat-num"><?= $total_completed ?></div><div class="stat-lbl">Hoàn thành</div></div>
    </div>

    <div class="filter-tabs">
      <button class="ftab active" onclick="filterOrders('all',this)">Tất cả (<?= $total_all ?>)</button>
      <button class="ftab" onclick="filterOrders('Pending',this)">⏳ Chờ xử lý</button>
      <button class="ftab" onclick="filterOrders('Shipping',this)">🚚 Đang giao</button>
      <button class="ftab" onclick="filterOrders('Completed',this)">✅ Hoàn thành</button>
      <button class="ftab" onclick="filterOrders('Cancelled',this)">❌ Đã huỷ</button>
    </div>

    <?php if (empty($orders)): ?>
    <div class="empty-state">
      <i class="fas fa-shopping-bag"></i>
      <h3>Chưa có đơn hàng nào</h3>
      <p>Bắt đầu khám phá và mua những đôi giày bạn yêu thích!</p>
      <a href="index.php?controller=product&action=category" class="btn-primary" style="display:inline-flex;"><i class="fas fa-shopping-cart"></i> Mua sắm ngay</a>
    </div>
    <?php else: ?>
    <div class="orders-card">
      <table class="orders-table" id="ordersTable">
        <thead><tr>
          <th>Mã đơn</th><th>Ngày đặt</th><th>Tổng tiền</th>
          <th>Trạng thái</th><th>Thanh toán</th><th>Thao tác</th>
        </tr></thead>
        <tbody>
        <?php
        $statusMap=['Pending'=>['status-pending','⏳ Chờ xử lý'],'Shipping'=>['status-shipping','🚚 Đang giao'],'Completed'=>['status-completed','✅ Hoàn thành'],'Cancelled'=>['status-cancelled','❌ Đã huỷ']];
        foreach($orders as $o):
          $sb=$statusMap[$o['status']]??['status-pending',$o['status']];
          $pm=$o['payment_method']??'COD'; $ps=$o['payment_status']??'Unpaid';
        ?>
        <tr data-status="<?= $o['status'] ?>">
          <td><span class="order-id">#<?= str_pad($o['order_id'],6,'0',STR_PAD_LEFT) ?></span></td>
          <td><?= date('d/m/Y H:i',strtotime($o['created_at'])) ?></td>
          <td><span class="price-cell"><?= number_format($o['total_price'],0,',','.') ?>đ</span></td>
          <td><span class="status-badge <?= $sb[0] ?>"><?= $sb[1] ?></span></td>
          <td>
            <span class="status-badge" style="background:<?= $pm==='Momo'?'#FDF0F7':'#EFF7FD' ?>;color:<?= $pm==='Momo'?'#9A2070':'#1A5E96' ?>;border-color:<?= $pm==='Momo'?'#F0C0E0':'#A8D2F0' ?>;">
              <?= $pm==='Momo'?'📱 MoMo':'💵 COD' ?>
            </span>
            <span class="status-badge <?= $ps==='Paid'?'status-paid':'status-unpaid' ?>" style="margin-top:4px;">
              <?= $ps==='Paid'?'✓ Đã TT':'Chưa TT' ?>
            </span>
          </td>
          <td><a href="index.php?controller=order&action=detail&id=<?= $o['order_id'] ?>" class="btn-detail"><i class="fas fa-eye"></i> Chi tiết</a></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</div>
<script>
function filterOrders(s,btn){
  document.querySelectorAll('.ftab').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  document.querySelectorAll('#ordersTable tbody tr').forEach(r=>r.style.display=(s==='all'||r.dataset.status===s)?'':'none');
}
</script>

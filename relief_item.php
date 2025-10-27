<?php
$PAGE_TITLE = "Relief Item • Create & List";
include 'db_connect.php';
$msg=null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $item = $_POST['item_name'] ?? '';
  $qty  = (int)($_POST['quantity'] ?? 0);

  $stmt = $conn->prepare("INSERT INTO Relief_Item (Item_Name, Quantity) VALUES (?,?)");
  $stmt->bind_param("si",$item,$qty);
  $ok = $stmt->execute();
  $msg = $ok ? ['success','Item added.'] : ['error','Failed to add item.'];
  $stmt->close();
}

include 'header.php';
?>

<section class="card">
  <h2>Add Relief Item</h2>
  <?php if($msg): ?><div class="msg <?= $msg[0]==='success'?'success':'error' ?>"><?= htmlspecialchars($msg[1]) ?></div><?php endif; ?>
  <form method="post" class="grid cols-2">
    <div class="input"><label>Item Name</label><input name="item_name" placeholder="e.g., Rice / Water Bottle" required></div>
    <div class="input"><label>Quantity</label><input type="number" name="quantity" min="0" placeholder="e.g., 1000" required></div>
    <div style="grid-column:1/-1;display:flex;gap:10px">
      <button class="btn-primary" type="submit">Save</button>
      <a class="btn-soft" href="index.php"><button type="button">Back</button></a>
    </div>
  </form>
</section>

<br>

<section class="card">
  <h2>Relief Items</h2>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Quantity</th></tr></thead>
      <tbody>
        <?php
          $res=$conn->query("SELECT * FROM Relief_Item ORDER BY Item_ID DESC");
          while($res && $row=$res->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['Item_ID']) ?></td>
          <td><?= htmlspecialchars($row['Item_Name']) ?></td>
          <td><?= htmlspecialchars($row['Quantity']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

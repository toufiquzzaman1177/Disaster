<?php
$PAGE_TITLE = "Distribution • Record & List";
include 'db_connect.php';
$msg=null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $victim_id = (int)($_POST['victim_id'] ?? 0);
  $center_id = (int)($_POST['center_id'] ?? 0);
  $item_id   = (int)($_POST['item_id'] ?? 0);
  $date      = $_POST['date'] ?? '';

  $stmt = $conn->prepare("INSERT INTO Distribution (Victim_ID, Center_ID, Item_ID, Date_Distributed) VALUES (?,?,?,?)");
  $stmt->bind_param("iiis",$victim_id,$center_id,$item_id,$date);
  $ok = $stmt->execute();
  $msg = $ok ? ['success','Distribution recorded.'] : ['error','Failed to record distribution.'];
  $stmt->close();
}

include 'header.php';
?>

<section class="card">
  <h2>Add Distribution</h2>
  <?php if($msg): ?><div class="msg <?= $msg[0]==='success'?'success':'error' ?>"><?= htmlspecialchars($msg[1]) ?></div><?php endif; ?>
  <form method="post" class="grid cols-2">
    <div class="input">
      <label>Victim</label>
      <select name="victim_id" required>
        <option value="">Select Victim</option>
        <?php $v=$conn->query("SELECT Victim_ID, Name, Location FROM Victim ORDER BY Victim_ID DESC");
        while($v && $row=$v->fetch_assoc()): ?>
          <option value="<?= (int)$row['Victim_ID'] ?>"><?= htmlspecialchars($row['Name'].' • '.$row['Location']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="input">
      <label>Relief Center</label>
      <select name="center_id" required>
        <option value="">Select Center</option>
        <?php $c=$conn->query("SELECT Center_ID, Name FROM Relief_Center ORDER BY Center_ID DESC");
        while($c && $row=$c->fetch_assoc()): ?>
          <option value="<?= (int)$row['Center_ID'] ?>"><?= htmlspecialchars($row['Name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="input">
      <label>Item</label>
      <select name="item_id" required>
        <option value="">Select Item</option>
        <?php $i=$conn->query("SELECT Item_ID, Item_Name FROM Relief_Item ORDER BY Item_ID DESC");
        while($i && $row=$i->fetch_assoc()): ?>
          <option value="<?= (int)$row['Item_ID'] ?>"><?= htmlspecialchars($row['Item_Name']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="input">
      <label>Date Distributed</label>
      <input type="date" name="date" required>
    </div>

    <div style="grid-column:1/-1;display:flex;gap:10px">
      <button class="btn-primary" type="submit">Save</button>
      <a class="btn-soft" href="index.php"><button type="button">Back</button></a>
    </div>
  </form>
</section>

<br>

<section class="card">
  <h2>Distribution List</h2>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Victim</th><th>Center</th><th>Item</th><th>Date</th></tr></thead>
      <tbody>
        <?php
          $q="SELECT d.Distribution_ID, v.Name Victim, rc.Name Center, ri.Item_Name Item_Name, d.Date_Distributed
              FROM Distribution d
              JOIN Victim v ON d.Victim_ID=v.Victim_ID
              JOIN Relief_Center rc ON d.Center_ID=rc.Center_ID
              JOIN Relief_Item ri ON d.Item_ID=ri.Item_ID
              ORDER BY d.Distribution_ID DESC";
          $res=$conn->query($q);
          while($res && $row=$res->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['Distribution_ID']) ?></td>
          <td><?= htmlspecialchars($row['Victim']) ?></td>
          <td><?= htmlspecialchars($row['Center']) ?></td>
          <td><?= htmlspecialchars($row['Item_Name']) ?></td>
          <td><?= htmlspecialchars($row['Date_Distributed']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

<?php
$PAGE_TITLE = "Relief Center • Create & List";
include 'db_connect.php';
$msg=null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = $_POST['name'] ?? '';
  $location = $_POST['location'] ?? '';
  $capacity = (int)($_POST['capacity'] ?? 0);

  $stmt = $conn->prepare("INSERT INTO Relief_Center (Name, Location, Capacity) VALUES (?,?,?)");
  $stmt->bind_param("ssi",$name,$location,$capacity);
  $ok = $stmt->execute();
  $msg = $ok ? ['success','Center added.'] : ['error','Failed to add center.'];
  $stmt->close();
}

include 'header.php';
?>

<section class="card">
  <h2>Add Relief Center</h2>
  <?php if($msg): ?><div class="msg <?= $msg[0]==='success'?'success':'error' ?>"><?= htmlspecialchars($msg[1]) ?></div><?php endif; ?>
  <form method="post" class="grid cols-2">
    <div class="input"><label>Center Name</label><input name="name" placeholder="e.g., Dhaka Central Relief Center" required></div>
    <div class="input"><label>Location</label><input name="location" placeholder="e.g., Dhaka" required></div>
    <div class="input"><label>Capacity</label><input type="number" name="capacity" min="0" placeholder="e.g., 500" required></div>
    <div style="grid-column:1/-1;display:flex;gap:10px">
      <button class="btn-primary" type="submit">Save</button>
      <a class="btn-soft" href="index.php"><button type="button">Back</button></a>
    </div>
  </form>
</section>

<br>

<section class="card">
  <h2>Relief Centers</h2>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Location</th><th>Capacity</th></tr></thead>
      <tbody>
        <?php
          $res=$conn->query("SELECT * FROM Relief_Center ORDER BY Center_ID DESC");
          while($res && $row=$res->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['Center_ID']) ?></td>
          <td><?= htmlspecialchars($row['Name']) ?></td>
          <td><?= htmlspecialchars($row['Location']) ?></td>
          <td><?= htmlspecialchars($row['Capacity']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

<?php
$PAGE_TITLE = "Victim • Register & List";
include 'db_connect.php';
$msg=null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $name = $_POST['name'] ?? '';
  $age  = (int)($_POST['age'] ?? 0);
  $location = $_POST['location'] ?? '';
  $disaster_id = (int)($_POST['disaster_id'] ?? 0);

  $stmt = $conn->prepare("INSERT INTO Victim (Name, Age, Location, Disaster_ID) VALUES (?,?,?,?)");
  $stmt->bind_param("sisi",$name,$age,$location,$disaster_id);
  $ok = $stmt->execute();
  $msg = $ok ? ['success','Victim registered.'] : ['error','Failed to register victim.'];
  $stmt->close();
}

include 'header.php';
?>

<section class="card">
  <h2>Add Victim</h2>
  <?php if($msg): ?><div class="msg <?= $msg[0]==='success'?'success':'error' ?>"><?= htmlspecialchars($msg[1]) ?></div><?php endif; ?>
  <form method="post" class="grid cols-2">
    <div class="input"><label>Name</label><input name="name" placeholder="Full name" required></div>
    <div class="input"><label>Age</label><input type="number" name="age" min="0" placeholder="Age" required></div>
    <div class="input"><label>Location</label><input name="location" placeholder="e.g., Kurigram" required></div>
    <div class="input">
      <label>Disaster</label>
      <select name="disaster_id" required>
        <option value="">Select Disaster</option>
        <?php
          $d=$conn->query("SELECT Disaster_ID, Type, Location FROM Disaster ORDER BY Disaster_ID DESC");
          while($d && $row=$d->fetch_assoc()):
        ?>
          <option value="<?= (int)$row['Disaster_ID'] ?>"><?= htmlspecialchars($row['Type'].' • '.$row['Location']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div style="grid-column:1/-1;display:flex;gap:10px">
      <button class="btn-primary" type="submit">Save</button>
      <a class="btn-soft" href="index.php"><button type="button">Back</button></a>
    </div>
  </form>
</section>

<br>

<section class="card">
  <h2>Victim List</h2>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Name</th><th>Age</th><th>Location</th><th>Disaster</th></tr></thead>
      <tbody>
        <?php
          $q="SELECT v.Victim_ID, v.Name, v.Age, v.Location, d.Type
              FROM Victim v JOIN Disaster d ON v.Disaster_ID=d.Disaster_ID
              ORDER BY v.Victim_ID DESC";
          $res=$conn->query($q);
          while($res && $row=$res->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['Victim_ID']) ?></td>
          <td><?= htmlspecialchars($row['Name']) ?></td>
          <td><?= htmlspecialchars($row['Age']) ?></td>
          <td><?= htmlspecialchars($row['Location']) ?></td>
          <td><span class="badge"><?= htmlspecialchars($row['Type']) ?></span></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

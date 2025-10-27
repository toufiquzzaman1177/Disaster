<?php
$PAGE_TITLE = "Disaster • Create & List";
include 'db_connect.php';
$msg = null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $type = $_POST['type'] ?? '';
  $location = $_POST['location'] ?? '';
  $date = $_POST['date'] ?? '';
  $severity = $_POST['severity'] ?? '';
  $stmt = $conn->prepare("INSERT INTO Disaster (Type, Location, Date, Severity_Level) VALUES (?,?,?,?)");
  $stmt->bind_param("ssss",$type,$location,$date,$severity);
  $ok = $stmt->execute();
  $msg = $ok ? ['success','Disaster added successfully.'] : ['error','Failed to add disaster.'];
  $stmt->close();
}

include 'header.php';
?>

<section class="card">
  <h2>Add Disaster</h2>
  <?php if($msg): ?>
    <div class="msg <?= $msg[0]==='success'?'success':'error' ?>"><?= htmlspecialchars($msg[1]) ?></div>
  <?php endif; ?>
  <form method="post" class="grid cols-2">
    <div class="input">
      <label>Type</label>
      <input name="type" placeholder="Flood / Cyclone / Fire" required>
    </div>
    <div class="input">
      <label>Location</label>
      <input name="location" placeholder="e.g., Dhaka" required>
    </div>
    <div class="input">
      <label>Date</label>
      <input type="date" name="date" required>
    </div>
    <div class="input">
      <label>Severity Level</label>
      <input name="severity" placeholder="Low / Medium / High" required>
    </div>
    <div style="grid-column:1/-1;display:flex;gap:10px">
      <button class="btn-primary" type="submit">Save</button>
      <a class="btn-soft" href="index.php"><button type="button">Back</button></a>
    </div>
  </form>
</section>

<br>

<section class="card">
  <h2>All Disasters</h2>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Type</th><th>Location</th><th>Date</th><th>Severity</th></tr></thead>
      <tbody>
        <?php
          $res = $conn->query("SELECT * FROM Disaster ORDER BY Disaster_ID DESC");
          while($r = $res && $row=$res->fetch_assoc()):
        ?>
        <tr>
          <td><?= htmlspecialchars($row['Disaster_ID']) ?></td>
          <td><?= htmlspecialchars($row['Type']) ?></td>
          <td><?= htmlspecialchars($row['Location']) ?></td>
          <td><?= htmlspecialchars($row['Date']) ?></td>
          <td><span class="badge"><?= htmlspecialchars($row['Severity_Level']) ?></span></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

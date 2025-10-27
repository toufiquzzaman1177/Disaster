<?php $PAGE_TITLE = "Dashboard • Disaster Relief"; include 'db_connect.php'; include 'header.php'; ?>

<div class="grid cols-2">
  <section class="card">
    <h2>Quick Add</h2>
    <p class="sub">Start by adding disasters, centers, victims & items.</p>
    <div class="grid cols-2" style="margin-top:10px">
      <a class="btn-soft" href="disaster.php"><button class="btn-primary" type="button">Add Disaster</button></a>
      <a class="btn-soft" href="victim.php"><button class="btn-primary" type="button">Add Victim</button></a>
      <a class="btn-soft" href="relief_center.php"><button class="btn-primary" type="button">Add Center</button></a>
      <a class="btn-soft" href="relief_item.php"><button class="btn-primary" type="button">Add Item</button></a>
    </div>
  </section>

  <section class="card">
    <h2>At a Glance</h2>
    <div class="grid cols-2">
      <?php
        function countRows($conn,$table){ $r=$conn->query("SELECT COUNT(*) c FROM $table"); return $r?$r->fetch_assoc()['c']:0; }
      ?>
      <div><div class="sub">Disasters</div><div class="badge"><?= countRows($conn,'Disaster') ?></div></div>
      <div><div class="sub">Victims</div><div class="badge"><?= countRows($conn,'Victim') ?></div></div>
      <div><div class="sub">Centers</div><div class="badge"><?= countRows($conn,'Relief_Center') ?></div></div>
      <div><div class="sub">Items</div><div class="badge"><?= countRows($conn,'Relief_Item') ?></div></div>
    </div>
  </section>
</div>

<br>
<section class="card">
  <h2>Recent Distributions</h2>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Victim</th><th>Center</th><th>Item</th><th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php
        $q = "SELECT d.Distribution_ID, v.Name Victim, rc.Name Center, ri.Item_Name Item_Name, d.Date_Distributed
              FROM Distribution d
              JOIN Victim v ON v.Victim_ID=d.Victim_ID
              JOIN Relief_Center rc ON rc.Center_ID=d.Center_ID
              JOIN Relief_Item ri ON ri.Item_ID=d.Item_ID
              ORDER BY d.Distribution_ID DESC LIMIT 10";
        if($res = $conn->query($q)):
          while($row=$res->fetch_assoc()):
      ?>
        <tr>
          <td><?= htmlspecialchars($row['Distribution_ID']) ?></td>
          <td><?= htmlspecialchars($row['Victim']) ?></td>
          <td><?= htmlspecialchars($row['Center']) ?></td>
          <td><?= htmlspecialchars($row['Item_Name']) ?></td>
          <td><?= htmlspecialchars($row['Date_Distributed']) ?></td>
        </tr>
      <?php endwhile; endif; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include 'footer.php'; ?>

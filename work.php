<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Work Showcase</title>
  <link rel="stylesheet" href="styles.css" />
  
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.html">หน้าแรก</a></li>
            <li><a href="about-me.html">เกี่ยวกับฉัน</a></li>
            <li><a href="work.php">ผลงาน</a></li>
            <li><a href="contract.html">ติดต่อ</a></li>
            <li><a href="register.html">ลงสมัคร</a></li>
        </ul>
    </nav>

  <main>
    <section class="work-grid">
      <?php
        $sql = "SELECT * FROM work ORDER BY upload_date DESC LIMIT 4";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $id = $row['id'];
            $filename = htmlspecialchars($row['filename']);
            $title = htmlspecialchars($row['title'] ?? '');
            $description = htmlspecialchars($row['description'] ?? '');
            echo "<div class='work-item'>
                    <img src='uploads/$filename' alt='Work' class='preview-img' data-src='uploads/$filename'>
                    <h3>$title</h3>
                    <p>$description</p>
                    <form method='post' action='delete.php' onsubmit='return confirm(\"ยืนยันการลบ?\")'>
                      <input type='hidden' name='id' value='$id'>
                      <button type='submit'>ลบ</button>
                    </form>
                  </div>";
          }
        } else {
          echo "<p>No work uploaded yet.</p>";
        }
      ?>
    </section>

    <section class="upload-section">
      <h2>Upload New Work</h2>
      <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="ชื่อผลงาน" required />
        <textarea name="description" placeholder="คำอธิบายผลงาน" required></textarea>
        <input type="file" name="fileToUpload" required />
        <button type="submit">Upload</button>
      </form>
    </section>
  </main>

  <div id="imageModal" class="modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImage">
  </div>

  <script>
    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const closeBtn = document.querySelector(".modal-close");

    document.querySelectorAll(".preview-img").forEach(img => {
      img.addEventListener("click", () => {
        modal.style.display = "block";
        modalImg.src = img.dataset.src;
      });
    });

    closeBtn.onclick = () => modal.style.display = "none";
    window.onclick = (e) => { if (e.target == modal) modal.style.display = "none"; };
  </script>
</body>
</html>
<?php $conn->close(); ?>

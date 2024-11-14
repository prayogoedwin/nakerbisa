<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTER NAKERBISA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #339BF1;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      width: 100%;
    }
    .step-indicator {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }
    .step-indicator .circle {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #ddd;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #000;
      font-weight: bold;
    }
    .step-indicator .circle.active {
      background-color: #005c99;
      color: #fff;
    }
    .btn-primary {
      background-color: #005c99;
      border-color: #005c99;
    }
    .btn-primary:hover {
      background-color: #00487a;
      border-color: #00487a;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center mb-4">Register</h2>
    <div class="step-indicator">
      <div class="circle active" data-step="1">1</div>
      <div class="circle" data-step="2">2</div>
      <div class="circle" data-step="3">3</div>
    </div>
    <form id="registrationForm">
      <!-- Step 1 -->
      <div class="step" id="step1">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" required>
        </div>
        <div class="mb-3">
          <label for="whatsapp" class="form-label">WhatsApp</label>
          <input type="text" class="form-control" id="whatsapp" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" required>
        </div>
        <button type="button" class="btn btn-primary w-100 mt-3" onclick="nextStep()">Next</button>
      </div>

      <!-- Step 2 -->
      <div class="step d-none" id="step2">
        <div class="mb-3">
          <label for="pin" class="form-label">PIN</label>
          <input type="password" class="form-control" id="pin" maxlength="6" required>
        </div>
        <button type="button" class="btn btn-secondary w-100 mt-3" onclick="previousStep()">Back</button>
        <button type="button" class="btn btn-primary w-100 mt-3" onclick="nextStep()">Next</button>
      </div>

      <!-- Step 3 -->
      <div class="step d-none" id="step3">
        <div class="mb-3">
          <label for="fullName" class="form-label">Nama Lengkap</label>
          <input type="text" class="form-control" id="fullName" required>
        </div>
        <div class="mb-3">
          <label for="nik" class="form-label">NIK</label>
          <input type="text" class="form-control" id="nik" required>
        </div>
        <div class="mb-3">
          <label for="birthDate" class="form-label">Tanggal Lahir</label>
          <input type="date" class="form-control" id="birthDate" required>
        </div>
        <div class="mb-3">
          <label for="birthPlace" class="form-label">Tempat Lahir</label>
          <input type="text" class="form-control" id="birthPlace" required>
        </div>
        <div class="mb-3">
          <label for="city" class="form-label">Kota Domisili</label>
          <input type="text" class="form-control" id="city" required>
        </div>
        <div class="mb-3">
          <label for="district" class="form-label">Kecamatan</label>
          <select class="form-select" id="district" required>
            <option selected disabled>Pilih Kecamatan</option>
            <option value="Kecamatan 1">Kecamatan 1</option>
            <option value="Kecamatan 2">Kecamatan 2</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="village" class="form-label">Kelurahan</label>
          <select class="form-select" id="village" required>
            <option selected disabled>Pilih Kelurahan</option>
            <option value="Kelurahan 1">Kelurahan 1</option>
            <option value="Kelurahan 2">Kelurahan 2</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="postalCode" class="form-label">Kode Pos</label>
          <input type="text" class="form-control" id="postalCode" required>
        </div>
        <div class="mb-3">
          <label for="fullAddress" class="form-label">Alamat Lengkap</label>
          <textarea class="form-control" id="fullAddress" rows="3" required></textarea>
        </div>
        <button type="button" class="btn btn-secondary w-100 mt-3" onclick="previousStep()">Back</button>
        <button type="submit" class="btn btn-success w-100 mt-3">Submit</button>
      </div>
    </form>
  </div>

  <script>
    let currentStep = 1;

    function showStep(step) {
      document.querySelectorAll('.step').forEach((element, index) => {
        element.classList.add('d-none');
        if (index === step - 1) {
          element.classList.remove('d-none');
        }
      });

      document.querySelectorAll('.step-indicator .circle').forEach((circle, index) => {
        circle.classList.remove('active');
        if (index < step) {
          circle.classList.add('active');
        }
      });
    }

    function nextStep() {
      if (currentStep < 3) {
        currentStep++;
        showStep(currentStep);
      }
    }

    function previousStep() {
      if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
      }
    }

    document.getElementById('registrationForm').addEventListener('submit', function (event) {
      event.preventDefault();
      alert('Registration Successful!');
    });

    // Initialize to show only the first step
    showStep(currentStep);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

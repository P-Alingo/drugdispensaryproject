<!DOCTYPE html>
<html>
<head>
    <title>Pharmacist Dispense</title>
</head>
<body>
    <?php
    require_once("connection.php"); // Include your database connection code here

    // Start the session
    session_start();

    // Check if the 'email' key is set in the session
    if (isset($_SESSION['email'])) {
        // Retrieve the pharmacist's email from the session
        $email = $_SESSION['email'];

        // Get the pharmacist's full name
        $query = "SELECT full_name FROM pharmacist WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result !== false && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $fullName = $row['full_name'];

            // Fetch a list of patients from the prescription table
            $query = "SELECT DISTINCT patient_SSN, patient_full_name FROM prescription";
            $result = $conn->query($query);
        } else {
            echo "Pharmacist not found.";
        }
    } else {
        echo "Invalid session. Please login again.";
    }
    ?>

    <h2>Welcome, <?php echo $fullName; ?></h2> <!-- Display the pharmacist's name -->

    <div class="card-container">
        <h1>Pharmacist Dispense Drugs</h1>

        <form id="dispense-form">
            <label for="patient">Select a Patient:</label>
            <select name="patient" id="patient">
                <option value="">Select Patient</option>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . $row['patient_SSN'] . '">' . $row['patient_full_name'] . '</option>';
                    }
                }
                ?>
            </select>

            <!-- Prescription details input fields -->
            <div class="input-group">
                <label for="prescription_id">Prescription ID:</label>
                <input type="text" name="prescription_id" id="prescription_id">
            </div>

            <div class="input-group">
                <label for="drug_id">Drug ID:</label>
                <input type="text" name="drug_id" id="drug_id">
            </div>

            <div class="input-group">
                <label for="patient_full_name">Patient Full Name:</label>
                <input type="text" name="patient_full_name" id="patient_full_name">
            </div>

            <div class="input-group">
                <label for="patient_SSN">Patient SSN:</label>
                <input type="text" name="patient_SSN" id="patient_SSN">
            </div>


            <div class="input-group">
                <label for="doctor_full_name">Doctor Full Name:</label>
                <input type="text" name="doctor_full_name" id="doctor_full_name">
            </div>

            <div class="input-group">
                <label for="doctor_SSN">Doctor SSN:</label>
                <input type="text" name="doctor_SSN" id="doctor_SSN">
            </div>

            <div class="input-group">
                <label for="trace_name">Trace Name:</label>
                <input type="text" name="trace_name" id="trace_name">
            </div>

            <div class="input-group">
                <label for="date">Date:</label>
                <input type="text" name="date" id="date">
            </div>

            <div class="input-group">
                <label for="dosage">Dosage:</label>
                <input type="text" name="dosage" id="dosage">
            </div>

            <div class="input-group">
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" id="quantity">
            </div>

            <div class="input-group">
                <label for="price">Price:</label>
                <input type="text" name="price" id="price">
            </div>

            <div class="button-group">
           
<button type="button" class="indigo-button" name="Fill Details" onclick="autoFillPrescriptionDetails()">Fill Details</button>

            <button type="button" class="indigo-button" name="dispense" onclick="autoFillPrescriptionDetails(); dispenseDrug();">Dispense Drug</button>

                <a href='pharmacistpage.php' class='indigo-button back-button'>Back</a>
            </div>
        </form>
    </div>

    <script>
     // Modify the autoFillPrescriptionDetails() function
function autoFillPrescriptionDetails() {
    const selectedPatient = document.getElementById("patient").value;

    if (selectedPatient === "") {
        alert("Please select a patient.");
        return;
    }

    // Make an AJAX request to fetch prescription details
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `get_prescription_details.php?patient=${selectedPatient}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);

            if (response.error) {
                alert("Error: " + response.error);
            } else {
                // Populate the textboxes with prescription details
                document.getElementById("prescription_id").value = response.prescription_id;
                document.getElementById("drug_id").value = response.drug_id;
                document.getElementById("patient_full_name").value = response.patient_full_name;
                document.getElementById("doctor_full_name").value = response.doctor_full_name;
                document.getElementById("trace_name").value = response.trace_name;
                document.getElementById("date").value = response.date;
                document.getElementById("dosage").value = response.dosage;
                document.getElementById("quantity").value = response.quantity;
                document.getElementById("price").value = response.price;

                // Autofill patient_SSN and doctor_SSN
                document.getElementById("patient_SSN").value = response.patient_SSN;
                document.getElementById("doctor_SSN").value = response.doctor_SSN;
            }
        }
    };
    xhr.send();
}



        function dispenseDrug() {
            // Get the values from the form
            const prescriptionID = document.getElementById("prescription_id").value;
            const drugID = document.getElementById("drug_id").value;
            const patientFullName = document.getElementById("patient_full_name").value;
            const patientSSN = document.getElementById("patient_SSN").value;
            const doctorFullName = document.getElementById("doctor_full_name").value;
            const doctorSSN = document.getElementById("doctor_SSN").value;
            const traceName = document.getElementById("trace_name").value;
            const date = document.getElementById("date").value;
            const dosage = document.getElementById("dosage").value;
            const quantity = document.getElementById("quantity").value;
            const price = document.getElementById("price").value;

            // Create a FormData object to send the data
            const formData = new FormData();
            formData.append("prescription_id", prescriptionID);
            formData.append("drug_id", drugID);
            formData.append("patient_full_name", patientFullName);
            formData.append("patient_SSN", patientSSN);
            formData.append("doctor_full_name", doctorFullName);
            formData.append("doctor_SSN", doctorSSN);
            formData.append("trace_name", traceName);
            formData.append("date", date);
            formData.append("dosage", dosage);
            formData.append("quantity", quantity);
            formData.append("price", price);

            // Send an AJAX request to insert data into drug_dispense table
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "insert_drug_dispense.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Drug dispensed successfully!");
                    } else {
                        alert("Error dispensing drug: " + response.error);
                    }
                }
            };
            xhr.send(formData);
        }
    </script>

    <style>
      h2 {
        color: #333;
      }

      h1 {
        color: #333;
        margin-bottom: 10px;
      }

      .card-container {
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .input-group {
        margin-bottom: 10px;
      }

      label {
        font-weight: bold;
      }

      input[type='text'] {
        padding: 8px;
        width: 250px;
        border-radius: 4px;
        border: 1px solid #ccc;
      }

      .button-group {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
      }

      .indigo-button {
        flex: 1;
        padding: 8px 16px;
        background-color: indigo;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
      }

      .indigo-button:hover {
        background-color: #4b0082;
      }

      .back-button {
        flex: 1;
      }

      body {
        background-image: url('pharmacistdispense.jpg'); /* Add the image as the background */
        background-size: cover; /* Make the image fit the screen */
        background-position: center; /* Center the background image */
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        text-align: center;
        padding-top: 20px;
        background-color: #f2f2f2;
        margin: 0;
        padding: 20px;
        font-family: Arial, sans-serif;
      }
    </style>
</body>
</html>

<!DOCTYPE html>
<?php
// Send headers to control browser caching behavior
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
<html>
<head>
    <title>Visitor Check-In</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            margin: 0;
        }
        .container {
            width: 300px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .welcome {
            margin-top: 20px;
            font-size: 30px;
            font-weight: bold;
            background: white;
            padding: 10px;
            border-radius: 8px;
        }
        .safety-procedures {
            margin-top: 20px;
            text-align: left;
            font-size: 20px;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 14px 28px;
            font-size: 22px;
            cursor: pointer;
            border-radius: 5px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        button:hover {
            background-color: #0056b3;
        }
        #thankYouMessage {
            text-align: center;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            display: none;
        }
        .purpose-container {
            text-align: left;
            margin-bottom: 20px;
        }
        .purpose-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .purpose-item input {
            margin-right: 10px;
        }
        .logo img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="logo">
        <center><img src="Logo.png" alt="Logo"/></center>
    </div>
    <div class="welcome">Welcome to Company</div>
    <div class="welcome">Visitor Registration System</div>
    <br>
    
    <div class="container">
        <div id="thankYouMessage"></div>
        <form id="userInfo" method="POST">
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required><br>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="lastName" required><br>
            <label for="company">Company:</label>
            <input type="text" id="company" name="company" required><br>
            <label for="purpose">Purpose:</label>
            <div class="purpose-container">
                <div class="purpose-item">
                    <input type="radio" id="meeting" name="purpose" value="Meeting">
                    <label for="meeting" style="display: inline;">Meeting</label>
                </div>
                <div class="purpose-item">
                    <input type="radio" id="seminar" name="purpose" value="Seminar">
                    <label for="seminar" style="display: inline;">Seminar</label>
                </div>
                <div class="purpose-item">
                    <input type="radio" id="labtour" name="purpose" value="Lab Tour">
                    <label for="labtour" style="display: inline;">Lab Tour</label>
                </div>
                <div class="purpose-item">
                    <input type="radio" id="vendor" name="purpose" value="Vendor">
                    <label for="vendor" style="display: inline;">Vendor</label>
                </div>
			 <div class="purpose-item">
                    <input type="radio" id="contractor" name="purpose" value="Contractor">
                    <label for="contractor" style="display: inline;">Contractor</label>
                </div>
                <div class="purpose-item">
                    <input type="radio" id="other" name="purpose" value="Other">
                    <label for="other" style="display: inline;">Other</label>
                </div>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>

    <div class="safety-procedures">
        <h2>Dress Code and Safety Regulations</h2>
        <ul>
            <li><strong>Footwear:</strong> Closed-toe shoes are mandatory. High heels, Crocs, sandals, and similar footwear are not permitted.</li>
            <li><strong>Attire:</strong> Pants are required. Skirts, shorts, kilts, and similar attire are not allowed.</li>
            <li><strong>Photography/Videography:</strong> Strictly prohibited.</li>
        </ul>

        <h2>PPE Requirements for Research Facility Access:</h2>
        <ul>
            <li><strong>Hard Hat:</strong> Provided; please return after your visit.</li>
            <li><strong>Safety Glasses:</strong> Provided; you may keep them.</li>
            <li><strong>Hearing Protection:</strong> Provided; you may keep them.</li>
        </ul>

        <h2>Additional Information:</h2>
        <ul>
            <li>By entering these premises, you consent to being recorded by CCTV surveillance systems.</li>
            <li>You must be escorted by a PSRI Team Member at all times.</li>
        </ul>
    </div>

    <script>
    document.getElementById('userInfo').onsubmit = function(e) {
        e.preventDefault();
        var firstName = document.getElementById('firstName').value;
        var lastName = document.getElementById('lastName').value;
        var company = document.getElementById('company').value;
        var purpose = document.querySelector('input[name="purpose"]:checked').value;

        var jsonData = JSON.stringify({
            Name: firstName + " " + lastName,
            Company: company,
            Purpose: purpose
        });

        var xhr = new XMLHttpRequest();
        xhr.open("PUT", "visitor.php", true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('firstName').value = '';
                document.getElementById('lastName').value = '';
                document.getElementById('company').value = '';
                document.querySelector('input[name="purpose"]:checked').checked = false;
                document.getElementById('thankYouMessage').style.display = 'block';
                document.getElementById('thankYouMessage').innerHTML = 
                    'Thanks ' + firstName + ', we have you checked in. <br><br><br><a href="#" onclick="resetForm(); return false;" style="color: #FFC107;">Clear This Message</a><br>';
            }
        };
        xhr.send(jsonData);
    };

    function resetForm() {
        document.getElementById('userInfo').reset();
        document.getElementById('thankYouMessage').style.display = 'none';
    }
    </script>
</body>
</html>

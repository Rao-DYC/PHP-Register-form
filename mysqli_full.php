
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <style>
        body{

            background-color:aqua;
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size:1.2rem;
        }
        header{
            text-align:center;
        }
        table{
            display:fixed;
            margin-left:40%;
            text-align:left;

        }
        #country, #register{
            cursor: pointer;
            padding:2px 10px;
            font-size: 0.8em;
            font-weight:500;
        }
        span{
            color:red;
        }
    </style>
</head>
<?php
// Array to select country
$countries = array(
    'in' => 'India',
    'jp' => 'Japan',
  );

$nameErr = $unameErr = $storeErr = $siteErr = $numErr = $emailErr = $addErr = $countryErr = $passErr = $cpassErr = $termErr = "";
$testname = $testusername = $teststorename = $testsiteurl = $testemail = $testnumber = $testaddress = $selectedCountryCode = $term = '';
if ($_SERVER["REQUEST_METHOD"] == "POST"):
    if (empty($_POST["name"])) {
        $nameErr = "Name Required";
    } else {
        $testname = $_POST["name"];
        if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST["name"])) {
            $nameErr = "Only letters and white spaces are allowed";
        } else {
            $name = test($_POST["name"]);
        }
    }

    if (empty($_POST["username"])) {
        $unameErr = "Name Required";
    } else {
        $testusername = $_POST["username"];
        if (!preg_match("/^[a-zA-Z]*$/", $_POST["username"])) {
            $unameErr = "Only letters are allowed";
        } else {
            $username = test($_POST["username"]);
        }
    }

    if (empty($_POST["storename"])) {
        $storeErr = "Store Name Required";
    } else {
        $teststorename = $_POST["storename"];
        if (!preg_match("/^[a-zA-Z' ]*$/", $_POST["storename"])) {
            $storeErr = "Only letters and white spaces are allowed";
        } else {
            $storename = test($_POST["storename"]);
        }
    }

    if (empty($_POST["siteurl"])) {
        $siteErr = "Site URL Required";
    } else {
        $testsiteurl = $_POST["siteurl"];
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $_POST["siteurl"])) {
            $siteErr = "Please Enter Valid URL";
        } else {
            $siteurl = test($_POST["siteurl"]);
        }
    }
    if (empty($_POST["number"])) {
        $numErr = "Mobile Number Required";
    } else {
        $testnumber = $_POST["number"];
        if (strlen($_POST["number"]) != 10 || !preg_match("/^[0-9]+$/", $_POST["number"])) {
            $numErr = "Enter Valid Number";
        } else {
            $number = test($_POST["number"]);
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email Required";
    } else {
        $testemail = $_POST["email"];
        // Validating mail is valid
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Enter Valid Mail Address";
        } else {
            $email = test($_POST["email"]);
        }
    }

    if (empty($_POST["address"])) {
        $addErr = "Address Required";
    } else {
        $testaddress = $_POST["address"];
        if (!preg_match("/^[A-Za-z0-9 \-\\,.&]+$/", $_POST["address"])) {
            $addErr = "Enter Valid Address";
        } else {
            $address = test($_POST["address"]);
        }
    }
    // Select Country and set Country
    $selectedCountryCode = isset($_POST['country']) ? $_POST['country'] : '';

    if(isset($countries[$selectedCountryCode])){
      $country = $countries[$selectedCountryCode];
      // insert $selectedCountryName
    } else {
      // validation error - country not found, do not insert
      $selectedCountryCode = ''; // reset because it was invalid
      $countryErr = "Please Select a country";
    }

    if (empty($_POST["password"])) {
        $passErr = "Please Enter a Password";
    } else {
        if (!preg_match("#.*^(?=.{6,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST["password"])) {
            $passErr = "Please Enter a valid Password";
        } else {
            $password = test($_POST["password"]);
        }
    }

    if ($_POST["cpassword"] != $_POST["password"] || empty($_POST["cpassword"])) {
        $cpassErr = "Password Does not match";
    } else {
        $cpassword = test($_POST["cpassword"]);
        // Securing password with password_hash()
        $cpasswordhashed = password_hash($cpassword, PASSWORD_BCRYPT);
    }
    if (!isset($_POST["terms"])) {
        $termErr = "Please Accept Terms and Conditions";
    } else {
        $term = test($_POST["terms"]);
    }
    header("Location: form.php");
endif;

// Function to Sanitize data
function test($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
<body>
    <header><h1>Register</h1></header>
    <table>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        <tr><th>
            <label for="name">Name</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="name" id="name" value="<?php echo $testname; ?>">
        </td><td>
            <span><?php echo $nameErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="username">User Name</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="username" id="username" value="<?php echo $testusername; ?>">
        </td><td>
            <span><?php echo $unameErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="storename">Store Name</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="storename" id="storename" value="<?php echo $teststorename; ?>">
        </td><td>
            <span><?php echo $storeErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="siteurl">Site URL</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="siteurl" id="siteurl" value="<?php echo $testsiteurl; ?>">
        </td><td>
            <span><?php echo $siteErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="number">Mobile Number</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="number" id="number" value="<?php echo $testnumber; ?>">
        </td><td>
            <span><?php echo $numErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="email">Email</label><br/>
        </th></tr>
        <tr><td>
            <input type="email" name="email" id="email" value="<?php echo $testemail; ?>">
        </td><td>
            <span><?php echo $emailErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="address">Address</label><br/>
        </th></tr>
        <tr><td>
            <input type="text" name="address" id="address" value="<?php echo $testaddress; ?>">
        </td><td>
            <span><?php echo $addErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="country">Select Country</label><br/>
        </th</tr>
        <tr><td>
            <select class="country" name="country" id="country" >
             <option value="" disabled selected>Choose Country</option>
                <?php foreach ($countries as $code => $countryName): ?>
                <option value="<?php echo htmlspecialchars($code); ?>" <?php if ($code == $selectedCountryCode) {echo 'selected';}?>><?php echo htmlspecialchars($countryName); ?></option>
                <?php endforeach;?>
            </select>
        </td><td>
                <span><?php echo $countryErr;?></span><br/>
        </td></tr>
        <tr><th>
            <label for="password">Password</label><br/>
        </th</tr>
        <tr><td>
            <input type="password" name="password" id="password">
        </td><td>
            <span><?php echo $passErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <label for="cpassword">Confirm Password</label><br/>
        </th></tr>
        <tr><td>
            <input type="password" name="cpassword" id="cpassword">
        </td><td>
            <span><?php echo $cpassErr; ?></span><br/>
        </td></tr>
        <tr><td>
            <input type="checkbox" name="terms" id="terms" value="yes" <?php if ($term == 'yes') echo "checked='checked'"; ?>>I agree to <a href="">Terms & Conditions</a></input>
        </td><td>
            <span><?php echo $termErr; ?></span><br/>
        </td></tr>
        <tr><th>
            <button type="submit" id="register" name="register">Register</button><br/>
        </th></tr>
    </form>

    </table>
    <?php
    // To convert all error in to Exception
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli("localhost", "root", "", "mydbpdo");
    // To make sure charset in UTF8
    $conn->set_charset("utf8mb4");

    if (isset($_POST["register"])):
        // Prepared Statments to insert data
        $sql = $conn->prepare("INSERT INTO register(name, username, storename, siteurl, mobnum, email, address, country, password) VALUES(?,?,?,?,?,?,?,?,?)");
        $sql->bind_param("ssssissss", $name, $username, $storename, $siteurl, $number, $email, $address, $country, $cpasswordhashed);
        $sql->execute();

        $sql->close();
        $conn->close();
        
    endif;

} catch (PDOException $e) {
    $sql->rollback(); // if error happens rollback
    error_log($e);
    echo "Error ";
}

?>
</body>
</html>
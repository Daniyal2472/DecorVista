<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DecorVista</title>
  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700&display=swap" rel="stylesheet">
  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<style>
  /* login  */
@import url("https://fonts.googleapis.com/css2?family=Open+Sans:wght@200;300;400;500;600;700&display=swap");

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Open Sans", sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  width: 100%;
  padding: 0 10px;
  background: rgba(0, 0, 0, 0.6);
}

body::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  background: url("https://img.freepik.com/premium-psd/living-room-wall-mockup-psd-modern-interior-design_53876-130139.jpg") no-repeat center center/cover;
  filter: blur(4px) brightness(50%);
  z-index: -1;
}

.wrapper {
  width: 400px;
  background: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 30px;
  text-align: center;
  border: 3px solid #24d278;
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  position: relative;
  margin-right: 5%;
}

form {
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  color: #000000;
  letter-spacing: 1px;
}

.input-field {
  position: relative;
  border-bottom: 2px solid #000000;
  margin: 15px 0;
}

.input-field label {
  position: absolute;
  top: 50%;
  left: 0;
  transform: translateY(-50%);
  color: #000000;
  font-size: 16px;
  pointer-events: none;
  transition: 0.3s ease;
}

.input-field input {
  width: 100%;
  height: 40px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  color: #000000;
}

.input-field input:focus~label,
.input-field input:valid~label {
  font-size: 0.8rem;
  top: 10px;
  transform: translateY(-120%);
}

.forget {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin: 25px 0 35px 0;
  color: #000000;
}

#remember {
  accent-color: #24d278;
}

.forget label {
  display: flex;
  align-items: center;
}

.forget label p {
  margin-left: 8px;
}

.wrapper a {
  color: #000000;
  text-decoration: none;
}

.wrapper a:hover {
  text-decoration: underline;
}

button {
  background: #24d278;
  color: #000000;
  font-weight: 600;
  border: none;
  padding: 12px 20px;
  cursor: pointer;
  border-radius: 3px;
  font-size: 16px;
  border: 2px solid transparent;
  transition: 0.3s ease;
  
}

button:hover {
  color: #24d278;
  border-color: #000000;
  background: #000000;
}

.register {
  text-align: center;
  margin-top: 30px;
  color: #000000;
}


</style>
<body>
  <div class="wrapper">
    <form action="#">
      <h2>REGISTER FORM </h2>
      <div class="input-field">
        
        <input type="text" required>
        
        <label>
            <i class="fas fa-user pr-1"></i>
            Enter your Username 
        </label>
      </div>
      <div class="input-field">
        
        <input type="text" required>
        
        <label>
            <i class="fas fa-envelope pr-1"></i>
            Enter your email
        </label>
      </div>
      <div class="input-field">
        <input type="password" required>
        <label>
            <i class="fas fa-lock pr-1"></i>
            Enter your password</label>
      </div>
      
      <button type="submit" class="mt-3">Register</button>
      <div class="register">
        <p>Do you have an account? <a href="login.html">login</a></p>
      </div>
    </form>
  </div>
</body>
</html>

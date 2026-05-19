<?php
// Start session to access user data from login
session_start();

// Redirect to login if user is not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /AUT-Web-Based-Travel-Planner/Pages/UserAuthentication/loginForm.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/settingsbutton.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>

<h1>CampusTrips</h1>
<h1>AUT Web-Based Travel Planner</h1>
<?php if (isset($_SESSION['name'])): ?>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</p>
<?php endif; ?>
<p>Here you can manage your travel plans, view your itinerary, and access exclusive travel deals</p>

<!-- Search bar prototype -->

<div class="search-container">
    <div class="search-tabs">
        <button class="tab-btn active" onclick="showSearchTab('flights', this)">Flights</button>
        <button class="tab-btn" onclick="showSearchTab('accommodation', this)">Accommodation</button>
        <button class="tab-btn" onclick="showSearchTab('budget', this)">Budget</button>
        <button class="tab-btn" onclick="showSearchTab('itinerary', this)">Itinerary Building</button>
    </div>

    <div id="flights" class="search-panel active-panel">
        <form id="flight-search-form" method="POST" action="/AUT-Web-Based-Travel-Planner/Pages/userDashboard/searchBoard.php">
            <input type="text" name="departure_city" placeholder="Starting Location...">
            <input type="text" name="arrival_city" placeholder="Destination...">
            <input type="date" name="departure_date">
            <input type="date" name="return_date">
            <button type="submit" class="search-btn">Search</button>
        </form>
        
    </div>

    <div id="accommodation" class="search-panel">
        <input type="text" placeholder="Search accommodation...">
        <input type="text" placeholder="Accommodation type...">
        <button class="search-btn">Search</button>
    </div>

    <div id="budget" class="search-panel">
        <input type="text" placeholder="Search budget...">
        <button class="search-btn">Search</button>
    </div>

    <div id="itinerary" class="search-panel">
        <input type="text" placeholder="Search itinerary...">
        <button class="search-btn">Search</button>
    </div>
</div>

<!--  -->

<!-- <a class="top-right-button" href="/AUT-Web-Based-Travel-Planner/assets/api/auth/signout.php">Sign Out</a>
<p><a href="userProfile.php">View User Profile</a></p> -->

<div class="top-right-actions">
    <button class="profile-btn" onclick="location.href='userProfile.php'">
        <div class="mini-avatar"></div>
    </button>

    <button class="signout-btn" onclick="location.href='/AUT-Web-Based-Travel-Planner/assets/api/auth/signout.php'">
        Sign Out
    </button>
</div>

<!-- Search function JS -->
 <script>
    function showSearchTab(tabId, clickedButton) {
        const panels = document.querySelectorAll('.search-panel');
        const buttons = document.querySelectorAll('.tab-btn');

        panels.forEach(panel => {
            panel.classList.remove('active-panel');
        });

        buttons.forEach(button => {
            button.classList.remove('active');
        });

        document.getElementById(tabId).classList.add('active-panel');
        clickedButton.classList.add('active');
    }
 </script>
<!--  -->
 <div class="savedTrips">
    <h2>Your Saved Trips</h2>
    <p>View and manage your saved trips here.</p>
    
    <!-- Placeholder for saved trips list -->
     <div class="saved-trip-list">
             <ul>
        <li>Trip to Paris - <a href="#">View Details</a></li>
        <li>Weekend in Auckland - <a href="#">View Details</a></li>
        <li>Business Trip to Sydney - <a href="#">View Details</a></li>
    </ul>
    </div>
    <div class="saved-trip-list">
             <ul>
        <li>Trip to Paris - <a href="#">View Details</a></li>
        <li>Weekend in Auckland - <a href="#">View Details</a></li>
        <li>Business Trip to Sydney - <a href="#">View Details</a></li>
    </ul>
    </div>
</div>
</body>
</html>
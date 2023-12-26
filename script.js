// Get user's name (This can come from backend or local storage)
const userName = "John Doe"; // Replace with actual user's name

// Update the user's name in the dashboard
document.getElementById("user-name").textContent = userName;

// Dummy data for sales progression graph (Replace with actual data from backend)
const salesData = [100, 150, 200, 180, 250, 300];

// Update the sales progression graph
const salesGraph = document.getElementById("sales-graph");
salesGraph.innerHTML = salesData
  .map((sale) => `<div class="sale-bar" style="height: ${sale}px;"></div>`)
  .join("");

// Dummy data for achievements (Replace with actual data from backend)
const achievements = [
  "Top Performer Badge",
  "Quarterly Sales Achievement",
  "Yearly Sales Milestone",
];

// Update the achievements list
const achievementsList = document.getElementById("achievements-list");
achievementsList.innerHTML = achievements
  .map((achievement) => `<li>${achievement}</li>`)
  .join("");

// Dummy data for points balance (Replace with actual data from backend)
const points = 500;

// Update the points balance
document.getElementById("points-amount").textContent = points;

// Redirect to redemption page on button click (Replace URL with actual redemption page)
document
  .querySelector(".redemption-preview .btn")
  .addEventListener("click", function () {
    window.location.href = "redemption.html";
  });

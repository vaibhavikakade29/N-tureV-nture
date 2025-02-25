<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beyond Limits Adventure Website</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            background: linear-gradient(to right, #d0e5e7, #89c3c7, #2bd8e435, #1c848f08);
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .review-container, .reviews-section {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            width: 450px;
            text-align: center;
            margin-bottom: 20px;
        }
        h2 {
            color: #012944d3;
            margin-bottom: 5px;
        }
        .tagline {
            font-style: italic;
            color: #555;
            margin-bottom: 15px;
        }
        label {
            font-size: 16px;
            font-weight: bold;
            display: block;
            text-align: left;
            margin-top: 10px;
            color: #333;
        }
        input, textarea {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 10px;
            font-family: "Times New Roman", serif;
            font-size: 14px;
            margin-bottom: 10px;
        }
        textarea {
            height: 90px;
            resize: none;
        }
        .stars {
            display: flex;
            justify-content: center;
            gap: 7px;
            margin: 15px 0;
        }
        .stars span {
            font-size: 28px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.3s;
        }
        .stars span:hover,
        .stars span:hover ~ span {
            color: #f39c12;
        }
        .stars span.selected {
            color: #f39c12;
        }
        .error {
            color: red;
            font-size: 14px;
            text-align: left;
            display: none;
        }
        button {
            background: #e67e22;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        button:hover {
            background: #d35400;
        }
        .review-item {
            background: #fff;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
        }
        .review-item h4 {
            margin: 0;
            color: #e67e22;
        }
        .review-rating {
            font-size: 18px;
            color: #f39c12;
        }
    </style>
</head>
<body>

<div class="review-container">
    <h2>Adventure Review</h2>
    <p class="tagline">"Share Your Adventure, Spark New Journeys!"</p>

    <form id="reviewForm" method="POST" action="submit_review.php">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter your name">
        <p class="error" id="nameError">Please enter a valid name (only letters).</p>

        <label for="message">Your Experience:</label>
        <textarea id="message" name="review" placeholder="Share your adventure experience..." required></textarea>

        <label>Rate Your Experience:</label>
        <div class="stars">
            <span data-value="1">&#9733;</span>
            <span data-value="2">&#9733;</span>
            <span data-value="3">&#9733;</span>
            <span data-value="4">&#9733;</span>
            <span data-value="5">&#9733;</span>
        </div>
        <input type="hidden" id="rating" name="rating" value="0">

        <button type="submit">Submit Review</button>
    </form>
</div>

<div class="reviews-section">
    <h2>View All Reviews</h2>
    <div id="reviewsList">
        <?php
        include 'database.php';

        $sql = "SELECT * FROM reviews ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error: " . mysqli_error($conn);
        } else {
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="review-item">';
                    echo '<h4>' . htmlspecialchars($row['name']) . '</h4>';
                    echo '<p>' . htmlspecialchars($row['review']) . '</p>';
                    echo '<div class="review-rating">Rating: ' . str_repeat('⭐', $row['rating']) . '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No reviews available.</p>';
            }
        }

        mysqli_close($conn);
        ?>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('.stars span');
    const ratingInput = document.getElementById("rating");

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            ratingInput.value = index + 1;
            updateStars(index);
        });
    });

    function updateStars(index) {
        stars.forEach((star, i) => {
            if (i <= index) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }

    document.getElementById("reviewForm").addEventListener("submit", function(event) {
        let name = document.getElementById("name").value.trim();
        let nameError = document.getElementById("nameError");

        if (!/^[A-Za-z ]+$/.test(name)) {
            nameError.style.display = "block";
            event.preventDefault();
        } else {
            nameError.style.display = "none";
        }

        if (ratingInput.value === "0") {
            alert("Please rate your experience before submitting.");
            event.preventDefault();
        } else {
            event.preventDefault(); // Prevent immediate submission
            alert("Your adventure has been recorded! Thanks for sharing your journey!");
            
            setTimeout(() => {
                let confirmLogout = confirm("Are you sure you want to logout?");
                if (confirmLogout) {
                    window.location.href = "thankyou.html"; // Redirect if user confirms
                }
            }, 2000); // 2-second delay for alert display
        }
    });
</script>

</body>
</html>

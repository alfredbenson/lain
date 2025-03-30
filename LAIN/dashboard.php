<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background: #f4f4f4; padding: 20px; }
        .bill-container, .bill-form { background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); margin-top: 20px; }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Main Content -->
<div class="container mt-5">
    <div class="bill-container">
        <h2>View List Bills</h2>
        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" id="addBill">➕ Add Bill</button>
        </div>
        <ul id="billList" class="list-group mt-3"></ul>
    </div>
    
    <div class="bill-form" id="billForm" style="display:none;">
        <h2>Create a Bill</h2>
        <form id="billCreationForm">
            <div class="mb-3">
                <label for="billCode" class="form-label">Generated Code</label>
                <input type="text" class="form-control" id="billCode" readonly>
            </div>
            <div class="mb-3">
                <label for="billName" class="form-label">Bill Name</label>
                <input type="text" class="form-control" id="billName" required>
            </div>
            <div class="mb-3">
                <label for="billAmount" class="form-label">Total Amount</label>
                <input type="number" class="form-control" id="billAmount" required>
            </div>
            <div class="mb-3">
                <label for="participants" class="form-label">Add Participants</label>
                <textarea class="form-control" id="participants" placeholder="Enter names separated by commas" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Bill</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function generateBillCode() {
        return 'BILL-' + Math.random().toString(36).substr(2, 8).toUpperCase();
    }

    $(document).ready(function() {
        $("#addBill").click(function() {
            $("#billForm").toggle();
            $("#billCode").val(generateBillCode());
        });

        $("#billCreationForm").submit(function(event) {
            event.preventDefault();
            let billName = $("#billName").val().trim();
            let billAmount = parseFloat($("#billAmount").val());
            let participants = $("#participants").val().trim().split(',').map(p => p.trim());
            let billCode = $("#billCode").val();

            if (billName === "" || isNaN(billAmount) || participants.length === 0) {
                alert("Please enter valid bill details.");
                return;
            }

            let perPersonInput = "";
            participants.forEach(participant => {
                perPersonInput += `<div class='mb-3'><label>${participant} covers for:</label>
                                   <input type='number' class='form-control personShare' data-name='${participant}' min='1' value='1'></div>`;
            });

            let splitForm = `<div class='bill-form' id='splitForm'>
                                <h2>Customize Split</h2>
                                ${perPersonInput}
                                <button class='btn btn-primary' id='calculateSplit'>Calculate</button>
                            </div>`;

            $("#billForm").after(splitForm);

            $("#calculateSplit").click(function() {
                let totalShares = 0;
                let contributions = {};

                $(".personShare").each(function() {
                    let name = $(this).data("name");
                    let shares = parseInt($(this).val());
                    contributions[name] = shares;
                    totalShares += shares;
                });

                let billSplitDetails = `<li class='list-group-item'><strong>${billName} (${billCode})</strong><br>Total: $${billAmount}<br>`;

                for (let person in contributions) {
                    let shareAmount = (billAmount * (contributions[person] / totalShares)).toFixed(2);
                    billSplitDetails += `${person} pays: $${shareAmount}<br>`;
                }
                billSplitDetails += "</li>";

                $("#billList").append(billSplitDetails);
                $("#splitForm").remove();
                $("#billForm").hide();
                $("#billCreationForm")[0].reset();
            });
        });
    });
</script>

</body>
</html>

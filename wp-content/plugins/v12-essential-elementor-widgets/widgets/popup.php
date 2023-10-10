<div class="overlay " id="popupOverlay" style="z-index:999999 !important">
    <div class="popup" id="popup">
        <div class="close-btn-popup" onclick="togglePopup()">&times;</div>
        <h3>Thank You.</h3>
        <p>We've got your request.</br>Someone on our team will get back to you shortly.</p>
    </div>
</div>

<!-- Your page content goes here -->

<script>
    function togglePopup() {
        var popup = document.getElementById("popupOverlay");
        popup.style.display = (popup.style.display === "none" || popup.style.display === "") ? "block" : "none";
    }
</script>

<style type="text/css">
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 100;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40%;
        height: 22%;
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        justify-content: center;
        align-items: center;
        align-content: center;
        display: grid;
    }

    .close-btn-popup {
        position: absolute;
        top: 10px;
        right: 20px;
        cursor: pointer;
        font-size: 20px;
        color: #333;
    }





    /* Style the button inside the popup */
    .popup-button {
        background-color: #007BFF;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 20px;
    }

    /* Add hover effect to the button */
    .popup-button:hover {
        background-color: #0056b3;
    }
</style>
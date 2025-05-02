@extends('layouts.app')

@section('content')
<div class="container">
    <br>
    <h1>Website Policies:</h1>
    <br>
    <br>

    <div class="policy-section" >
        <h2 class="policy-title">Introduction</h2>
        <p>Welcome to our platform. We provide a service that allows dealers to list cars, and buyers to reserve them. Please read through the policies below to understand the terms and conditions of using our website.</p>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">General Terms</h2>
        <ul>
            <li>Users must be over the age of 18 to use this platform.</li>
            <li>Both buyers and dealers are required to register an account to access the platform's features.</li>
            <li>All transactions on the platform are binding once the reservation is confirmed by the dealer.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Buyer Policies</h2>
        <p>As a buyer, you agree to the following policies:</p>
        <ul>
            <li>Buyers can reserve cars listed by dealers on the platform by selecting a specific date for pickup.</li>
            <li>The reservation is pending until the dealer confirms the availability or the buyer cancels it.</li>
            <li>Buyers can select the payment method (Cash or Visa or Buy now Pay later) when confirming the reservation.</li>
            <li>Reservations are only confirmed when the buyer selects a payment method and the dealer approves the reservation.</li>
            <li>If a car is not available at the time of reservation, the dealer will notify the buyer to either select a different car or cancel the reservation.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Dealer Policies</h2>
        <p>As a dealer, you agree to the following policies:</p>
        <ul>
            <li>Dealers are responsible for adding accurate and up-to-date details for each car, including title, brand, condition (used, new, broken, etc.), and price.</li>
            <li>Dealers can manage their reservations and export them as Excel files for record-keeping.</li>
            <li>Dealers should update the reservation status to "Done" once the buyer has received the car and completed the payment.</li>
            <li>Dealers are obligated to ensure that all cars listed are available on the selected reservation date.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Reservations & Cancellations</h2>
        <p>By making a reservation, you agree to the following:</p>
        <ul>
            <li>Reservations are valid only for the selected date and are subject to dealer confirmation.</li>
            <li>If a buyer cancels the reservation, the dealer will be notified immediately.</li>
            <li>Buyers may cancel a reservation at any time before the car is picked up, but cancellation terms may apply.</li>
            <li>Once the buyer has received the car, the dealer may mark the reservation as "Done" to complete the transaction.</li>
            <li>If the dealer cannot fulfill the reservation for any reason, the dealer must notify the buyer promptly and offer alternative arrangements or a cancellation.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Payment Methods</h2>
        <p>Buyers can select from the following payment options during the reservation process:</p>
        <ul>
            <li><strong>Cash:</strong> Full payment is required at the time of car pickup.</li>
            <li><strong>Visa:</strong> Buyers can make a payment through their Visa card at the time of reservation or pickup. Transactions are securely processed through our payment gateway.</li>
            <li><strong>BNPL:</strong> And buyer can buy now pay later after agreement between the buyer and the dealer</li>

        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Responsibilities & Obligations</h2>
        <p>Both buyers and dealers have the following responsibilities:</p>
        <ul>
            <li><strong>Buyers:</strong> You are responsible for ensuring that the car you are reserving is available for the date you select. Ensure that you have the proper funds to complete the reservation and payment process.</li>
            <li><strong>Dealers:</strong> You are responsible for providing accurate details for the cars you list, including conditions (used, broken, etc.), price, and availability. You must also fulfill the reservation as agreed upon with the buyer.</li>
        </ul>
    </div>

    <div class="policy-section">
        <h2 class="policy-title">Privacy & Security</h2>
        <p>We take your privacy seriously. All personal and payment data is securely processed and stored. We do not share your information with third parties without your consent. For more details, please refer to our Privacy Policy.</p>
    </div>

</div>
@endsection

<!-- Add inline or separate CSS -->
<style>
    .policy-section {
        margin-bottom: 30px;
        padding: 20px;
        background-color: #f8f9fa92;
        border-radius: 5px;
    }

    .policy-title {
        font-size: 1.5em;   
        margin-bottom: 10px;
        color: #0056b3;
    }

    .policy-section ul {
        list-style-type: disc;
        padding-left: 20px;
    }

    .policy-section p {
        font-size: 1.1em;
        color: #333;
    }
</style>


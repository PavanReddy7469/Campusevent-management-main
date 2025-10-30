<?php
// Retrieve user input from POST request
$userInput = json_decode(file_get_contents('php://input'), true);

// Example simple responses based on user input
$response = generateResponse($userInput['userInput']);

// Send response back to client
echo $response;

// Function to generate AI response based on user input
function generateResponse($userInput) {
    // Simple responses based on keywords
    if (strpos($userInput, 'hello') !== false) {
        return "Hello! How can I assist you today?";
    } elseif (strpos($userInput, 'how are you') !== false) {
        return "I'm just a machine, but thanks for asking!";
    } elseif (strpos($userInput, 'bye') !== false) {
        return "Goodbye! Have a great day!";
    } else {
        // Default response if no specific keyword is found
        return "I'm sorry, I didn't understand that. Can you please repeat?";
    }
}
?>

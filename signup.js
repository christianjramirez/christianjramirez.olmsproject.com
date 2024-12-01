document.getElementById('signupForm').addEventListener('submit', async (event) => {
    event.preventDefault(); // Prevent page reload on form submission

    // Convert form data to JSON
    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries());
    
    console.log('Submitting form with data:', data); // Debugging log

    try {
        // Send a POST request to the server
        const response = await fetch('http://api.olmsproject.com/api/users/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        // Check if the response was successful
        const result = await response.json();
        const responseMessage = document.getElementById('responseMessage');

        if (response.ok) {
            console.log('Server response:', result); // Debugging log
            responseMessage.style.color = 'green';
            responseMessage.textContent = 'Account created successfully!';
            event.target.reset(); // Clear the form
        } else {
            console.error('Error response from server:', result); // Debugging log
            responseMessage.style.color = 'red';
            responseMessage.textContent = result.message || 'An error occurred. Please try again.';
        }
    } catch (error) {
        // Handle fetch or network errors
        console.error('Error during form submission:', error);
        const responseMessage = document.getElementById('responseMessage');
        responseMessage.style.color = 'red';
        responseMessage.textContent = 'Failed to create account. Please check your connection and try again.';
    }
});


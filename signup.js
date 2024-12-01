document.getElementById('signupForm').addEventListener('submit', async (event) => {
    event.preventDefault(); 

    const formData = new FormData(event.target);
    const data = Object.fromEntries(formData.entries()); //convert form data to JSON

    try {
        const response = await fetch('/api/users/register', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        const result = await response.json();
        const responseMessage = document.getElementById('responseMessage');

        if (response.ok) {
            responseMessage.style.color = 'green';
            responseMessage.textContent = 'Account created successfully!';
            event.target.reset(); //clear the form
        } else {
            responseMessage.style.color = 'red';
            responseMessage.textContent = result.message || 'An error occurred.';
        }
    } catch (error) {
        console.error('Error:', error);
        document.getElementById('responseMessage').textContent = 'Failed to create account. Please try again.';
    }
});

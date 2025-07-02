document.getElementById('registerForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const res = await fetch("/api/register", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json"
        },
        body: JSON.stringify({ name, email, password })
    });

    const data = await res.json();

    if (res.ok) {
        localStorage.setItem('token', data.authorisation.token);

        // Check if student info exists
        const infoRes = await fetch("/api/student", {
            headers: {
                "Accept": "application/json",
                "Authorization": `Bearer ${data.authorisation.token}`
            }
        });

        if (infoRes.status === 404) {
            alert("No student info found. Redirecting to create...");
            window.location.href = "/students/create";
        } else {
            alert("Registration successful!");
            window.location.href = "/students/show";
        }
    } else {
        alert(data.message || "Registration failed");
    }
});

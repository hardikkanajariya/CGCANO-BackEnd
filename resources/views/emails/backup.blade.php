<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Ticket Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto p-6 bg-white shadow-lg rounded-lg max-w-md mt-10">
    <header class="text-center bg-blue-500 text-white py-4 rounded-t-lg">
        <h1 class="text-2xl font-bold">System Backup</h1>
    </header>

    <main class="container shadow">
        <div class="py-10 px-8">
            <p class="mb-2">Hello {{auth()->user()->fullname}},</p>
            <p class="mb-2">Your system backup is ready for download.</p>
            <p class="mb-2">Please click the link below to download the backup.</p>
            <p class="mb-2">Link: <a href="{{storage_path($path)}}" class="text-blue-500" download="true">{{storage_path($path)}}</a></p>
            <p class="mb-2">Thank you.</p>
        </div>
    </main>

    <hr class="border-t my-6">
    <div class="contact-details"><p class="mb-2">For inquiries, contact us:</p>
        <p class="mb-2">Phone: +1 (705) 923-2799</p>
        <p class="mb-2">Email: Info@gcanorthernontario.com</p>
        <p class="mb-2">Website:<a href="https://www.gcanorthernontario.com" class="text-blue-500">www.gcanorthernontario.com</a>
        </p>
        <p class="mb-2">Location: 39 Tera-vista Way, Sud-bury ON, P3E 0H9, Canada</p></div>
</div>
</body>
</html>

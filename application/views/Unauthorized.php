<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Denied - Unauthorized</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { 
                        sans: ['Inter', 'sans-serif'] 
                    },
                    colors: {
                        'aisect-red': '#dc3545', // Danger color for errors
                        'aisect-blue': '#1e40af', 
                        'aisect-light': '#eff6ff',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 font-sans">

<div class="w-full max-w-lg bg-white p-8 md:p-10 rounded-xl shadow-2xl border-t-8 border-aisect-red">
    
    <div class="text-center">
        <div class="text-aisect-red text-6xl mb-4 animate-pulse">
            🛑
        </div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Access Denied</h1>
        <p class="text-gray-500 mb-6">Unauthorized Identifier</p>
    </div>
    
    
    <p class="text-sm text-gray-600 mb-6">
        Please ensure the identifier in your browser's address bar is correct. If you were attempting to access the survey directly without an official link, you may be redirected to a default ID.
    </p>

    <a href="#" class="w-full inline-flex justify-center items-center py-3 px-4 border border-transparent text-base font-medium rounded-lg text-white bg-aisect-blue hover:bg-blue-700 transition duration-150 ease-in-out shadow-lg">
        Go Back to Survey Entry
    </a>

</div>

</body>
</html>
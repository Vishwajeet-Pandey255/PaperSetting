<!DOCTYPE html>
<html>
<head>
    <title>Survey Data Download Panel</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <style>
        .bg-aisect-blue { background-color: #007bff; }
        .text-aisect-light { color: #f8f9fa; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-4">

    <header class="text-center mb-10 p-6 bg-aisect-blue rounded-xl shadow-lg mx-auto max-w-4xl">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">
            AISECT ONLINE PORTAL – USER FEEDBACK SURVEY DATA
        </h1>
        <p class="text-xl font-medium text-aisect-light mt-2">
            आईसेक्ट ऑनलाइन पोर्टल – उपयोगकर्ता प्रतिक्रिया सर्वेक्षण
        </p>
    </header>

    <div class="container mx-auto max-w-4xl p-4">
        
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 text-center">
            Survey Data Download Panel (सर्वेक्षण डेटा डाउनलोड पैनल)
        </h2>

        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-700 text-lg mb-6">
                नीचे दिए गए बटन पर क्लिक करें सभी सर्वेक्षण डेटा Excel फ़ाइल में डाउनलोड करने के लिए ।<br>
                Click below to download complete survey data in Excel.
            </p>

            <a href="<?php echo base_url('Aisect_survey2/downloadSurveyData'); ?>">
                <button class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md 
                        hover:bg-green-700 focus:outline-none focus:ring-2 
                        focus:ring-green-300 transition duration-150 ease-in-out">
                    Download All Survey Data (सभी डेटा डाउनलोड करें)
                </button>
            </a>
        </div>

    </div>

</body>
</html>

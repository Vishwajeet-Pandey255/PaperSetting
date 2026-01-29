<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISECT Portal User Feedback Survey - Success</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        'aisect-blue': '#1e40af',
                        'aisect-light': '#eff6ff',
                        'aisect-dark': '#111827',
                        'aisect-accent': '#f59e0b',
                    }
                }
            }
        }
    </script>
    <style>
        body { background-color: #f7f9fb; color: #333; }
    </style>
</head>
<body class="font-sans antialiased">

<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8">

    <header class="text-center mb-10 p-6 bg-aisect-blue rounded-xl shadow-lg">
        <h1 class="text-3xl sm:text-4xl font-extrabold text-white">
            AISECT ONLINE PORTAL – USER FEEDBACK SURVEY
        </h1>
        <p class="text-xl font-medium text-aisect-light mt-2">
            आईसेक्ट ऑनलाइन पोर्टल – उपयोगकर्ता प्रतिक्रिया सर्वेक्षण
        </p>
    </header>

    <?php if ($this->session->flashdata('success')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-800 p-8 rounded-xl shadow-2xl mb-8">
            <div class="flex items-start">
                <svg class="h-8 w-8 text-green-600 mr-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-2xl font-bold text-green-900">Submission Successful!</h3>
                    <p class="mt-2 text-lg font-medium text-green-800">
                        <?php echo $this->session->flashdata('success'); ?>
                    </p>
                    <p class="mt-3 text-base text-green-600">
                        Your feedback has been successfully recorded. You may now close this window.
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-red-100 border-l-4 border-red-500 text-red-800 p-8 rounded-xl shadow-2xl mb-8">
            <p class="text-lg font-medium text-red-800">
                Error: Survey success message not found. Please navigate to the survey link to begin.
            </p>
            <div class="mt-4 text-center">
                 <a href="<?php echo base_url('Aisect_survey'); ?>" class="bg-aisect-blue hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-200">
                    Go to Survey
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AISECT Portal User Feedback Survey</title>
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
        .form-section { border-left: 4px solid; padding-left: 1.5rem; margin-bottom: 2.5rem; }
        /* Custom Checkbox Styling */
        .custom-check {
            -webkit-appearance: none; appearance: none;
            display: inline-block; width: 1.25rem; height: 1.25rem;
            border: 2px solid #9ca3af; border-radius: 0.375rem; cursor: pointer;
            margin-right: 0.5rem; vertical-align: middle; transition: all 0.2s;
        }
        .custom-check:checked { background-color: #1e40af; border-color: #1e40af; position: relative; }
        .custom-check:checked:before { content: '\2713'; color: white; font-size: 0.75rem; position: absolute; top:50%; left:50%; transform: translate(-50%, -50%); }
        /* Custom Radio Button Styling */
        .custom-radio { 
            -webkit-appearance: none; appearance: none;
            display: inline-block; width: 1.25rem; height: 1.25rem;
            border: 2px solid #9ca3af; border-radius: 50%; cursor: pointer;
            margin-right: 0.5rem; vertical-align: middle; transition: all 0.2s;
            position: relative;
        }
        .custom-radio:checked { background-color: #1e40af; border-color: #1e40af; }
        .custom-radio:checked:before { content: ''; width: 0.5rem; height: 0.5rem; background-color: white; border-radius: 50%; display: block; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); }
        
        .rating-table-container { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .rating-table { min-width: 600px; }
        .rating-table th, .rating-table td { padding: 0.75rem 0.5rem; text-align: center; }
        .rating-table th:first-child, .rating-table td:first-child { text-align: left; min-width: 150px; }
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

    <?php if (isset($is_completed) && $is_completed): ?>
        <div class="bg-white border-l-4 border-gray-400 text-gray-800 p-8 rounded-xl shadow-2xl mb-8">
            <div class="flex items-start">
                <svg class="h-8 w-8 text-gray-500 mr-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">Feedback Already Submitted</h3>
                    <p class="mt-2 text-lg font-medium text-gray-800">
                        <?php 
                            // The error flashdata holds the message set in the controller
                            echo $this->session->flashdata('survey_completed_error'); 
                        ?>
                    </p>
                    <p class="mt-3 text-base text-gray-600">
                        Thank you for your response. The survey for SKP ID: **<?= html_escape($skp_id) ?>** is already marked as complete.
                    </p>
                </div>
            </div>
        </div>
        
    <?php else: // Survey is NOT completed, show flash messages (for success/error on submission) and the form ?>

        <?php if ($this->session->flashdata('success') || $this->session->flashdata('error')): ?>
            <div id="flash-message" class="
                <?php echo $this->session->flashdata('success') ? 'bg-green-100 border border-green-400 text-green-700' : 'bg-red-100 border border-red-400 text-red-700'; ?>
                px-4 py-3 rounded relative mb-8" role="alert">
                <strong class="font-bold"><?php echo $this->session->flashdata('success') ? 'Success!' : 'Error!'; ?></strong>
                <span class="block sm:inline">
                    <?php echo $this->session->flashdata('success') ? $this->session->flashdata('success') : $this->session->flashdata('error'); ?>
                </span>
            </div>
        <?php endif; ?>

        <form action="<?php echo base_url('Aisect_survey2/saveSurvey'); ?>" method="post" class="bg-white p-6 sm:p-10 rounded-xl shadow-2xl border border-gray-100" onsubmit="return validateCheckboxes(event);">

            <div class="mb-8 border-b pb-6 border-gray-200">
                <label for="skp_id" class="block text-lg font-semibold mb-2 text-aisect-dark">
                    SKP ID ( Required)
                    <span class="text-gray-500 font-normal text-base ml-1">/ एसकेपी आईडी </span>
                </label>
                <input type="text" id="skp_id" name="skp_id" 
                    value="<?= html_escape($skp_id) ?>" 
                    placeholder="Enter your SKP ID" required pattern="[a-zA-Z0-9]+" 
                    title="SKP ID must be alphanumeric (letters and numbers only)" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-aisect-accent focus:border-aisect-accent transition duration-150 ease-in-out text-lg <?= (isset($skp_id_validated) && $skp_id_validated) ? 'readonly bg-gray-100' : '' ?>"
                    <?= (isset($skp_id_validated) && $skp_id_validated) ? 'readonly' : '' ?>
                >
            </div>

            <div class="form-section border-aisect-blue">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 1 — USER PROFILE
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 1 — उपयोगकर्ता प्रोफ़ाइल</span>
                </h2>
                
                <?php $q_current_visual = 1; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Usage frequency / उपयोग की आवृत्ति:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_1" value="Daily" class="custom-radio" required> Daily / दैनिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_1" value="Weekly" class="custom-radio" required> Weekly / साप्ताहिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_1" value="Monthly" class="custom-radio" required> Monthly / मासिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_1" value="Rarely" class="custom-radio" required> Rarely / कभी-कभी</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_1" value="Rarely" class="custom-radio" required> First-time user / पहली बार उपयोगकर्ता</label>
                    </div>
                </fieldset>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Purpose (tick all) / उद्देश्य (सभी लागू विकल्प चुनें):
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Course Enrollment" class="custom-check"> Enrollment / नामांकन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Registration" class="custom-check"> Registration / पंजीकरण</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Results/Certificates" class="custom-check"> Results/Certificates / परिणाम/प्रमाणपत्र</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Fee Payment" class="custom-check"> Payments / भुगतान</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Staff tasks" class="custom-check"> Staff tasks / स्टाफ कार्य</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Notifications" class="custom-check"> Notifications / सूचनाएँ</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Support/Helpdesk" class="custom-check"> Technical support / तकनीकी सहायता</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_2[]" value="Update profile" class="custom-check"> Update profile / प्रोफ़ाइल अपडेट</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_2[]" value="Other" class="custom-check"> Other / अन्य:
                            <input type="text" name="answer_2_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. User category / उपयोगकर्ता श्रेणी:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Student" class="custom-radio" required> Student / छात्र</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Faculty/Staff" class="custom-radio" required> Faculty / संकाय</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Admin" class="custom-radio" required> Admin / प्रशासनिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Parent" class="custom-radio" required> Parent / अभिभावक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Kiosk Operator" class="custom-radio" required> Partner staff / साझेदार स्टाफ</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_3" value="Other" class="custom-radio" required> Other / अन्य</label>
                    </div>
                </fieldset>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Usage duration / उपयोग अवधि:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_4" value="< 15 Mins" class="custom-radio" required> &lt;15 mins / 15 मिनट से कम</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_4" value="15-30 Mins" class="custom-radio" required> 15–30 mins / 15–30 मिनट</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_4" value="30-60 Mins" class="custom-radio" required> 30–60 mins / 30–60 मिनट</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_4" value="> 60 Mins" class="custom-radio" required> &gt;60 mins / 60 मिनट से अधिक</label>
                    </div>
                </fieldset>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Device used / उपयोग किया गया उपकरण:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_5" value="Desktop/Laptop" class="custom-radio" required> Laptop / लैपटॉप</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_5" value="Mobile Phone" class="custom-radio" required> Mobile Phone / एंड्रॉयड फोन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_5" value="Mobile Phone" class="custom-radio" required> iPhone / आईफोन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_5" value="Tablet" class="custom-radio" required> Tablet / टैबलेट</label>
                    </div>
                </fieldset>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Browser / ब्राउज़र:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_6" value="Chrome" class="custom-radio" required> Chrome</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_6" value="Firefox" class="custom-radio" required> Firefox</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_6" value="Edge/IE" class="custom-radio" required> Edge</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_6" value="Safari" class="custom-radio" required> Safari</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_6" value="Other" class="custom-radio" required> Other / अन्य</label>
                    </div>
                </fieldset>
            </div>

            <hr class="my-10 border-t-2 border-aisect-accent/50">

            <div class="form-section border-aisect-accent">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 2 — RATING
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 2 — रेटिंग</span>
                </h2>
                <p class="mb-6 text-gray-600">(1 = Very Poor / बहुत खराब, 5 = Excellent / उत्कृष्ट)</p>

                <div class="rating-table-container shadow-md rounded-lg">
                    <table class="rating-table w-full text-sm text-left text-gray-500 bg-white">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3 px-3 w-10">No.</th>
                                <th scope="col" class="py-3 px-6">Aspect / पहलू</th>
                                <th scope="col" class="py-3 px-6">1</th>
                                <th scope="col" class="py-3 px-6">2</th>
                                <th scope="col" class="py-3 px-6">3</th>
                                <th scope="col" class="py-3 px-6">4</th>
                                <th scope="col" class="py-3 px-6">5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mapping of visual Q number (7-21) to the DB field name (answer_X in controller)
                            $rating_map = [
                                7 => 'Navigation',
                                8 => 'Speed_Performance',
                                9 => 'Availability',
                                10 => 'Info_Accuracy',
                                11 => 'Page_Load_Time',
                                12 => 'Instructions_Clarity',
                                13 => 'Mobile_Usability',
                                14 => 'Visual_Design',
                                15 => 'Dashboard_Usefulness',
                                16 => 'Security_Privacy',
                                17 => 'Payment_Experience',
                                18 => 'Results_Certs',
                                19 => 'Error_Handling',
                                20 => 'Support',
                                21 => 'Overall_Satisfaction'
                            ];

                            $questions_2 = [
                                "Navigation / नेविगेशन",
                                "Speed/Performance / गति/प्रदर्शन",
                                "Availability / उपलब्धता",
                                "Information accuracy / जानकारी की सटीकता",
                                "Page load time / पेज लोड समय",
                                "Instructions clarity / निर्देशों की स्पष्टता",
                                "Mobile usability / मोबाइल उपयोगिता",
                                "Visual design / दृश्य डिजाइन",
                                "Dashboard usefulness / डैशबोर्ड उपयोगिता",
                                "Security/Privacy / सुरक्षा/गोपनीयता",
                                "Payment experience / भुगतान अनुभव",
                                "Results/Certificates / परिणाम/प्रमाणपत्र",
                                "Error handling / त्रुटि प्रबंधन",
                                "Support / सहायता",
                                "Overall satisfaction / समग्र संतुष्टि"
                            ];
                            
                            $q_current_db = 7; // Start DB field counter at 7 (answer_7)
                            $q_current_visual = 1; 

                            foreach ($questions_2 as $q_text):
                                $input_name = 'answer_' . $q_current_db;
                                $db_field_name = $rating_map[$q_current_db];
                            ?>
                            <tr class="bg-white border-b hover:bg-aisect-light/30">
                                <td class="py-4 px-3 font-medium text-gray-900"><?= $q_current_visual ?>.</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $q_text ?>
                                </td>
                                <?php for ($val = 1; $val <= 5; $val++): ?>
                                <td class="py-4 px-6 text-center">
                                    <input type="radio" name="<?= $input_name ?>" value="<?= $val ?>" class="custom-radio" required>
                                </td>
                                <?php endfor; ?>
                            </tr>
                            <?php 
                            $q_current_visual++;
                            $q_current_db++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <hr class="my-10 border-t-2 border-aisect-blue/50">

            <div class="form-section border-aisect-blue">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 3 — MULTIPLE CHOICE FEEDBACK
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 3 — बहुविकल्पीय प्रतिक्रिया</span>
                </h2>

                <?php 
                    // $q_current_db should be 22 here
                    $q_current_visual = 1; 
                ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. What do you like most? / आपको सबसे अधिक क्या पसंद है?
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Ease of Navigation" class="custom-check">
                            Navigation / नेविगेशन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Speed" class="custom-check">
                            Speed / गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Payments" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Results/Certs" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Dashboard" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Information Accuracy" class="custom-check">
                            Info availability / जानकारी उपलब्धता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Visual Design" class="custom-check">
                            Design / डिजाइन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Nothing" class="custom-check">
                            Nothing / कुछ नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_22[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_22_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 23; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Issues faced (tick all) / समस्याएँ (सभी लागू चुनें):
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Slow Loading" class="custom-check">
                            Slow speed / धीमी गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Payment Errors" class="custom-check">
                            Payment errors / भुगतान त्रुटियाँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Mobile Issues" class="custom-check">
                            Mobile issues / मोबाइल समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Incorrect Info" class="custom-check">
                            Incorrect info / गलत जानकारी
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Login Errors" class="custom-check">
                            Login issues / लॉगिन समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Downtime" class="custom-check">
                            Downtime / डाउनटाइम
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Errors" class="custom-check">
                            Errors / त्रुटियाँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Complex Navigation" class="custom-check">
                            Navigation issues / नेविगेशन समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="No Issues" class="custom-check">
                            No issues / कोई समस्या नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_23[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_23_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 24; ?>


                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Errors/downtime frequency / त्रुटि/डाउनटाइम की आवृत्ति:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_24" value="Frequently" class="custom-radio" required>
                            Frequent / बार-बार
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_24" value="Occasionally" class="custom-radio" required>
                            Occasional / कभी-कभी
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_24" value="Rarely" class="custom-radio" required>
                            Rare / कम
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_24" value="Never" class="custom-radio" required>
                            Never / कभी नहीं
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 25; ?>


                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Useful features / उपयोगी सुविधाएँ:
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Enrollment" class="custom-check">
                            Enrollment / नामांकन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Registration" class="custom-check">
                            Registration / पंजीकरण
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Payments" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Results/Certs" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Dashboard Overview" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Notifications" class="custom-check">
                            Notifications / सूचनाएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Update profile" class="custom-check">
                            Profile update / प्रोफ़ाइल अपडेट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="None" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_25[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_25_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 26; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Features needing improvement / सुधार की आवश्यकता वाली सुविधाएँ:
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Speed" class="custom-check">
                            Speed / गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Payment Gateway" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Mobile View" class="custom-check">
                            Mobile view / मोबाइल दृश्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Login/OTP" class="custom-check">
                            Login/OTP
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Search Accuracy" class="custom-check">
                            Search / खोज
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Results/Certs" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Dashboard" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Nothing" class="custom-check">
                            Nothing / कुछ नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_26[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_26_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 27; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Payment process difficulty / भुगतान प्रक्रिया की कठिनाई:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_27" value="Very Easy" class="custom-radio" required>
                            Very easy / बहुत आसान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_27" value="Easy" class="custom-radio" required>
                            Easy / आसान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_27" value="Neutral" class="custom-radio" required>
                            Neutral / सामान्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_27" value="Difficult" class="custom-radio" required>
                            Difficult / कठिन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_27" value="Very Difficult" class="custom-radio" required>
                            Very difficult / बहुत कठिन
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 28; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Clarity of instructions / निर्देशों की स्पष्टता:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_28" value="Excellent" class="custom-radio" required>
                            Very clear / बहुत स्पष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_28" value="Good" class="custom-radio" required>
                            Clear / स्पष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_28" value="Fair" class="custom-radio" required>
                            Neutral / सामान्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_28" value="Poor" class="custom-radio" required>
                            Confusing / भ्रमित करने वाला
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_28" value="Very Poor" class="custom-radio" required>
                            Very confusing / बहुत भ्रमित करने वाला
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 29; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Improvements wanted / वांछित सुधार:
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="Faster Processing" class="custom-check">
                            Faster speed / तेज गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="Improved Interface" class="custom-check">
                            Better mobile UI / बेहतर मोबाइल UI
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="Clearer Instructions" class="custom-check">
                            Clearer instructions / स्पष्ट निर्देश
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="Improved Payments" class="custom-check">
                            Improved payments / बेहतर भुगतान प्रक्रिया
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="None" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_29[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_29_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 30; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Support experience / सहायता अनुभव:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Very Satisfied" class="custom-radio" required>
                            Very good / बहुत अच्छा
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Satisfied" class="custom-radio" required>
                            Good / अच्छा
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Neutral" class="custom-radio" required>
                            Average / औसत
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Unsatisfied" class="custom-radio" required>
                            Poor / खराब
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Very Unsatisfied" class="custom-radio" required>
                            Very poor / बहुत खराब
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_30" value="Didn't Contact" class="custom-radio" required>
                            Didn’t contact / संपर्क नहीं किया
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 31; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Additional feedback / अतिरिक्त प्रतिक्रिया:
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="Good portal" class="custom-radio" required>
                            Good portal / अच्छा पोर्टल
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="Needs improvement" class="custom-radio" required>
                            Needs improvement / सुधार की आवश्यकता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="Satisfactory" class="custom-radio" required>
                            Satisfactory / संतोषजनक
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="Not satisfied" class="custom-radio" required>
                            Not satisfied / असंतुष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="No comments" class="custom-radio" required>
                            No comments / कोई टिप्पणी नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_31" value="Other" class="custom-radio" required>
                            Other / अन्य
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 32; ?>
                
            </div>
            
            <hr class="my-10 border-t-2 border-aisect-accent/50">

            <div class="form-section border-aisect-accent">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 4 — RECOMMENDATION
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 4 — अनुशंसा</span>
                </h2>

                <?php 
                    // $q_current_db should be 32 here
                    $q_current_visual = 1; 
                ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Recommend the portal / पोर्टल की अनुशंसा करें (1-5 scale):
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_32" value="1" class="custom-radio" required>
                            1 (Very Unlikely)
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_32" value="2" class="custom-radio" required>
                            2 (Unlikely)
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_32" value="3" class="custom-radio" required>
                            3 (Neutral)
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_32" value="4" class="custom-radio" required>
                            4 (Likely)
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_32" value="5" class="custom-radio" required>
                            5 (Very Likely)
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db = 33; ?>

                <fieldset class="mb-6">
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. New features desired / नई सुविधाएँ जिन्हें आप देखना चाहते हैं:
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Live Chat Support" class="custom-check">
                            Chat support / चैट सहायता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Tutorial Videos" class="custom-check">
                            Tutorials / ट्यूटोरियल
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Notification System" class="custom-check">
                            Notifications / सूचनाएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Better mobile UI" class="custom-check">
                            Better mobile UI / बेहतर मोबाइल UI
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Faster payments" class="custom-check">
                            Faster payments / तेज भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Customizable Dashboard" class="custom-check">
                            Dashboard enhancements / डैशबोर्ड सुधार
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="None" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_33[]" value="Other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_33_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
            </div>

            <hr class="my-10 border-t-2 border-aisect-blue/50">
            
            <div class="form-section border-gray-500">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 5 — FINAL COMMENTS
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 5 — अंतिम टिप्पणियाँ</span>
                </h2>
                
                <div class="mb-6">
                    <label for="general_comments" class="text-lg font-semibold mb-2 block text-aisect-dark">
                        Any other comments / कोई अन्य टिप्पणियाँ ?:
                    </label>
                    <textarea id="general_comments" name="general_comments" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-aisect-blue focus:border-aisect-blue transition duration-150" placeholder="Type your feedback here..." required></textarea>
                </div>
                
            </div>

            <div class="mt-10 text-center">
                <button type="submit" class="bg-aisect-blue hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-200">
                    Submit / सबमिट करें
                </button>
            </div>
        </form>

    <?php endif; ?>
</div>

<script>
    /**
     * Finds and removes any existing inline error messages for a fieldset.
     */
    function clearErrorMessages(fieldset) {
        const existingError = fieldset.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
    }

    /**
     * Creates and displays an in-line error message within a fieldset.
     */
    function displayErrorMessage(fieldset, message) {
        // Clear any prior message
        clearErrorMessages(fieldset); 
        
        const errorMessage = document.createElement('p');
        errorMessage.className = 'error-message text-sm text-red-600 mt-2 font-medium';
        errorMessage.textContent = message;

        // Insert the error message right after the <legend> tag
        const legend = fieldset.querySelector('legend');
        if (legend) {
            legend.insertAdjacentElement('afterend', errorMessage);
        } else {
             // Fallback: append to the fieldset if no legend is found
            fieldset.appendChild(errorMessage); 
        }

        // Add a visual cue to the section border for clarity
        const section = fieldset.closest('.form-section');
        if (section) {
            section.style.borderColor = '#dc2626'; // Red color for error
        }
    }
    
    /**
     * JavaScript function to validate that at least one checkbox is checked 
     * in the specified multiple-choice groups.
     * * !!! UPDATED CHECKBOX NAMES TO MATCH CONTROLLER'S EXPECTED answer_X[] FIELDS !!!
     */
    function validateCheckboxes(event) {
        const checkboxGroups = [
            'answer_2[]',  // Section 1, Q2: Purpose
            'answer_22[]', // Section 3, Q1: Like_Most
            'answer_23[]', // Section 3, Q2: Issues_Faced
            'answer_25[]', // Section 3, Q4: Useful_Features
            'answer_26[]', // Section 3, Q5: Features_Improvement
            'answer_33[]'  // Section 4, Q2: New_Features_Desired
        ];

        let allValid = true;
        let firstInvalidFieldset = null; // To scroll to the first error

        // Reset all section borders and clear previous error messages
        document.querySelectorAll('.form-section').forEach(section => {
            if (section.classList.contains('border-aisect-blue')) {
                 section.style.borderColor = '#1e40af';
            } else if (section.classList.contains('border-aisect-accent')) {
                 section.style.borderColor = '#f59e0b';
            } else { // SECTION 5
                 section.style.borderColor = '#6b7280';
            }
        });
        document.querySelectorAll('.error-message').forEach(el => el.remove());


        checkboxGroups.forEach(name => {
            const checkboxes = document.getElementsByName(name);
            // Get the parent <fieldset> for this group
            const fieldset = checkboxes.length > 0 ? checkboxes[0].closest('fieldset') : null; 
            
            let checkedCount = 0;
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedCount++;
                }
            });

            if (checkedCount === 0 && fieldset) {
                allValid = false;
                displayErrorMessage(fieldset, "⚠️ Please select at least one option.");
                if (!firstInvalidFieldset) {
                    firstInvalidFieldset = fieldset; // Mark the first one
                }
            } else if (fieldset) {
                // Clear the error message if it's now valid
                clearErrorMessages(fieldset);
            }
        });

        if (!allValid) {
            event.preventDefault(); // Stop form submission

            // Scroll to the first fieldset with an error
            if (firstInvalidFieldset) {
                firstInvalidFieldset.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
            return false;
        }

        // If checkbox validation passes, continue with standard HTML form validation
        return true; 
    }


    // Existing script to handle flash messages after submission
    document.addEventListener('DOMContentLoaded', (event) => {
        const flashMessage = document.getElementById('flash-message');
        
        if (flashMessage) {
            // Fade out the message
            setTimeout(() => {
                flashMessage.style.transition = 'opacity 0.5s ease-out';
                flashMessage.style.opacity = '0';
            }, 4500); 

            // Remove the message element
            setTimeout(() => {
                flashMessage.remove(); 
            }, 5000); 
        }
    });
</script>

</body>
</html>
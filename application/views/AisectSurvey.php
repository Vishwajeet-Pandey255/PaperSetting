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
                            echo $this->session->flashdata('error'); 
                            // Ensure the flashdata is re-set so it doesn't get shown on success later
                            $this->session->keep_flashdata('error'); 
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

        <form action="<?php echo base_url('Aisect_survey/saveSurvey'); ?>" method="post" class="bg-white p-6 sm:p-10 rounded-xl shadow-2xl border border-gray-100" onsubmit="return validateCheckboxes(event);">

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

            <?php 
                // Initialize continuous database question index (Starts at 1) - This is for the name attribute (answer_1, question_1, etc.)
                $q_current_db = 1; 
            ?>

            <div class="form-section border-aisect-blue">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 1 — USER PROFILE
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 1 — उपयोगकर्ता प्रोफ़ाइल</span>
                </h2>
                
                <?php $q_current_visual = 1; // Start visual counter at 1 (Section 1, Q1) ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>"> 
                    
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Usage frequency / उपयोग की आवृत्ति:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Usage frequency">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="daily" class="custom-radio" required> Daily / दैनिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="weekly" class="custom-radio" required> Weekly / साप्ताहिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="monthly" class="custom-radio" required> Monthly / मासिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="occasionally" class="custom-radio" required> Occasionally / कभी-कभी</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="first_time" class="custom-radio" required> First-time user / पहली बार उपयोगकर्ता</label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">
                    
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Purpose (tick all) / उद्देश्य (सभी लागू विकल्प चुनें):
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Purpose (tick all)">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="enrollment" class="custom-check"> Enrollment / नामांकन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="registration" class="custom-check"> Registration / पंजीकरण</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="results_certs" class="custom-check"> Results/Certificates / परिणाम/प्रमाणपत्र</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="payments" class="custom-check"> Payments / भुगतान</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="staff_tasks" class="custom-check"> Staff tasks / स्टाफ कार्य</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="notifications" class="custom-check"> Notifications / सूचनाएँ</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="tech_support" class="custom-check"> Technical support / तकनीकी सहायता</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="update_profile" class="custom-check"> Update profile / प्रोफ़ाइल अपडेट</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check"> Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">
                    
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. User category / उपयोगकर्ता श्रेणी:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="User category">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="student" class="custom-radio" required> Student / छात्र</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="faculty" class="custom-radio" required> Faculty / संकाय</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="admin" class="custom-radio" required> Admin / प्रशासनिक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="parent" class="custom-radio" required> Parent / अभिभावक</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="partner_staff" class="custom-radio" required> Partner staff / साझेदार स्टाफ</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="other" class="custom-radio" required> Other / अन्य</label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Usage duration / उपयोग अवधि:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Usage duration">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="<6m" class="custom-radio" required> &lt;6 months / 6 महीने से कम</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="6-12m" class="custom-radio" required> 6–12 months / 6–12 महीने</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="1-2y" class="custom-radio" required> 1–2 years / 1–2 वर्ष</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value=">2y" class="custom-radio" required> &gt;2 years / 2 वर्ष से अधिक</label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Device used / उपयोग किया गया उपकरण:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Device used">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="laptop" class="custom-radio" required> Laptop / लैपटॉप</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="android" class="custom-radio" required> Android phone / एंड्रॉयड फोन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="iphone" class="custom-radio" required> iPhone / आईफोन</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="tablet" class="custom-radio" required> Tablet / टैबलेट</label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="SECTION 1">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Browser / ब्राउज़र:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Browser">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="chrome" class="custom-radio" required> Chrome</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="firefox" class="custom-radio" required> Firefox</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="edge" class="custom-radio" required> Edge</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="safari" class="custom-radio" required> Safari</label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer"><input type="radio" name="answer_<?= $q_current_db ?>" value="other" class="custom-radio" required> Other / अन्य</label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>
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
                            $section_name_2 = "SECTION 2 — RATING";
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
                            // RESETTING THE VISUAL/QUESTION NUMBER COUNTER FOR THE NEW SECTION
                            $q_current_visual = 1; 
                            
                            foreach ($questions_2 as $q_text):
                            ?>
                            <tr class="bg-white border-b hover:bg-aisect-light/30">
                                <td class="py-4 px-3 font-medium text-gray-900"><?= $q_current_visual ?>.</td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap">
                                    <?= $q_text ?>
                                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_2 ?>">
                                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">
                                    <input type="hidden" name="question_<?= $q_current_db ?>" value="<?= strip_tags($q_text) ?>"> 
                                </td>
                                <?php for ($val = 1; $val <= 5; $val++): ?>
                                <td class="py-4 px-6 text-center">
                                    <input type="radio" name="answer_<?= $q_current_db ?>" value="<?= $val ?>" class="custom-radio" required>
                                </td>
                                <?php endfor; ?>
                            </tr>
                            <?php 
                            $q_current_visual++; // Increment visual counter (1, 2, 3...)
                            $q_current_db++;     // Increment continuous database counter (7, 8, 9...)
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
                    // RESETTING THE VISUAL/QUESTION NUMBER COUNTER FOR THE NEW SECTION
                    $q_current_visual = 1; 
                    $section_name_3 = "SECTION 3 — MULTIPLE CHOICE FEEDBACK"; 
                ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">
                    
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. What do you like most? / आपको सबसे अधिक क्या पसंद है?
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="What do you like most?">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="navigation" class="custom-check">
                            Navigation / नेविगेशन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="speed" class="custom-check">
                            Speed / गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="payments" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="certificates" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="dashboard" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="info_availability" class="custom-check">
                            Info availability / जानकारी उपलब्धता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="design" class="custom-check">
                            Design / डिजाइन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="nothing" class="custom-check">
                            Nothing / कुछ नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">
                    
                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Issues faced (tick all) / समस्याएँ (सभी लागू चुनें):
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Issues faced (tick all)">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="slow_speed" class="custom-check">
                            Slow speed / धीमी गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="payment_errors" class="custom-check">
                            Payment errors / भुगतान त्रुटियाँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="mobile_issues" class="custom-check">
                            Mobile issues / मोबाइल समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="incorrect_info" class="custom-check">
                            Incorrect info / गलत जानकारी
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="login_issues" class="custom-check">
                            Login issues / लॉगिन समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="downtime" class="custom-check">
                            Downtime / डाउनटाइम
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="errors" class="custom-check">
                            Errors / त्रुटियाँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="navigation_issues" class="custom-check">
                            Navigation issues / नेविगेशन समस्याएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="no_issues" class="custom-check">
                            No issues / कोई समस्या नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>


                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Errors/downtime frequency / त्रुटि/डाउनटाइम की आवृत्ति:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Errors/downtime frequency">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="frequent" class="custom-radio" required>
                            Frequent / बार-बार
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="occasional" class="custom-radio" required>
                            Occasional / कभी-कभी
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="rare" class="custom-radio" required>
                            Rare / कम
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="never" class="custom-radio" required>
                            Never / कभी नहीं
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>


                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Useful features / उपयोगी सुविधाएँ:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Useful features">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="enrollment" class="custom-check">
                            Enrollment / नामांकन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="registration" class="custom-check">
                            Registration / पंजीकरण
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="payments" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="certificates" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="dashboard" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="notifications" class="custom-check">
                            Notifications / सूचनाएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="profile_update" class="custom-check">
                            Profile update / प्रोफ़ाइल अपडेट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="none" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Features needing improvement / सुधार की आवश्यकता वाली सुविधाएँ:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Features needing improvement">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="speed" class="custom-check">
                            Speed / गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="payments" class="custom-check">
                            Payments / भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="mobile_view" class="custom-check">
                            Mobile view / मोबाइल दृश्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="login_otp" class="custom-check">
                            Login/OTP
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="search" class="custom-check">
                            Search / खोज
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="certificates" class="custom-check">
                            Certificates / प्रमाणपत्र
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="dashboard" class="custom-check">
                            Dashboard / डैशबोर्ड
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="nothing" class="custom-check">
                            Nothing / कुछ नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Payment process difficulty / भुगतान प्रक्रिया की कठिनाई:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Payment process difficulty">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_easy" class="custom-radio" required>
                            Very easy / बहुत आसान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="easy" class="custom-radio" required>
                            Easy / आसान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="neutral" class="custom-radio" required>
                            Neutral / सामान्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="difficult" class="custom-radio" required>
                            Difficult / कठिन
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_difficult" class="custom-radio" required>
                            Very difficult / बहुत कठिन
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Clarity of instructions / निर्देशों की स्पष्टता:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Clarity of instructions">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_clear" class="custom-radio" required>
                            Very clear / बहुत स्पष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="clear" class="custom-radio" required>
                            Clear / स्पष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="neutral" class="custom-radio" required>
                            Neutral / सामान्य
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="confusing" class="custom-radio" required>
                            Confusing / भ्रमित करने वाला
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_confusing" class="custom-radio" required>
                            Very confusing / बहुत भ्रमित करने वाला
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Improvements wanted / वांछित सुधार:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Improvements wanted">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="faster_speed" class="custom-check">
                            Faster speed / तेज गति
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="better_mobile_ui" class="custom-check">
                            Better mobile UI / बेहतर मोबाइल UI
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="clearer_instructions" class="custom-check">
                            Clearer instructions / स्पष्ट निर्देश
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="improved_payments" class="custom-check">
                            Improved payments / बेहतर भुगतान प्रक्रिया
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="none" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Support experience / सहायता अनुभव:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Support experience">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_good" class="custom-radio" required>
                            Very good / बहुत अच्छा
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="good" class="custom-radio" required>
                            Good / अच्छा
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="average" class="custom-radio" required>
                            Average / औसत
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="poor" class="custom-radio" required>
                            Poor / खराब
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="very_poor" class="custom-radio" required>
                            Very poor / बहुत खराब
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="didnt_contact" class="custom-radio" required>
                            Didn’t contact / संपर्क नहीं किया
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_3 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Additional feedback / अतिरिक्त प्रतिक्रिया:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Additional feedback">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="good_portal" class="custom-radio" required>
                            Good portal / अच्छा पोर्टल
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="needs_improvement" class="custom-radio" required>
                            Needs improvement / सुधार की आवश्यकता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="satisfactory" class="custom-radio" required>
                            Satisfactory / संतोषजनक
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="not_satisfied" class="custom-radio" required>
                            Not satisfied / असंतुष्ट
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="no_comments" class="custom-radio" required>
                            No comments / कोई टिप्पणी नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="other" class="custom-radio" required>
                            Other / अन्य
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>
                
            </div>
            
            <hr class="my-10 border-t-2 border-aisect-accent/50">

            <div class="form-section border-aisect-accent">
                <h2 class="text-2xl font-bold mb-6 text-aisect-dark">
                    SECTION 4 — RECOMMENDATION
                    <span class="text-gray-500 font-normal text-lg ml-2">/ अनुभाग 4 — अनुशंसा</span>
                </h2>

                <?php 
                    // $q_current_db should be 32 here
                    // RESETTING THE VISUAL/QUESTION NUMBER COUNTER FOR THE NEW SECTION
                    $q_current_visual = 1; 
                    $section_name_4 = "SECTION 4 — RECOMMENDATION"; 
                ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_4 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. Recommend the portal / पोर्टल की अनुशंसा करें (1-5 scale):
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="Recommend the portal (1-5 scale)">
                    </legend>
                    <div class="flex flex-wrap gap-x-6 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="1" class="custom-radio" required>
                            1
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="2" class="custom-radio" required>
                            2
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="3" class="custom-radio" required>
                            3
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="4" class="custom-radio" required>
                            4
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="radio" name="answer_<?= $q_current_db ?>" value="5" class="custom-radio" required>
                            5
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>

                <fieldset class="mb-6">
                    <input type="hidden" name="section_<?= $q_current_db ?>" value="<?= $section_name_4 ?>">
                    <input type="hidden" name="question_number_<?= $q_current_db ?>" value="<?= $q_current_visual ?>">

                    <legend class="text-lg font-semibold mb-3 text-aisect-dark">
                        <?= $q_current_visual++ ?>. New features desired / नई सुविधाएँ जिन्हें आप देखना चाहते हैं:
                        <input type="hidden" name="question_<?= $q_current_db ?>" value="New features desired">
                    </legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-3">
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="chat_support" class="custom-check">
                            Chat support / चैट सहायता
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="tutorials" class="custom-check">
                            Tutorials / ट्यूटोरियल
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="notifications" class="custom-check">
                            Notifications / सूचनाएँ
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="better_mobile_ui" class="custom-check">
                            Better mobile UI / बेहतर मोबाइल UI
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="faster_payments" class="custom-check">
                            Faster payments / तेज भुगतान
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="dashboard_enhancements" class="custom-check">
                            Dashboard enhancements / डैशबोर्ड सुधार
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="none" class="custom-check">
                            None / कोई नहीं
                        </label>
                        <label class="inline-flex items-center text-gray-700 cursor-pointer">
                            <input type="checkbox" name="answer_<?= $q_current_db ?>[]" value="other" class="custom-check">
                            Other / अन्य:
                            <input type="text" name="answer_<?= $q_current_db ?>_other_text" class="ml-2 p-1 border rounded focus:ring-aisect-blue focus:border-aisect-blue w-24">
                        </label>
                    </div>
                </fieldset>
                <?php $q_current_db++; ?>
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
     */
    function validateCheckboxes(event) {
        const checkboxGroups = [
            // List of all checkbox groups requiring at least one selection
            'answer_2[]',  // Section 1 - Purpose (Q2)
            'answer_22[]', // Section 3 - What do you like most? (Q1)
            'answer_23[]', // Section 3 - Issues faced (Q2)
            'answer_25[]', // Section 3 - Useful features (Q4)
            'answer_26[]', // Section 3 - Features needing improvement (Q5)
            'answer_33[]'  // Section 4 - New features desired (Q2)
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
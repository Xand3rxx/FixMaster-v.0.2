INSERT INTO `message_templates` (`id`, `uuid`, `title`, `content`, `sms`, `feature`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '5cf39057-f133-404a-8d56-473ede9ebdba', 'Welcome User', '<p>Hello&nbsp;{firstname}&nbsp;{lastname}, thank you for registering with us. Kindly use this link&nbsp;<a href=\"{url}\">click here</a> to verify your account.</p><p><a href=\"http://{url}\" target=\"_blank\">here</a></p>', 'Hello {firstname} {lastname}, thank you for registering with us. Kindly use this link {url} to verify your account.', 'USER_EMAIL_VERIFICATION', '2021-05-28 08:46:57', '2021-05-28 09:46:02', NULL),
(3, '51f55df7-b907-4758-9330-8d2e7a322220', 'CSE Assign QA', '<p>Dear {qa_name},</p><p>A QA Support request for {job_ref} has been assigned to you successfully. Please view the job details below and be on standby; the Customer Service Executive will contact you shortly.</p><p><b>JOB DETAILS</b></p><ul><li><b>CSE ASSIGNED: {cse_name}</b></li><li><b>EMAIL: {cse_email}</b></li><li><b>TELEPHONE: {cse_phone}</b></li><li><b>JOB SERVICE CATEGORY: {service_category}</b></li><li><b>SUB-SERVICE CATEGORY: {sub_service_category}</b></li><li><b>JOB STATUS: {job_status}</b></li><li><b><br></b></li><li>Please click here to view images, videos and additional details of {job_ref}</li></ul><p>Remember, your expertise will aid the prompt completion of the {job_status}!</p><p>Your job rating counts! Remember to requests for a rating from the CSE when the {job_status} is completed.</p><p>Yours Sincerely</p><p>FixMaster Team</p>', 'Dear {qa_name},\n\nA QA Support request for {job_ref} has been assigned to you successfully. Please view the job details below and be on standby; the Customer Service Executive will contact you shortly.\n\nJOB DETAILS\n\nCSE ASSIGNED: {cse_name}\nEMAIL: {cse_email}\nTELEPHONE: {cse_phone}\nJOB SERVICE CATEGORY: {service_category}\nSUB-SERVICE CATEGORY: {sub_service_category}\nJOB STATUS: {job_status}\n\nPlease click here to view images, videos and additional details of {job_ref}\nRemember, your expertise will aid the prompt completion of the {job_status}!\n\nYour job rating counts! Remember to requests for a rating from the CSE when the {job_status} is completed.\n\nYours Sincerely\n\nFixMaster Team', 'CSE_ASSIGNED_QA_TO_A_JOB', '2021-05-28 12:36:19', '2021-05-28 12:36:19', NULL),
(4, '35eea323-77ea-4256-9452-4bdf85e9a815', 'Admin Assign QA', '<p><font face=\"Helvetica\">Dear {qa_name},&nbsp;</font></p><p><font face=\"Helvetica\">A QA support request for {job_ref} has been assigned to you successfully.&nbsp;</font></p><p><font face=\"Helvetica\">Please view the job details below and be on standby; the Customer Service Executive will contact you shortly.</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\"><b>JOB DETAILS</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • CSE ASSIGNED: {cse_name}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • EMAIL: {cse_email}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • TELEPHONE: {cse_phone no}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • JOB SERVICE CATEGORY: {category}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • SERVICE CATEGORY: {service}&nbsp;&nbsp;</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • SUB-SERVICE CATEGORY: {sub_service}&nbsp;</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • JOB STATUS: {job_status}</b></font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Please click here to view images, videos and additional details of {job_ref}&nbsp;</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Remember, your expertise will aid the prompt completion of the {job_status}!</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Your job rating counts! Remember to request for a rating from the CSE when the {job_status} is completed.&nbsp;&nbsp;</font></p><p><font face=\"Helvetica\">Yours Sincerely</font></p><p><font face=\"Helvetica\">FixMaster Team</font></p>', 'Dear {qa_name},\nA QA support request for {job_ref} has been assigned to you successfully. \n\nPlease view the job details below and be on standby; the Customer Service Executive will contact you shortly.', 'ADMIN_ASSIGNED_QA_TO_A_JOB', '2021-05-28 13:02:08', '2021-05-28 13:02:08', NULL),
(5, '49a1f5b1-f220-4ee7-8070-c33768015c35', 'Admin Job Reminder', '<p><font face=\"Helvetica\">Dear {cse_name},</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Here is a reminder that {job_ref} is pending. Please view the job details below and complete the job on schedule.</font></p><p><font face=\"Helvetica\">JOB DETAILS</font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • TECHNICIAN ASSIGNED: {technician_name}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • TECHNICIAN TELEPHONE: {technician_phone_no}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • QA TECHNICIAN ASSIGNED: {qa_technician_phone_no}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • JOB SERVICE CATEGORY: {category}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • SERVICE CATEGORY: {service}&nbsp;&nbsp;</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • SUB-SERVICE CATEGORY: {sub_service}&nbsp;</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • JOB STATUS: {job_status}</b></font></p><p><font face=\"Helvetica\"><b>&nbsp; &nbsp; • SCHEDULED DATE/TIME: {date_time}</b></font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Please click here to view images, videos and additional details of {job_ref}.</font></p><p><font face=\"Helvetica\">Thank you</font></p><p><font face=\"Helvetica\">FixMaster Team</font></p>', 'Dear {cse_name},\n\n\n\nHere is a reminder that {job_ref} is pending. Please view the job details below and complete the job on schedule.', 'ADMIN_PENDING_JOB_REMINDER_NOTIFICATION', '2021-05-28 13:05:29', '2021-05-28 13:05:29', NULL),
(6, '87c4e531-22f9-4b97-b424-c65f4da7ba63', 'Admin Message', '<p><font face=\"Helvetica\">Dear {admin_title},</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">You have a NEW message from the FixMaster {admin_title}.&nbsp;</font></p><p><font face=\"Helvetica\">Please log into your portal to view your message!</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Please click here to login to the Admin portal.&nbsp;</font></p><p><font face=\"Helvetica\"><br></font></p><p><font face=\"Helvetica\">Thank you</font></p><p><font face=\"Helvetica\">FixMaster Team</font></p>', 'Dear {admin_title},\n\nYou have a NEW message from the FixMaster {admin_title}.\nPlease log into your portal to view your message.\nPlease click here to login to the Admin portal. \n\nThank you', 'ADMIN_SENT_ADMIN_MESSAGE_NOTIFICATION', '2021-05-28 13:08:54', '2021-05-28 13:08:54', NULL),
(7, 'd45acd36-959f-4de2-ab0c-dfac00bce8c7', 'Admin Message', '<p>Dear {cse_name},</p><p><br></p><p>You have a NEW message from the FixMaster {admin_title}.&nbsp;</p><p>Please log into your portal to view your message!</p><p><br></p><p>Please click <a href=\"{url}\">here</a> to login to the CSE portal.&nbsp;</p><p><br></p><p>Thank you</p><p>FixMaster Team</p>', 'Dear {cse_name},\n\n\n\nYou have a NEW message from the FixMaster {admin_title}. \n\nPlease log into your portal to view your message!', 'ADMIN_SENT_CSE_MESSAGE_NOTIFICATION', '2021-05-28 13:11:01', '2021-05-28 13:11:01', NULL),
(8, 'c88c536b-5734-449b-b5f8-bb7e7bd2ec20', 'Admin Message', '<p>Dear {first_name} {last_name}</p><p><br></p><p>You have a NEW message from the FixMaster Administrator.&nbsp;</p><p>Please log into your portal to view your message!</p><p><br></p><p>Please click <a href=\"{url}\">here</a> to login and view message details.&nbsp;</p><p><br></p><p>Thank you</p><p>FixMaster Team</p>', 'Dear {first_name} {last_name}\n\n\n\nYou have a NEW message from the FixMaster Administrator. \n\nPlease log into your portal to view your message!', 'ADMIN_SENT_CUSTOMER_MESSAGE_NOTIFICATION', '2021-05-28 13:12:28', '2021-05-28 13:12:28', NULL),
(9, 'af791809-1673-4e3c-86b5-c882741c7010', 'Admin Message', '<p>Dear {supplier_name},</p><p><br></p><p>You have a NEW message from the FixMaster Administrator.&nbsp;</p><p>Please log into your portal to view your message!</p><p><br></p><p>Please click <a href=\"{url}\">here</a> to login to the Supplier portal.&nbsp;</p><p><br></p><p>Thank you</p><p>FixMaster Team</p>', 'Dear {supplier_name},\n\n\n\nYou have a NEW message from the FixMaster Administrator. \n\nPlease log into your portal to view your message!', 'ADMIN_SENT_SUPPLIER_MESSAGE_NOTIFICATION', '2021-05-28 13:13:30', '2021-05-28 13:13:30', NULL),
(10, '6e4ff0f1-096f-48f6-9799-a8fab7d56b07', 'Admin Message', '<p>Dear {technician_name},</p><p><br></p><p>You have a NEW message from the FixMaster {admin_title}.&nbsp;</p><p>Please log into your portal to view your message!</p><p><br></p><p>Please click <a href=\"{url}\">here</a> to login to the Technician portal.&nbsp;</p><p><br></p><p>Thank you</p><p>FixMaster Team</p>', 'Dear {technician_name},\n\n\n\nYou have a NEW message from the FixMaster {admin_title}. \n\nPlease log into your portal to view your message!', 'ADMIN_SENT_TECHNICIAN_MESSAGE_NOTIFICATION', '2021-05-28 13:14:42', '2021-05-28 13:14:42', NULL),
(11, 'e5ae6e0c-d3b9-4425-b22e-8c257ddbdeae', 'Admin Message', '<p>Dear {qa_name},</p><p><br></p><p>You have a NEW message from the FixMaster {admin_title}.&nbsp;</p><p>Please log into your portal to view your message!</p><p><br></p><p>Please click <a href=\"{url}\">here</a> to login to your dashboard and view details of the message.&nbsp;</p><p><br></p><p>Thank you</p><p>FixMaster Team</p>', 'Dear {qa_name},\n\n\n\nYou have a NEW message from the FixMaster {admin_title}. \n\nPlease log into your portal to view your message!', 'ADMIN_SENT_QA_MESSAGE_NOTIFICATION', '2021-05-28 13:15:42', '2021-05-28 13:15:42', NULL),
(12, '0e091628-6c4e-4868-a1fe-bb7be6c499a2', 'Warranty Claim', '<p>Dear {first_name} {last_name},</p><p><br></p><p>Your warranty claim has been received by FixMaster.&nbsp;</p><p>FixMaster value proposition to her esteemed customers is to deliver quality services ALWAYS. We apologize that on this occasion, our service fell short of your expectation.&nbsp;</p><p>Please be reassured that your warranty claim will be processed immediately. A Customer Service Executive will be assigned to your job {job_ref} shortly.</p><p><br></p><p>Thank you.</p><p>Fix Master Team</p>', 'Dear {first_name} {last_name},\n\n\n\nYour warranty claim has been received by FixMaster. \n\nFixMaster value proposition to her esteemed customers is to deliver quality services ALWAYS. We apologize that on this occasion, our service fell short of your expectation.', 'ADMIN_WARRANTY_CLAIM_NOTIFICATION', '2021-05-28 13:31:31', '2021-05-28 13:31:31', NULL),
(13, 'af3813e8-00a1-44de-9d75-b54d09ee20b7', 'Warranty Claim Resolved', '<p>Dear {firstname} {lastname},</p><p><br></p><p>Your warranty claim has been successfully resolved by FixMaster.&nbsp;</p><p>FixMaster value proposition to her esteemed customers is to deliver quality services ALWAYS.&nbsp;</p><p>Thank you for allowing us serve you!</p><p>Your feedback is very important to us- please rate the CSE and the overall FixMaster service.</p><p><br></p><p>Thank you.</p><p>Fix Master Team</p>', 'Dear {firstname} {lastname},\n\nYour warranty claim has been successfully resolved by FixMaster. \nFixMaster value proposition to her esteemed customers is to deliver quality services ALWAYS. \nThank you for allowing us serve you.\nYour feedback is very important to us- please rate the CSE and the overall FixMaster service.\n\nThank you.\nFix Master Team', 'ADMIN_WARRANTY_CLAIM_RESOLVED_NOTIFICATION', '2021-05-28 13:34:50', '2021-05-28 13:34:50', NULL);
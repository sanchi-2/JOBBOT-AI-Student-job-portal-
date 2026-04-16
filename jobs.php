<!DOCTYPE html>
<html>
<head>
<title>Jobs | JobBot</title>

<style>

body{
font-family: Arial;
background:#f5f5f5;
margin:0;
}

.container{
width:80%;
margin:auto;
padding:20px;
}

h2{
text-align:center;
color:#333;
}

/* BACK BUTTON */
.back-btn{
background:#333;
color:white;
padding:8px 12px;
border-radius:5px;
border:none;
cursor:pointer;
margin-bottom:15px;
}

.back-btn:hover{
background:#000;
}

.job-card{
background:white;
padding:20px;
margin-top:20px;
border-radius:8px;
box-shadow:0px 0px 10px rgba(0,0,0,0.1);
transition:0.3s;
}

.job-card:hover{
transform:scale(1.02);
}

.job-type{
display:inline-block;
padding:5px 10px;
border-radius:5px;
font-size:13px;
margin-bottom:10px;
color:white;
}

.wfh{
background:#28a745;
}

.office{
background:#ff5733;
}

.hybrid{
background:#6f42c1;
}

button{
background:#007bff;
color:white;
border:none;
padding:10px 15px;
border-radius:5px;
cursor:pointer;
margin-top:10px;
}

button:hover{
background:#0056b3;
}

</style>

</head>

<body>

<div class="container">

<!-- BACK BUTTON -->
<button class="back-btn" onclick="goBack()">⬅ Back to Home</button>

<h2>🔥 Latest Jobs</h2>

<!-- Job 1 -->
<div class="job-card">
<span class="job-type wfh">Remote</span>
<h3>Data Science Internship</h3>
<p><b>Company:</b> ABC Technologies</p>
<p><b>Salary:</b> ₹10,000/month</p>
<p><b>Duration:</b> 6 Months</p>
<button onclick="applyJob('Data Science Internship')">Apply Now</button>
</div>

<!-- Job 2 -->
<div class="job-card">
<span class="job-type office">On-Site</span>
<h3>Web Development Internship</h3>
<p><b>Company:</b> XYZ Solutions</p>
<p><b>Salary:</b> ₹8,000/month</p>
<p><b>Duration:</b> 3 Months</p>
<button onclick="applyJob('Web Development Internship')">Apply Now</button>
</div>

<!-- Job 3 -->
<div class="job-card">
<span class="job-type hybrid">Hybrid</span>
<h3>Machine Learning Intern</h3>
<p><b>Company:</b> AI Labs</p>
<p><b>Salary:</b> ₹12,000/month</p>
<p><b>Duration:</b> 6 Months</p>
<button onclick="applyJob('Machine Learning Intern')">Apply Now</button>
</div>

<!-- Job 4 -->
<div class="job-card">
<span class="job-type wfh">Remote</span>
<h3>Content Writing Internship</h3>
<p><b>Company:</b> MediaTech</p>
<p><b>Salary:</b> ₹6,000/month</p>
<p><b>Duration:</b> 2 Months</p>
<button onclick="applyJob('Content Writing Internship')">Apply Now</button>
</div>

<!-- Job 5 -->
<div class="job-card">
<span class="job-type office">On-Site</span>
<h3>UI / UX Designer</h3>
<p><b>Company:</b> DesignHub</p>
<p><b>Salary:</b> ₹15,000/month</p>
<p><b>Duration:</b> 4 Months</p>
<button onclick="applyJob('UI/UX Designer')">Apply Now</button>
</div>

<!-- Job 6 -->
<div class="job-card">
<span class="job-type wfh">Remote</span>
<h3>PHP Developer Intern</h3>
<p><b>Company:</b> CodeCraft</p>
<p><b>Salary:</b> ₹9,000/month</p>
<p><b>Duration:</b> 5 Months</p>
<button onclick="applyJob('PHP Developer Intern')">Apply Now</button>
</div>

</div>

<!-- JAVASCRIPT -->
<script>

// BACK TO HOME
function goBack() {
    window.location.href = "index.php"; // change if your home page name is different
}

// APPLY BUTTON ACTION
function applyJob(jobTitle) {
    alert("You applied for: " + jobTitle + " 🎉");
}

</script>

</body>
</html>
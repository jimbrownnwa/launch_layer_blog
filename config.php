<?php
// Blog Configuration

// Load local secrets if available (for development)
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// Claude API
define('CLAUDE_API_KEY', getenv('CLAUDE_API_KEY') !== false ? getenv('CLAUDE_API_KEY') : '');
define('CLAUDE_MODEL', 'claude-sonnet-4-5-20250929');

// Amazon Affiliate
define('AMAZON_AFFILIATE_TAG', getenv('AMAZON_AFFILIATE_TAG') !== false ? getenv('AMAZON_AFFILIATE_TAG') : '');

// Cron job security token (32 hex characters)
define('CRON_TOKEN', getenv('CRON_TOKEN') !== false ? getenv('CRON_TOKEN') : '');

// Blog Settings
define('BLOG_TITLE', 'Launch Layer Blog');
define('BLOG_DESCRIPTION', 'Established Principles, Frameworks & Solutions for Small Business');
define('POSTS_PER_PAGE', 10);

// Database - use mounted volume in production, local dir in development
$dbDir = is_dir('/app/data') ? '/app/data' : __DIR__;
define('DB_PATH', $dbDir . '/blog.db');

// Testing mode (5 min interval) vs Production (daily)
define('TESTING_MODE', true);

// Predefined Topics for Blog Posts
$TOPICS = [
    // Management & Leadership
    "The Eisenhower Matrix: Prioritizing Tasks for Maximum Business Impact",
    "Kaizen: Continuous Improvement for Small Business Operations",
    "The PDCA Cycle: Plan-Do-Check-Act for Systematic Problem Solving",
    "Servant Leadership: Building Teams That Build Your Business",
    "The 80/20 Principle: Focusing on What Really Moves the Needle",

    // Operations & Process
    "Lean Methodology: Eliminating Waste in Small Business Operations",
    "Six Sigma Basics: Quality Control for Growing Companies",
    "Theory of Constraints: Finding and Fixing Your Business Bottlenecks",
    "Standard Operating Procedures: Creating Consistency at Scale",
    "Value Stream Mapping: Visualizing Your Business Processes",

    // Strategy & Planning
    "SWOT Analysis: Strategic Planning That Actually Works",
    "Porter's Five Forces: Understanding Your Competitive Landscape",
    "The Balanced Scorecard: Measuring What Matters",
    "OKRs: Objectives and Key Results for Small Business Growth",
    "Blue Ocean Strategy: Finding Uncontested Market Space",

    // Finance & Growth
    "Cash Flow Management: The Lifeblood of Small Business",
    "Unit Economics: Understanding Your True Profitability",
    "The Rule of 40: Balancing Growth and Profitability",
    "Customer Lifetime Value: Building for Long-Term Success",
    "Break-Even Analysis: Making Smarter Investment Decisions",

    // Customer & Marketing
    "Jobs to Be Done: Understanding What Customers Really Want",
    "The Sales Funnel: Converting Prospects to Loyal Customers",
    "Net Promoter Score: Measuring Customer Loyalty Simply",
    "The 4 Ps of Marketing: Product, Price, Place, Promotion",
    "Customer Journey Mapping: Improving Every Touchpoint",

    // Team & Culture
    "The Five Dysfunctions of a Team: Building Cohesive Teams",
    "RACI Matrix: Clarifying Roles and Responsibilities",
    "Hiring A-Players: The Topgrading Method",
    "One-on-Ones: The Most Important Meeting You'll Have",
    "Culture Code: Defining Your Company Values That Stick",

    // Productivity & Systems
    "Getting Things Done (GTD): Personal Productivity for Business Owners",
    "Time Blocking: Protecting Your Most Valuable Resource",
    "The Pomodoro Technique: Focused Work in Short Bursts",
    "Inbox Zero: Email Management for Busy Entrepreneurs",
    "Decision Fatigue: Simplifying Choices to Improve Outcomes",

    // Problem Solving
    "Root Cause Analysis: The 5 Whys Technique",
    "Fishbone Diagrams: Systematic Problem Investigation",
    "First Principles Thinking: Breaking Down Complex Problems",
    "Pre-Mortem Analysis: Preventing Failures Before They Happen",
    "After Action Reviews: Learning from Every Project",

    // Hidden Costs & Vendor Evaluation
    "Total Cost of Ownership: Evaluating All Direct and Indirect Costs",
    "Build vs. Buy Decision Framework: A Systematic Evaluation Guide",
    "SaaS Contract Review: Legal Checklist for Scope Creep and Price Escalation",
    "Proof of Concept Methodology: Structured Pilot Testing Before Commitment",
    "Reference Checking Framework: Validating Vendor Claims Through Customers",
    "Escrow Agreements: Protecting Critical Business Systems Against Vendor Failure",

    // User Experience & Workflow
    "Workflow Mapping: Documenting Current vs. Ideal State Processes",
    "Usability Heuristics: Nielsen Norman Group's 10 Principles for Interface Evaluation",
    "User Acceptance Testing: Structured Testing with End Users Before Deployment",
    "Prosci ADKAR Model: Change Management for Tool Adoption",

    // Learning & Training
    "The 70-20-10 Learning Model: On-the-Job Experience, Coaching, and Formal Training",
    "Competency-Based Training: Skills Assessment and Targeted Learning Paths",
    "Knowledge Management Systems: Centralized Repositories for Documentation",
    "Spaced Repetition Learning: Evidence-Based Training for Better Retention",
    "Train-the-Trainer Methodology: Building Internal Expertise",
    "Microlearning: Breaking Complex Systems into Bite-Sized Modules",

    // Technology Decisions
    "Decision Matrix Analysis: Weighted Scoring with the Pugh Matrix",
    "MVP Thinking: Start with Essential Features and Expand Incrementally",
    "OODA Loop: Rapid Decision-Making from Military Strategy",
    "Satisficing vs. Maximizing: Herbert Simon's Good Enough Decisions",
    "Two-Way Door Decisions: Jeff Bezos on Reversible vs. Irreversible Choices",
    "Technology Adoption Lifecycle: Matching Risk Tolerance to the Adoption Curve",

    // Cash Flow & Treasury
    "13-Week Cash Flow Forecasting: Rolling Liquidity Planning",
    "Cash Conversion Cycle: Optimizing DSO, DIO, and DPO",
    "Zero-Based Budgeting: Regular Review and Justification of Cash Outflows",
    "Reserve Requirements: Maintaining 3-6 Months Operating Expenses",
    "Float Management: Optimizing Payment Timing and Settlement",
    "Scenario Planning: What-If Analysis for Cash Flow Disruptions",

    // Time & Productivity
    "Deep Work: Cal Newport's Time Blocking for High-Value Activities",
    "Delegation Framework: Evaluating Tasks by Uniqueness and Importance",
    "Parkinson's Law: Why Work Expands to Fill Time Allocated",
    "Automation ROI Calculator: Quantifying Time Savings vs. Implementation Cost",
    "Maker vs. Manager Schedule: Paul Graham's Framework for Protecting Creative Time",

    // Change Management & Adoption
    "Diffusion of Innovations: Understanding Adopters from Innovators to Laggards",
    "Kotter's 8-Step Change Model: Creating Urgency and Building Coalitions",
    "Cognitive Load Theory: Reducing Mental Burden Through Gradual Introduction",
    "Social Learning Theory: Peer Modeling for Successful Technology Adoption",
    "Growth Mindset Training: Reframing Technology Learning as Skill Development",
    "Reverse Mentoring: Younger Employees Teaching Technology to Colleagues",
    "Champion Networks: Using Early Adopters to Evangelize and Support Others",

    // Vendor Trust & Due Diligence
    "Signaling Theory: Looking for Costly Signals of Vendor Quality",
    "Vendor Due Diligence Checklist: Financial Stability, Security, and Retention",
    "Service Level Agreements: Contractual Guarantees with Performance Penalties",
    "SOC 2 and ISO 27001: Understanding Third-Party Security Audits",
    "Community Validation: Peer Networks and User Groups for Vendor Research",

    // Work-Life Balance & Sustainability
    "Boundaries Framework: Physical, Emotional, and Time Boundaries at Work",
    "Energy Management: Tony Schwartz on Renewal and Recovery Cycles",
    "4 Disciplines of Execution: Focus on Wildly Important Goals",
    "The Delegation Ladder: Seven Levels from Tell to Fully Delegate",
    "E-Myth Revisited: Working ON Your Business Instead of IN It",
    "Peer Advisory Groups: Structured Support from Vistage and EO",
    "EOS Traction: Strategic Planning for Predictability and Reduced Chaos"
];

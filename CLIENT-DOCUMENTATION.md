# IL Marine VAS - Complete User Documentation

## Table of Contents
1. [System Overview](#system-overview)
2. [Key Terminology](#key-terminology)
3. [User Roles and Permissions](#user-roles-and-permissions)
4. [System Workflow](#system-workflow)
5. [Status Definitions](#status-definitions)
6. [Content Management System](#content-management-system)
7. [Step-by-Step User Guide](#step-by-step-user-guide)
8. [Mobile App Features](#mobile-app-features)
9. [Reports and Analytics](#reports-and-analytics)

---

## System Overview

**IL Marine VAS** (ICICI Lombard Marine Value Added Services) is a comprehensive Marine Loss Control and Engineering (MLCE) management system designed to manage marine cargo inspections, risk assessments, and loss prevention activities.

### What is MLCE?
**Marine Loss Control and Engineering (MLCE)** is a specialized service in marine insurance that involves:
- **Risk Assessment**: Evaluating potential hazards in marine cargo handling and transportation
- **Loss Prevention**: Implementing measures to reduce the frequency and severity of marine losses
- **Survey and Inspection**: Conducting on-site inspections of marine facilities, cargo handling operations, and storage areas
- **Recommendations**: Providing actionable recommendations to minimize risks and improve safety standards

---

## Key Terminology

### Core Terms
- **MLCE Indent**: A work order or request for conducting a marine risk assessment survey
- **Assignment**: The allocation of a specific survey task to an inspector for a particular location
- **Survey**: The actual inspection and assessment process conducted at the client's premises
- **Recommendations**: Risk mitigation suggestions provided after the survey completion

### Survey Types
- **Value Addition**: Engagement to evaluate, assess & mitigate risk
- **Mitigating Risk & Losses**: Pre-loss activities focused on managing Special Loss Ratio (SLR) & loss frequency
- **Reducing Loss Occurrences**: Loss prevention considering loss ratio & frequency factors
- **Post Loss Activity**: Loss investigation & minimization activities

### Status Codes
- **CMMI**: Commenced Marine Inspection - Inspector has started the survey process
- **ROS-2C-MLCE**: Report of Survey - 2C - MLCE (Specific type of marine survey report)
- **CMCD**: Completed Marine Cargo Discharge - Survey completion at cargo discharge point
- **DMC**: Demobilization Complete - Inspector has completed and left the survey location

### Reference Numbers
- **MLCE Indent Reference**: Auto-generated as `MLCE-INDENT-FY{year}-{date}-{count}`
- **Recommendation Reference**: Auto-generated as `{LOCATION}-REC-{count}`

---

## User Roles and Permissions

### System Administration Roles

#### 1. ILGIC MLCE Admin
**Primary Role**: System Super Administrator
- **Permissions**: Full system access and control
- **Responsibilities**:
  - Create and manage all system users
  - Create and manage client accounts
  - Create MLCE indents for surveys
  - Assign inspectors to locations
  - Final approval of survey reports
  - System configuration and maintenance

#### 2. Marine EXT Team
**Primary Role**: External Field Inspectors
- **Permissions**: Mobile app access, survey execution, report submission
- **Responsibilities**:
  - Conduct field inspections and surveys
  - Take observations and photos
  - Create preliminary recommendations
  - Submit survey reports
  - Track location and survey progress

#### 3. Marine MLCE Team
**Primary Role**: Internal Review Team
- **Permissions**: Review and edit survey reports, submit final reports
- **Responsibilities**:
  - Review inspector submissions
  - Edit and refine survey reports
  - Verify recommendations
  - Submit reports for admin approval

### Business Roles

#### 4. RM (Relationship Manager)
**Primary Role**: Client Relationship Management
- **Permissions**: View client data, access assigned surveys
- **Responsibilities**:
  - Manage client relationships
  - Monitor survey progress for assigned clients
  - Coordinate with clients on survey scheduling

#### 5. Vertical RM (Vertical Relationship Manager)
**Primary Role**: Vertical-specific Client Management
- **Permissions**: View vertical-specific data and reports
- **Responsibilities**:
  - Manage relationships within specific industry verticals
  - Monitor vertical-specific survey activities

#### 6. Channel Partner
**Primary Role**: External Partner Management
- **Permissions**: Limited access to partner-related data
- **Responsibilities**:
  - Coordinate survey activities through partner channels
  - Facilitate client communications

#### 7. U/W (Underwriter)
**Primary Role**: Risk Assessment and Policy Management
- **Permissions**: View risk assessments, survey results, recommendations
- **Responsibilities**:
  - Assess risk profiles based on survey results
  - Make underwriting decisions
  - Review and approve risk mitigation measures

### Client Roles

#### 8. Insured Admin
**Primary Role**: Client Administrator
- **Permissions**: Full access to client-specific data and surveys
- **Responsibilities**:
  - Manage client-side survey coordination
  - Review and respond to recommendations
  - Oversee implementation of risk mitigation measures
  - Manage client user accounts

#### 9. Insured Representative
**Primary Role**: Client Representative/Monitor
- **Permissions**: View-only access to client surveys and recommendations
- **Responsibilities**:
  - Monitor survey progress
  - Review recommendations and implementation status
  - Coordinate with internal teams on risk mitigation

#### 10. Guest
**Primary Role**: Limited Access User
- **Permissions**: Minimal read-only access
- **Responsibilities**:
  - View basic information as permitted
  - Limited system interaction

---

## System Workflow

### Overall Process Flow

```
1. Admin Creates Indent → 2. Inspector Assignment → 3. Survey Execution → 
4. Recommendations → 5. Report Review → 6. Final Approval → 7. Client Action
```

### Detailed Workflow

#### Phase 1: Survey Initiation
1. **ILGIC MLCE Admin** creates a new MLCE indent
2. Admin selects client and insured representative
3. Admin defines survey scope and locations
4. Admin assigns inspectors to specific locations
5. System generates unique reference numbers

#### Phase 2: Survey Execution
1. **Marine EXT Team** (Inspector) receives assignment
2. Inspector mobilizes to survey location
3. Inspector conducts on-site survey
4. Inspector records observations and takes photos
5. Inspector creates preliminary recommendations
6. Inspector demobilizes and submits report

#### Phase 3: Report Processing
1. **Marine MLCE Team** reviews inspector's submission
2. Team refines and edits the report
3. Team verifies recommendations and observations
4. Team submits final report for approval

#### Phase 4: Approval and Publication
1. **ILGIC MLCE Admin** reviews final report
2. Admin approves or requests revisions
3. Approved report is published to client
4. Client receives access to recommendations

#### Phase 5: Implementation
1. **Client** (Insured Admin/Representative) reviews recommendations
2. Client implements risk mitigation measures
3. Client marks recommendations as completed
4. System tracks implementation progress
5. Indent status changes to "Completed" when all recommendations are implemented

---

## Status Definitions

### MLCE Indent Status
- **Created**: Initial indent created, pending assignments
- **In Progress**: Survey work has begun
- **In Review**: Internal review of survey results
- **In Client Review**: Client reviewing recommendations
- **Completed**: All recommendations implemented by client

### Assignment Status
- **Assigned**: Inspector assigned to location
- **Mobilised**: Inspector traveling to survey location
- **Survey Started**: Active survey in progress
- **Survey Completed**: Survey work finished
- **Demobilised**: Inspector has left survey location
- **Recommendations Submitted**: Final recommendations submitted

### Recommendation Status
- **Pending**: Recommendation awaiting client implementation
- **Completed**: Recommendation successfully implemented by client

---

## Content Management System

IL Marine VAS includes a comprehensive content management system for training materials, documentation, and educational resources. This system provides secure access control, view tracking, and automated notifications.

### Content Types

#### 1. Videos
**Purpose**: Training videos, educational content, and instructional materials
- **File Formats**: MP4, AVI, MOV, and other video formats
- **Features**:
  - Upload and manage training videos
  - Access control based on user roles
  - View count tracking per video
  - User-specific view statistics
  - Automatic email notifications to assigned users
  - Download and streaming capabilities

#### 2. Presentations
**Purpose**: Training presentations, slide decks, and educational materials
- **File Formats**: PPT, PPTX, PDF presentation files
- **Features**:
  - Upload and manage presentation files
  - Role-based access permissions
  - View tracking and analytics
  - User notification via email
  - Version control and updates
  - Download access for authorized users

#### 3. SOPs (Standard Operating Procedures)
**Purpose**: Procedural documentation, guidelines, and operational manuals
- **File Formats**: PDF documents
- **Features**:
  - Customer-specific SOP management
  - Date-based validity periods (start date to end date)
  - Access control per customer and user group
  - View tracking and compliance monitoring
  - Document versioning and updates
  - Expiration alerts and reminders

#### 4. MLCE Reports
**Purpose**: Survey reports, recommendations, and assessment documents
- **Features**:
  - Comprehensive view tracking system
  - Page-wise analytics (track which sections are viewed)
  - IP address and device information logging
  - User engagement analytics
  - Report completion tracking
  - Access control based on survey permissions

### Content Management Workflows

#### For Content Administrators
1. **Upload Content**:
   - Select content type (Video/Presentation/SOP)
   - Upload file and add metadata (title, description)
   - Assign access permissions to specific users
   - System sends automatic email notifications

2. **Manage Access**:
   - Update user permissions for existing content
   - Add or remove users from allowed lists
   - Monitor content usage and engagement

3. **Analytics Review**:
   - Review view statistics and user engagement
   - Identify compliance gaps
   - Generate usage reports

#### For Content Consumers
1. **Access Content**:
   - Login to portal or mobile app
   - View assigned content in dashboard
   - Click to view/download content
   - System automatically tracks view

2. **Engagement Tracking**:
   - All views are automatically recorded
   - Progress tracked for compliance requirements
   - Receive notifications for new content

---

## Step-by-Step User Guide

### For ILGIC MLCE Admin

#### Creating a New Survey Indent
1. **Login** to the web portal with admin credentials
2. **Navigate** to "MLCE Indents" section
3. **Click** "Create New Indent"
4. **Fill** in the following details:
   - Select client from dropdown
   - Choose MLCE type (Value Addition, Risk Mitigation, etc.)
   - Select insured representative
   - Assign RM, Vertical RM, and Underwriter
   - Enter policy details (Policy No, Type, Start/End dates)
   - Define job scope and survey requirements
5. **Add Locations**: 
   - Click "Add Location"
   - Enter location details (name, address, contact info)
   - Repeat for multiple locations
   - Set survey timeline and priorities
6. **Review** all information
7. **Save** the indent (system auto-generates reference number)
8. **Assign Inspectors**:
   - For each location, select inspector and supervisor and assign.
   

#### Managing Assignments
1. **Access** "Assignments" dashboard
2. **View** assignment status and progress
3. **Monitor** inspector activities and location tracking
4. **Review** submitted reports and recommendations
5. **Approve** or request revisions as needed

#### Content Management (Admin)
1. **Upload Training Videos**:
   - Navigate to "Videos" section
   - Click "Upload New Video"
   - Select video file and add title/description
   - Assign access to specific users or roles
   - Save to send automatic email notifications

2. **Manage Presentations**:
   - Go to "Presentations" section
   - Upload presentation files (PPT, PDF)
   - Set access permissions for users
   - Track view statistics and engagement

3. **SOP Management**:
   - Access "SOPs" section
   - Upload customer-specific procedural documents
   - Set validity periods (start and end dates)
   - Assign to relevant customer users
   - Monitor compliance and view tracking

4. **View Analytics**:
   - Review content usage statistics
   - Monitor user engagement and compliance
   - Generate reports on training completion
   - Track document access and downloads

### For Marine EXT Team (Inspectors)

#### Mobile App Survey Process
1. **Download** and install the mobile app
2. **Login** with inspector credentials
3. **View** assigned surveys on dashboard
4. **Select** survey to begin

#### Survey Execution Steps
1. **Mobilise**: 
   - Click "Mobilise" when leaving for survey location
   - System tracks your departure time
2. **Travel** to survey location
3. **Start Survey**:
   - Click "Start Survey" upon arrival
   - System records start time and location
4. **Conduct Survey**:
   - Take detailed observations
   - Capture photos of hazards and conditions
   - Record measurements and assessments
   - Note any immediate concerns
5. **Create Recommendations**:
   - Add preliminary recommendations
   - Set priority levels (High, Medium, Low)
   - Estimate capital involvement required
   - Set suggested timelines (7, 30, 45, 90 days)
6. **Complete Survey**:
   - Review all observations and photos
   - Click "Complete Survey" when finished
7. **Demobilise**:
   - Click "Demobilise" when leaving location
   - System records departure time

#### Report Submission (Web Portal)
1. **Login** to web portal
2. **Access** "My Assignments" section
3. **Select** completed survey
4. **Review** and edit observations
5. **Refine** recommendations with detailed descriptions
6. **Upload** additional photos if needed
7. **Format** report for clarity and professionalism
8. **Submit** final report for review

### For Marine MLCE Team

#### Report Review Process
1. **Access** "Reports for Review" section
2. **Select** inspector's submitted report
3. **Review** all observations and recommendations
4. **Verify** technical accuracy and completeness
5. **Edit** content for clarity and professional presentation
6. **Ensure** all hazards are properly documented
7. **Validate** recommendation priorities and timelines
8. **Submit** refined report for admin approval

### For Client Users (Insured Admin/Representative)

#### Accessing Survey Results
1. **Login** to client portal
2. **Navigate** to "My Surveys" or "MLCE Indents"
3. **Select** approved survey from list
4. **Review** survey details and findings

#### Managing Recommendations
1. **Access** "Recommendations" section
2. **View** all recommendations with details:
   - Hazard description
   - Current observation
   - Recommended action
   - Priority level
   - Suggested timeline
   - Capital involvement required
3. **Plan** implementation activities
4. **Implement** risk mitigation measures
5. **Document** completion with photos/evidence
6. **Mark** recommendations as "Completed"
7. **Monitor** overall implementation progress

#### Accessing Content and Training Materials
1. **View Assigned Content**:
   - View videos, presentations, and SOPs assigned to you
   - Click to view/download content (automatically tracked)

2. **SOP Compliance**:
   - Review customer-specific Standard Operating Procedures
   - Ensure compliance with current versions
   - Monitor expiration dates for document updates

3. **Report Access**:
   - Access detailed survey reports with page-wise navigation
   - View recommendations and implementation guidelines
   - Track your engagement with report content

---

## Mobile App Features

### Core Functionality
- **GPS Tracking**: Automatic location tracking during surveys
- **Photo Capture**: High-quality image capture with metadata
- **Sync**: Data synchronization when internet is available

### Inspector Tools
- **Survey Checklist**: Predefined checklists for different survey types
- **Templates**: Standard formats for common data
- **Photo Management**: Organize and annotate photos
- **Recommendation Builder**: Step-by-step recommendation creation
- **Progress Tracking**: Real-time status updates

### Reporting Features
- **Preliminary Reports**: Generate basic reports on mobile
- **Data Export**: Export survey data for further processing
- **Status Updates**: Real-time status communication

---

## Reports and Analytics

### Available Reports

#### For Management
- **Survey Performance Dashboard**: Overview of survey activities and completion rates
- **Inspector Performance**: Individual inspector productivity and quality metrics
- **Client Risk Profile**: Aggregate risk assessment across client locations
- **Recommendation Implementation**: Tracking of client risk mitigation efforts

#### For Clients
- **Survey Summary Report**: Comprehensive overview of survey findings
- **Recommendation Status Report**: Current status of all recommendations
- **Risk Trend Analysis**: Historical risk assessment trends
- **Implementation Progress**: Timeline and status of risk mitigation activities

### Content Analytics and Reporting

#### Training and Compliance Reports
- **Content Usage Analytics**: Track video and presentation views by user
- **Training Completion Reports**: Monitor completion of assigned training materials
- **SOP Compliance Tracking**: Ensure users have accessed current procedural documents
- **User Engagement Metrics**: Identify most and least engaged users

#### Advanced Report Analytics
- **Page-wise Report Views**: Track which sections of reports are most viewed
- **User Journey Analysis**: Understand how users navigate through content
- **Device and Location Tracking**: Monitor access patterns for security
- **Engagement Heatmaps**: Visual representation of content engagement

#### Content Performance Metrics
- **Most Viewed Content**: Identify popular training materials
- **Content Effectiveness**: Measure impact of training on survey quality
- **Access Patterns**: Understand peak usage times and patterns
- **Compliance Gaps**: Identify users who haven't accessed required content

---

## Support and Training

### Getting Started
1. **User Account Setup**: Contact admin for account creation
2. **Initial Training**: Attend role-specific training sessions
3. **Mobile App Installation**: Download and configure mobile app
4. **System Access**: Verify web portal and mobile app access

### Technical Support
- **Help Desk**: Available during business hours
- **User Manual**: Comprehensive documentation available
- **FAQ Section**: Common questions and solutions

### Best Practices
- **Regular Updates**: Keep mobile app updated
- **Data Backup**: Ensure survey data is properly synced
- **Quality Control**: Review all submissions before final submission
- **Communication**: Maintain clear communication with all stakeholders

---

*This documentation is maintained by the IL Marine VAS development team. For updates or clarifications, contact the system administrator.*
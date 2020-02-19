## Client will see:

**Dashboard:**
* Located in *component-dashboard.php* > *part-dashboard_client.php*
* Contain sessions and pending approvals

- **Delegates:**
    Located in *component-delegates.php*
- **Agenda:**
    Located in *component-agenda.php*
    Get agendas of the delegates of this client (*query-get_agendas_admin.php*)
- **Feedback:**
    Located in component-feedback
    Get feedback of the delegates of this client (*query-get_feedbacks_admin.php*)
- **Videos:** 
    Located in component-videos
    Get videos of the delegates of this client (*query-get_videos_admin.php*)
- **Approvals:** 
    Located in component-approvals. 
    It contains: *part-agenda_item_approval.php* and *part-feedback_item_approval.php*
- **Faculty:**
    Located in *component-team.php*
- **Contact**
    Located in *component-contact.php*

## Delegate will see:

- **Dashboard:**
    Located in *component-dashboard* > *part-dashboard_client.php*
    Contain sessions and pending approvals
- **Agenda:**
    Located in component-agenda
    Get agendas of this delegate (query-get_agendas.php)
- **Feedback:** 
    Located in component-feedback
    Get feedback of this delegate (query-get_feedbacks.php)
- **Videos:** 
    Located in component-videos
    Get videos of the delegate (query-get_videos.php)
- **Documents:**
    Located in component-documents. 
    Get documents of this delegate (query-get_documents.php)
- **Faculty:**
    Located in component-team.
- **Contact**
    Located in component-contact

## Single feedback
- Session field  matches the feedback post with its session.
- Fields: Overview, what went well, what needs work, conclusions and an extra field for more information 
- Located in part-feedback_info

### Approve feedback:
- When the feedback post is created the status is Pending.
- If we don't want the client to approve feedback we can turn this off in WorPress.
- If the user role is Client show the ability to approve feedback
- The approve event is in mains.js

- Approve button opens up a confirmation box #approveAlert. (located in modal-approve.php)
- Confirm approve button triggers updateStatus() that changes the status from Pending to Approved

- Request changes open a modal with the form #requestForm (located in modal-request.changes.php)
- Request form button triggers updateStatus() that changes the status from Pending to Awaiting Feedback and sends an email.

- Update_status is an AJAX function in functions.php
- It updates the field "feedback_status"
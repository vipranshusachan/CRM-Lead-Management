# REST API Specifications - Lead Management CRM

Base URL: `http://localhost/PROJECT%20A/public/api` (or `http://localhost:8000/api`)

All requests and responses use `Content-Type: application/json`.

---

## 1. Authenticate / Login
**`POST /api/login`**

### Request Body
```json
{
  "email": "admin@crm.com",
  "password": "password"
}
```

### Response (200 OK)
```json
{
  "success": true,
  "message": "Login successful",
  "user": {
    "id": 1,
    "name": "Admin User",
    "email": "admin@crm.com",
    "role": "ADMIN"
  }
}
```

---

## 2. List Leads (With Filtering & Pagination)
**`GET /api/leads`**

### Query Parameters
- `page` (int, default: 1)
- `limit` (int, default: 10)
- `search` (string, optional)
- `status` (string, optional - e.g., `New`, `Contacted`, `Qualified`, `Won`, `Lost`)
- `assigned_to` (int, optional)
- `date` (string `YYYY-MM-DD`, optional)

### Response (200 OK)
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Acme Corp Deal",
      "email": "john@acme.com",
      "phone": "+1 555-0192",
      "company": "Acme Corporation",
      "source": "Website",
      "status": "New",
      "assigned_to": 2,
      "assigned_to_name": "Sarah Jenkins",
      "created_by": 1,
      "created_at": "2026-07-24 12:00:00"
    }
  ],
  "total": 1,
  "page": 1,
  "limit": 10,
  "last_page": 1
}
```

---

## 3. Get Single Lead
**`GET /api/leads/{id}`**

### Response (200 OK)
```json
{
  "success": true,
  "lead": {
    "id": 1,
    "name": "Acme Corp Deal",
    "email": "john@acme.com",
    "phone": "+1 555-0192",
    "company": "Acme Corporation",
    "source": "Website",
    "status": "New",
    "assigned_to": 2,
    "assigned_to_name": "Sarah Jenkins"
  },
  "notes": [],
  "activities": []
}
```

---

## 4. Create Lead (Admin Only)
**`POST /api/leads`**

### Request Body
```json
{
  "name": "Nexus Systems",
  "email": "info@nexus.com",
  "phone": "+1 555-4422",
  "company": "Nexus Systems LLC",
  "source": "LinkedIn",
  "status": "New",
  "assigned_to": 2
}
```

### Response (201 Created)
```json
{
  "success": true,
  "message": "Lead created",
  "lead": {
    "id": 8,
    "name": "Nexus Systems",
    "email": "info@nexus.com",
    "status": "New"
  }
}
```

---

## 5. Update Lead Details
**`PUT /api/leads/{id}`**

### Request Body
```json
{
  "name": "Nexus Systems Inc",
  "email": "contact@nexus.com",
  "phone": "+1 555-4422",
  "company": "Nexus Enterprise Inc"
}
```

---

## 6. Update Status
**`POST /api/leads/{id}/status`**

### Request Body
```json
{
  "status": "Contacted"
}
```

---

## 7. Assign Lead (Admin Only)
**`POST /api/leads/{id}/assign`**

### Request Body
```json
{
  "assigned_to": 3
}
```

---

## 8. Add Note
**`POST /api/leads/{id}/notes`**

### Request Body
```json
{
  "note": "Client requested follow-up presentation on Friday."
}
```

---

## 9. Get Lead Activity Audit Trail
**`GET /api/leads/{id}/activities`**

### Response (200 OK)
```json
{
  "success": true,
  "activities": [
    {
      "id": 1,
      "lead_id": 1,
      "user_id": 1,
      "action": "Status Changed",
      "metadata": {
        "from": "New",
        "to": "Contacted"
      },
      "created_at": "2026-07-24 12:30:00"
    }
  ]
}
```

---

## 10. Delete Lead (Admin Only)
**`DELETE /api/leads/{id}`**

### Response (200 OK)
```json
{
  "success": true,
  "message": "Lead 'Nexus Systems Inc' deleted successfully"
}
```

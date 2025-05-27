@component('mail::message')
# 📬 Nuevo mensaje desde el formulario de contacto

Has recibido un nuevo mensaje a través del formulario de contacto de la web:

---

**👤 Nombre:** {{ $data['name'] }}

**📧 Correo electrónico:** {{ $data['email'] }}

**💬 Mensaje:**

> {{ $data['message'] }}

---

Gracias por revisar este mensaje.

@endcomponent

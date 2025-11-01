{{-- resources/views/emails/contact-form.blade.php --}}
<x-mail::message>
# Nuevo Mensaje de Contacto

Has recibido un nuevo mensaje desde la landing page de **MenuQR Pro**.

**De:** {{ $name }}
**Email:** [{{ $email }}](mailto:{{ $email }})

---

**Mensaje:**

{{ $messageBody }}
</x-mail::message>

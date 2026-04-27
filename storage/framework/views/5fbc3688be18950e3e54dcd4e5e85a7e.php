<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>New contact message</title>
  </head>
  <body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; line-height: 1.5; color: #111827;">
    <h2 style="margin:0 0 12px 0;">New contact message (#<?php echo e($m->id); ?>)</h2>

    <p style="margin:0 0 12px 0;">
      From: <strong><?php echo e($m->full_name); ?></strong>
      <?php if($m->company): ?> (<?php echo e($m->company); ?>) <?php endif; ?>
    </p>

    <ul style="margin:0 0 16px 18px; padding:0;">
      <li><strong>Email:</strong> <?php echo e($m->email); ?></li>
      <?php if($m->phone): ?><li><strong>Phone:</strong> <?php echo e($m->phone); ?></li><?php endif; ?>
      <?php if($m->country): ?><li><strong>Country:</strong> <?php echo e($m->country); ?></li><?php endif; ?>
      <?php if($m->service_interest): ?><li><strong>Service interest:</strong> <?php echo e($m->service_interest); ?></li><?php endif; ?>
    </ul>

    <h3 style="margin:0 0 8px 0;">Message</h3>
    <div style="white-space: pre-wrap; background:#f3f4f6; padding:12px; border-radius:10px;">
      <?php echo e($m->message); ?>

    </div>

    <p style="margin:16px 0 0 0; color:#6b7280; font-size: 12px;">
      Replying to this email will send a response to <?php echo e($m->email); ?>.
    </p>
  </body>
</html>

<?php /**PATH /home/u337070232/domains/jcarchitectureaiconsulting.com/public_html/backend/resources/views/emails/contact-admin.blade.php ENDPATH**/ ?>
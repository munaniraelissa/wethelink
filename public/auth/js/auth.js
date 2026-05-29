// Lightweight JS for auth pages
document.addEventListener('DOMContentLoaded', function () {
  // Prevent default on social placeholder buttons (they should be wired to OAuth later)
  document.querySelectorAll('.btn-social').forEach(function(btn){
    btn.addEventListener('click', function(e){
      e.preventDefault();
      // simple feedback
      btn.classList.add('disabled');
      setTimeout(function(){ btn.classList.remove('disabled'); }, 700);
    });
  });

  // Simple show/hide password toggle if buttons exist
  document.querySelectorAll('[data-toggle="password"]').forEach(function(toggle){
    var target = document.querySelector(toggle.getAttribute('data-target'));
    if(!target) return;
    toggle.addEventListener('click', function(e){
      e.preventDefault();
      if(target.type === 'password') target.type = 'text'; else target.type = 'password';
      toggle.classList.toggle('active');
    });
  });
});

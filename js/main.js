function showOnlySection(sectionId) {
  const sections = document.querySelectorAll('.site-section');
  sections.forEach(section => {
    section.style.display = 'none';
  });
  document.getElementById(sectionId).style.display = 'block';
} 
 function showProfile(id) {
    const profiles = document.querySelectorAll('.team-profile');
    profiles.forEach(profile => profile.classList.add('d-none'));
    document.getElementById(id).classList.remove('d-none');
  }
document.addEventListener("DOMContentLoaded", function () {
  AOS.init({
    duration: 1000,
    once: true
  });
});

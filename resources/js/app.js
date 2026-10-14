import './pages/register.js';
import './pages/student/index.js'
import './pages/student/vacancy-detail.js'
import './pages/student/company-profile.js'
import './pages/student/profile.js'
import './pages/company/profile'
import './pages/company/change-membership'
import './pages/company/applications'
import './pages/company/applicant-profile'
import './pages/company/ratings'
import './pages/company/vacancy-create'
import './pages/company/vacancy-detail'
import './pages/company/vacancy-edit'

document.addEventListener('DOMContentLoaded', () => {

    const elements = document.querySelectorAll('.reveal-on-scroll');

    if (elements.length === 0) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {

            entries.forEach((entry) => {

                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');

                    observer.unobserve(entry.target);
                }

            });

        },
        {
            threshold: 0.15
        }
    );

    elements.forEach((element) => {
        observer.observe(element);
    });

});

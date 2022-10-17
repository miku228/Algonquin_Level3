using AcademicManagement;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using System.Reflection;


namespace Lab2.Pages
{
    public class RegistrationModel : PageModel
    {

        /* SELECT STUDENT */
        /******************************/

        public Boolean sSlectedFlag { get; private set; } = false;
        public Boolean cSlectedFlag { get; private set; } = false;
        public int firstLoad { get; set; } = 0;

        [BindProperty]
        public List<Student> students { get; set; } = new List<Student>();

        // public List<SelectListItem> courses { get; set; } = new List<SelectListItem>();

        public List<AcademicRecord> academicRecords { get; set; } = new List<AcademicRecord>();

        [BindProperty]
        public string selectedStudentId { get; set; } = "";


        /* REGISTERED/REGISTER COURSE */
        /******************************/

        [BindProperty]
        public List<SelectListItem> CourseSelections { get; set; }

        [BindProperty]
        public List<Course> SelectedCourses { get; set; }

        // public string Message { get; set; } = "Initial Request";


        public void OnGet()
        {
        }


        public void OnPostStudentSelected()
        {
            firstLoad += 1;
            // Message = "Select Student Form Posted";
            if (selectedStudentId != "-1")
            {
                sSlectedFlag = true;
                academicRecords = DataAccess.GetAcademicRecordsByStudentId(selectedStudentId);

                // there is a academicRecords
                if (academicRecords.Count() > 0)
                {
                    cSlectedFlag = true;
                    sSlectedFlag = true;

                    SelectedCourses = new List<Course>();
                    foreach (AcademicRecord ar in academicRecords)
                    {
                        SelectedCourses.Add(DataAccess.GetAllCourses().First(c => c.CourseCode == ar.CourseCode));
                    }

                }
            }


        }

        public void OnPostRegister()
        {

            // Message = "Register Course Posted";
            sSlectedFlag = true;
            foreach (SelectListItem item in CourseSelections)
            {
                if (item.Selected)
                {
                    cSlectedFlag = true;
                    // set selected to SelectedCoures List
                    SelectedCourses.Add(DataAccess.GetAllCourses().First(c => c.CourseCode == item.Value));
                    // add to academic 
                    DataAccess.AddAcademicRecord(new AcademicRecord(selectedStudentId, item.Value));

                }
            }

        }


    }
}

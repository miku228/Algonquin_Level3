using AcademicManagement;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.AspNetCore.Mvc.Rendering;
using System.Diagnostics;

namespace Lab3.Pages
{
    public class RegistrationModel : PageModel
    {

        /* SELECT STUDENT */
        /******************************/

        public Boolean sSlectedFlag { get; private set; } = false;
        public Boolean cSlectedFlag { get; private set; } = false;
        public int firstLoad { get; set; } = 0;
        // public int selectedCourseAmount { get; set; };

        [BindProperty]
        public List<Student> students { get; set; } = new List<Student>();

        public List<AcademicRecord> academicRecords { get; set; } = new List<AcademicRecord>();

        [BindProperty]
        public string selectedStudentId { get; set; }

        public string Message { get; set; }


        /* REGISTERED/REGISTER COURSE */
        /******************************/

        [BindProperty]
        public List<SelectListItem> CourseSelections { get; set; }

        [BindProperty]
        public List<Course> SelectedCourses { get; set; }

        /* SORTING REGISTERED COURSE */
        /*****************************/
        public string OrderBy { get; set; }


        public void OnGet(string orderby)
        {
            SetOrderBy(orderby);

            // show selected student's registered courses
            if (HttpContext.Session.GetString("selectedStudentId") != null)
            {
                selectedStudentId = HttpContext.Session.GetString("selectedStudentId");
            }
            if (selectedStudentId != "-1" && selectedStudentId != null)
            {
                getRegisterdCourses();

            }


        }

        /*****************************/
        /*****  Common Functions *****/

        /* set orderby data to session */
        public void SetOrderBy(string orderby)
        {
            // set OrderBy depends on Session orderby value
            if (orderby != null)
            {
                HttpContext.Session.SetString("orderby", orderby);
                OrderBy = orderby;
            }
            else if (HttpContext.Session.GetString("orderby") != null)
            {
                OrderBy = HttpContext.Session.GetString("orderby");
            }
            else
            {
                OrderBy = null;
            }

        }

        // get selected student's registered courses
        public void getRegisterdCourses()
        {
            academicRecords = DataAccess.GetAcademicRecordsByStudentId(selectedStudentId);
            // there is a academicRecords
            if (academicRecords.Count() > 0)
            {

                SelectedCourses = new List<Course>();
                foreach (AcademicRecord ar in academicRecords)
                {
                    SelectedCourses.Add(DataAccess.GetAllCourses().First(c => c.CourseCode == ar.CourseCode));
                }

            }
        }



        /************************************/
        /*****  ON Post Event Functions *****/

        public void OnPostStudentSelected()
        {
            // firstLoad += 1;
            // Message = "Select Student Form Posted";
            if (selectedStudentId != "-1")
            {
                sSlectedFlag = true;
                HttpContext.Session.SetString("selectedStudentId", selectedStudentId);
                if (HttpContext.Session.GetString("orderby") != null)
                {
                    OrderBy = HttpContext.Session.GetString("orderby");
                }

                getRegisterdCourses();

                if (academicRecords.Count() > 0)
                {
                    cSlectedFlag = true;
                    sSlectedFlag = true;

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

                    // set selected courses to SelectedCoures List
                    SelectedCourses.Add(DataAccess.GetAllCourses().First(c => c.CourseCode == item.Value));
                    // add to academic
                    DataAccess.AddAcademicRecord(new AcademicRecord(selectedStudentId, item.Value));

                    academicRecords = DataAccess.GetAcademicRecordsByStudentId(selectedStudentId);

                }
            }




        }

        public void OnPostRegisterGrade()
        {
            // Message = "Register Grade is Clicked";
            getRegisterdCourses();

            // set academic grades
            foreach (AcademicRecord r in academicRecords)
            {
                for (int i = 0; i < Request.Form["courseCode"].Count(); i++)
                {
                    if (Request.Form["courseCode"][i] == r.CourseCode)
                    {
                        r.Grade = Convert.ToDouble(Request.Form["grade"][i]);
                    }

                }
            }

        }

    }
}

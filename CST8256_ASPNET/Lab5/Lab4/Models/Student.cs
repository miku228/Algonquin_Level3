
namespace Lab5.DataAccess
{
    public partial class Student
    {
        public double? AvgGrade {
            get {
                double? avgGrade = null;
                double? sum = 0.0;

                foreach(AcademicRecord ac in AcademicRecords)
                {
                    if(ac.Grade.HasValue) sum += ac.Grade.Value;
                }

                if (NumberOfCourses > 0) avgGrade = sum / NumberOfCourses;
                return avgGrade;
            } 
        }

        public int NumberOfCourses {
            get {
                int numberOfCourse = 0;
                foreach (AcademicRecord ac in AcademicRecords)
                {
                    if (ac.Grade.HasValue) numberOfCourse++;
                }
                return numberOfCourse;
            } 
        }

        public string DisplayText { get { return Id + " - " + Name; } }
    }
}

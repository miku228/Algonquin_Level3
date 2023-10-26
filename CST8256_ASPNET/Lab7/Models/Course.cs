namespace Lab7.Models.DataAccess
{
    public partial class Course
    {
        public string DisplayText { get { return Code + " - " + Title; } }
    }
}

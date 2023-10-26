namespace Lab5.DataAccess
{
    public partial class Course
    {
        public string DisplayText { get { return Code + " - " + Title; } }
    }
}

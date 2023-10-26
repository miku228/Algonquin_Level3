namespace Lab7.Models.DataAccess
{
    public partial class Student
    {
        public string DisplayText { get { return Id + " - " + Name; } }
    }
}

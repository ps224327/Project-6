using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Navigation;
using System.Windows.Shapes;

namespace kasssa
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {

        private string _currentString = "";
        private decimal _totalPrice = 0;
        public MainWindow()
        {
            InitializeComponent();
            CurrentStringTextBlock.DataContext = this;
        }
        public string CurrentString
        {
            get { return _currentString; }
            set { _currentString = value; }
        }
        private void Btn_Numbers(object sender, RoutedEventArgs e)
        {
            Button button = (Button)sender;
            string digit = button.Content.ToString();
            _currentString += digit;
            CurrentStringTextBlock.GetBindingExpression(TextBlock.TextProperty)?.UpdateTarget(); // Update the binding
        }

        private void Add_price(object sender, RoutedEventArgs e)
        {

            MessageBox.Show(_currentString);
        }
    }
}

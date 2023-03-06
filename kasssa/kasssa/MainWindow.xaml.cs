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
        private string s;

        
        public MainWindow()
        {
            InitializeComponent();
            CurrentStringTextBlock.DataContext = this;

            this.KeyDown += Add_Num_key;
        }
        public string CurrentString
        {
            get { return _currentString; }
            set { _currentString = value; }
        }

        public void UpdateTextBlock()
        {
            CurrentStringTextBlock.GetBindingExpression(TextBlock.TextProperty)?.UpdateTarget();
        }
        private void Add_Num_key(object sender, KeyEventArgs e)
        {
            if (e.Key >= Key.D0 && e.Key <= Key.D9)
            {
                _currentString += e.Key.ToString().Substring(1); // append the digit to the string
                UpdateTextBlock();
            }
            else if (e.Key == Key.Back && _currentString.Length > 0)
            {
                _currentString = _currentString.Substring(0, _currentString.Length - 1); // remove the last digit from the string
                UpdateTextBlock();
            }
            else if (e.Key == Key.Enter && _currentString.Length > 0)
            {
                Add_price();
            }
           
        }
        
        private void Btn_Numbers(object sender, RoutedEventArgs e)
        {
            //checks the 'content' of each button and adds it to an string
            Button button = (Button)sender;
            string digit = button.Content.ToString();
            _currentString += digit;
            UpdateTextBlock();
        }

        private void Btn_Remove_Digit(object sender, RoutedEventArgs e)
        {
            _currentString = _currentString.Remove(_currentString.Length - 1);
            UpdateTextBlock();
        }

       

        public void Add_price(object sender, RoutedEventArgs e)
        {
            StackPanel sp = new StackPanel()
            {
                Background = Brushes.AliceBlue,
                Orientation = Orientation.Horizontal,
            };
            if (_currentString == "")
            {
                MessageBox.Show("undefined value");
            }
            else
            {
                // transfers string into decimal
                decimal d = decimal.Parse(_currentString);
                string s = d.ToString("0.00");
                TextBlock Pricing;
                TextBlock Valuta;

                Valuta = new TextBlock()
                {
                    Foreground = Brushes.Black,
                    Text = "€",
                };

                Pricing = new TextBlock()
                {
                    Foreground = Brushes.Black,
                    Text = " " + s.ToString(),
                    HorizontalAlignment = HorizontalAlignment.Left,
                    Name = "SinglePrice",
                };

                sp.Children.Add(Valuta);
                sp.Children.Add(Pricing);
                LbPrices.Items.Add(sp);
                _totalPrice = _totalPrice + d;
                string total = _totalPrice.ToString("0.00");
                TXTTotal.Text = total;
                _currentString = "";
                UpdateTextBlock();
            }

            
        }

        private void LbPrices_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            if(LbPrices.SelectedIndex > -1)
            {
                if ((MessageBox.Show("weet u zeker dat u dit wilt verwijderen?", "", MessageBoxButton.YesNo) == MessageBoxResult.No))
                {

                }
                else
                {
                    StackPanel sp = LbPrices.SelectedItem as StackPanel;
                    decimal prijsRegel = 0;

                    foreach(TextBlock item in sp.Children.OfType<TextBlock>())
                    {
                        if (item.Name == "SinglePrice")
                        {
                            string prijs = item.Text;
                            prijsRegel = decimal.Parse(prijs);
                        }
                    }


                    LbPrices.Items.Remove(LbPrices.SelectedItem);
                    _totalPrice = _totalPrice - prijsRegel;
                    string total = _totalPrice.ToString("0.00");
                    TXTTotal.Text = total;
                }
            }
        }
        private void Btn_Bon(object sender, RoutedEventArgs e)
        {

        }
       

    }
}

using PdfSharp.Drawing;
using System;
using Newtonsoft.Json;
using PdfSharp.Drawing;
using System.IO;
using PdfSharp.Pdf;
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
using static System.Net.Mime.MediaTypeNames;
using AForge.Video.DirectShow;
using AForge.Video;
using System.Drawing;
using Brushes = System.Windows.Media.Brushes;
using ZXing;
using System.Windows.Controls.Primitives;
using System.Drawing.Text;
using System.Net.Http;
using com.itextpdf.text.pdf;

namespace kasssa
{
    /// <summary>
    /// Interaction logic for MainWindow.xaml
    /// </summary>
    public partial class MainWindow : Window
    {

        private string _currentString = "";
        //decimal for total price
        private decimal _totalPrice = 0;

        private decimal _ChangedTotal = 0;
        private string s;
        private int SPItems;

        //stackpanel
        private StackPanel sp;


        public MainWindow()
        {
            InitializeComponent();
            CurrentStringTextBlock.DataContext = this;

            this.KeyDown += Add_Num_key;
        }

        FilterInfoCollection filterInfoCollection;
        VideoCaptureDevice LocalWebCam;
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
            //cope logic for the numbers, adds number to string
            if (e.Key >= Key.D0 && e.Key <= Key.D9)
            {
                _currentString += e.Key.ToString().Substring(1); // append the digit to the string
                UpdateTextBlock();
            }
            //code logic for the backspace key, removes item from string
            else if (e.Key == Key.Back && _currentString.Length > 0)
            {
                _currentString = _currentString.Substring(0, _currentString.Length - 1); // remove the last digit from the string
                UpdateTextBlock();
            }
            //code logic for the enter key, 
            else if (e.Key == Key.Return && _currentString.Length > 0)
            {
               
            }
           
        }
        
        private void Btn_Numbers(object sender, RoutedEventArgs e)
        {
            //checks the 'content' of each button and adds it to an string
            Button button = (Button)sender;
            string digit = button.Content.ToString();
            if (digit == "," && _currentString.Contains(","))
            {
                MessageBox.Show("De prijs heeft al een komma");
            }
            else
            {
                _currentString += digit;
            }
            
            UpdateTextBlock();
        }

        private void Btn_Remove_Digit(object sender, RoutedEventArgs e)
        {
            if (_currentString.Length > 0)
            {
                _currentString = _currentString.Remove(_currentString.Length - 1);
             
                UpdateTextBlock();
            }
           
        }

       

        public void Add_price(object sender, RoutedEventArgs e)
        {
            int i = 0;
            
            string CBSelectedCurrency = ((ComboBoxItem)CBCurrency.SelectedItem).Name.ToString();
             sp = new StackPanel()
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
                TextBlock USDPricing;
                TextBlock CADPricing;
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
                    Name = "SinglePrice"+i,
                };
                USDPricing = new TextBlock()

                {
                    Foreground = Brushes.Black,
                    Text = " " + s.ToString(),
                    HorizontalAlignment = HorizontalAlignment.Left,
                    Name = "USDSinglePrice"+i,
                    Visibility = Visibility.Collapsed,
                };
                CADPricing = new TextBlock()

                {
                    Foreground = Brushes.Black,
                    Text = " " + s.ToString(),
                    HorizontalAlignment = HorizontalAlignment.Left,
                    Name = "CADSinglePrice"+i,
                    Visibility = Visibility.Collapsed,
                };
                sp.Children.Add(Valuta);
                sp.Children.Add(Pricing);
                sp.Children.Add(USDPricing);
                sp.Children.Add(CADPricing);
                LbPrices.Items.Add(sp);
                _totalPrice = _totalPrice + d;
                string total = _totalPrice.ToString("0.00");
            //    TXTTotal.Text = total;
                _currentString = "";
                UpdateTextBlock();
                UpdateCurrency(CBSelectedCurrency);
                SPItems =+ 1;
                i++;
            }
          
            
        }

        private void LbPrices_MouseDoubleClick(object sender, MouseButtonEventArgs e)
        {
            string CBSelectedCurrency = ((ComboBoxItem)CBCurrency.SelectedItem).Name.ToString();
            if (LbPrices.SelectedIndex > -1)
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
                        if (item.Name.StartsWith("SinglePrice"))
                        {
                            string prijs = item.Text;
                            prijsRegel = decimal.Parse(prijs);
                        }
                    }

                  
                    LbPrices.Items.Remove(LbPrices.SelectedItem);
                    _totalPrice = _totalPrice - prijsRegel;
                    string total = _totalPrice.ToString("0.00");
                //    TXTTotal.Text = total;
                    UpdateCurrency(CBSelectedCurrency);
                }
            }
        }

        void Cam_NewFrame(object sender, AForge.Video.NewFrameEventArgs eventArgs)
        {
            Bitmap bitmap = (Bitmap)eventArgs.Frame.Clone();
            BarcodeReader reader = new BarcodeReader();
        }
        private void ScanBarCode(object sender, RoutedEventArgs e)
        {
            scanner scan = new scanner();
            scan.Show();
        }
        private void Btn_Bon(object sender, RoutedEventArgs e)
        {
            if (LbPrices.Items.Count < 1)
            {
                MessageBox.Show("Please add items before printing a PDF");
            }
            else
            {

                PrintListBox(LbPrices, _totalPrice);
            }
           
        }
        private void PrintListBox(ListBox LbPrices, decimal _totalPrice)
        {
            string CurrencySign = "$";
            string CBSelectedCurrency = ((ComboBoxItem)CBCurrency.SelectedItem).Name.ToString();
            switch (CBSelectedCurrency)
            {
                case "EURO":
                    CurrencySign = "€";
                        break;
                case "USD":
                    CurrencySign = "USD $";
                    break;
                case "CAD":
                    CurrencySign = "CAD $";
                    break;
            };
            MessageBox.Show(CBSelectedCurrency);
            //Strings that needs to be added in the pdf
            //text for header of the pdf
            string CompanyName = "Groene Vingers";

            //data for the company to add to the invoice
            string KVKNummer = "KVK: 18057469"; 
            string Invoice = "23041";
            // Create a new PDF document
            PdfDocument document = new PdfDocument();

            // Add a new page to the document
            PdfPage page = document.AddPage();

            // Create a new XGraphics object for the page
            XGraphics gfx = XGraphics.FromPdfPage(page);

            // Set the font for the text
            XFont font = new XFont("Arial", 12);

            // Set the font for the header
            XFont HeaderFont = new XFont("Arial", 22);

            //color of the red line
            XPen lineRed = new XPen(XColors.Red, 5);

            //color of the black line for the data that needs to be paid
            XPen lineBlack = new XPen(XColors.Black, 2);
            //text for total price stirng
            string TotalText = "totaal ";
            string TotalPrice = TotalText + '€' + _totalPrice.ToString("0.00");
            
             if (CBSelectedCurrency == "USD")
            {
                TotalPrice = TotalText + "USD $" + TXTTotal.Text;
            }
            else if (CBSelectedCurrency == "CAD")
            {
                 TotalPrice = TotalText + "CAD $" + TXTTotal.Text;
            }
         
        

            gfx.DrawString(CompanyName, HeaderFont, XBrushes.Black, new XRect(225, 50 ,0 , 20), XStringFormats.TopLeft);
            gfx.DrawString(CompanyName, font, XBrushes.Black, new XRect(500, 50, 0, 0));
            gfx.DrawString(KVKNummer, font, XBrushes.Black, new XRect(500, 70, 0, 0));
            // Loop through the items in the listbox and draw them on the page
            int i = 2;
            foreach (var item in LbPrices.Items)
            {
                // retrieve the StackPanel containing the TextBlocks
                StackPanel stackPanel = item as StackPanel;

                if (stackPanel != null)
                {
                    
                    // loop through each TextBlock in the StackPanel
                    foreach (var child in stackPanel.Children)
                    {
                        
                        TextBlock textBlock = child as TextBlock;

                        if (textBlock.Name.StartsWith("SinglePrice"))
                        {
                            i++;
                            // retrieve the text from the TextBlock
                            
                            string text = CurrencySign + textBlock.Text;
                            gfx.DrawString(text, font, XBrushes.Black, new XRect(50, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);

                            gfx.DrawLine(lineBlack, 50, 50 + i * 25, page.Width - 50, 50 + i * 25);
                        }
                        
                       
                    }
                }
            }

            

            //creates a red line
         
            gfx.DrawLine(lineRed, 0,750, page.Width,750);

            //output of the total price
            gfx.DrawString(TotalPrice, font, XBrushes.Black, new XRect(400,800, 0, 0));
            // Save the PDF document to a file
            string filePath = "listbox.pdf";
            document.Save(filePath);

            // Open the PDF document using the default PDF viewer
            System.Diagnostics.Process.Start(filePath);
        }


      private async void UpdateCurrency( string CBSelectedcurrency)
        {
            int i = 0;
            decimal prijsRegel = 0;
            switch (CBSelectedcurrency)
            {
                case "EURO":
                    TXTTotal.Text = _totalPrice.ToString("0.00");
                    TextTekens.Text = "Totaal prijs €";

                 

                    //for the listbox items
                    foreach (StackPanel number in LbPrices.Items)
                    {
                        foreach (TextBlock item in sp.Children.OfType<TextBlock>())
                        {
                            if (item.Name.StartsWith("SinglePrice"))
                            {
                              
                                item.Visibility = Visibility.Visible;

                            }
                            if (item.Name.StartsWith("USDSinglePrice"))
                            {
                                item.Visibility = Visibility.Hidden;
                            }
                            if (item.Name.StartsWith("CADSinglePrice"))
                            {
                                item.Visibility = Visibility.Hidden;
                            }
                        }
                    }
                    break;
                case "USD":
                    using (HttpClient client = new HttpClient())
                    {
                        try
                        {
                            // for the API to fetch data
                            HttpResponseMessage USDResponse = await client.GetAsync("https://api.freecurrencyapi.com/v1/latest?apikey=meYps5nLQL78E4cz5oNAAz13I6DWWnClVP9OAgCt&currencies=USD&base_currency=EUR");
                            USDResponse.EnsureSuccessStatusCode();

                            string UsdResponse = await USDResponse.Content.ReadAsStringAsync();

                            dynamic jsonResponse = JsonConvert.DeserializeObject(UsdResponse);
                            decimal usdRate = jsonResponse.data.USD;
                            //convert total price to usd price

                            decimal usd = _totalPrice * usdRate;

                      
                            TXTTotal.Text = usd.ToString("0.00");
                            TextTekens.Text = "Totaal prijs USD $";



                            //for the listbox items
                            foreach (StackPanel number in LbPrices.Items)
                            {
                                foreach (TextBlock item in sp.Children.OfType<TextBlock>())
                                {
                                    if (item.Name.StartsWith("SinglePrice"))
                                    {
                                        string prijs = item.Text;
                                        prijsRegel = decimal.Parse(prijs);
                                        item.Visibility = Visibility.Collapsed;

                                    }
                                    if (item.Name.StartsWith("USDSinglePrice"))
                                    {
                                        item.Visibility = Visibility.Visible;
                                        decimal PrijsRegel = prijsRegel * usdRate;
                                        item.Text = PrijsRegel.ToString("0.00");
                                    }
                                    if (item.Name.StartsWith("CADSinglePrice"))
                                    {
                                        item.Visibility = Visibility.Hidden;
                                    }
                                }
                            }
                         
                        }
                        catch (HttpRequestException ex)
                        {
                            MessageBox.Show("error returning USD");
                        }
                    }
                
                    break;

                case "CAD":
                    using (HttpClient client = new HttpClient())
                    {
                        try
                        {
                            HttpResponseMessage CADRespone = await client.GetAsync("https://api.freecurrencyapi.com/v1/latest?apikey=meYps5nLQL78E4cz5oNAAz13I6DWWnClVP9OAgCt&currencies=CAD&base_currency=EUR");
                            CADRespone.EnsureSuccessStatusCode();

                            string CadResponse = await CADRespone.Content.ReadAsStringAsync();

                            dynamic jsonResponse = JsonConvert.DeserializeObject(CadResponse);
                            decimal cadRate = jsonResponse.data.CAD;


                            decimal cad = _totalPrice * cadRate;

                            TXTTotal.Text = cad.ToString("0.00");
                            TextTekens.Text = "Totaal prijs CAD $";


                            foreach (StackPanel number in LbPrices.Items)
                            {
                                foreach (TextBlock item in sp.Children.OfType<TextBlock>())
                                {
                                    if (item.Name.StartsWith("SinglePrice"))
                                    {
                                        string prijs = item.Text;
                                        prijsRegel = decimal.Parse(prijs);
                                        item.Visibility = Visibility.Collapsed;

                                    }
                                    if (item.Name.StartsWith("USDSinglePrice"))
                                    {
                                        item.Visibility = Visibility.Collapsed;

                                    }
                                    if (item.Name.StartsWith("CADSinglePrice"))
                                    {
                                        item.Visibility = Visibility.Visible;
                                        decimal PrijsRegel = prijsRegel * cadRate;
                                        item.Text = PrijsRegel.ToString("0.00");
                                    }
                                }
                            }
                        }
                        catch (HttpRequestException ex)
                        {
                            MessageBox.Show("error returning CAD");
                        }
                    }
                    break;

            }
        }

        private T FindVisualChild<T>(DependencyObject parentElement) where T : DependencyObject
        {
            var count = VisualTreeHelper.GetChildrenCount(parentElement);
            for (int i = 0; i < count; i++)
            {
                var child = VisualTreeHelper.GetChild(parentElement, i);
                if (child is T typedChild)
                {
                    return typedChild;
                }
                else
                {
                    var result = FindVisualChild<T>(child);
                    if (result != null)
                    {
                        return result;
                    }
                }
            }
            return null;
        }
        private async void Currency_Changed(object sender, SelectionChangedEventArgs e)
        {

            string CBSelectedCurrency = ((ComboBoxItem)CBCurrency.SelectedItem).Name.ToString();
            UpdateCurrency(CBSelectedCurrency);
           


        }
    }
}


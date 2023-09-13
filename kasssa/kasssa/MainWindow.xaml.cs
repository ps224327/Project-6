using PdfSharp.Drawing;
using System;
using Newtonsoft.Json;
using PdfSharp.Drawing;
using System.Text.RegularExpressions;
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
using static iTextSharp.text.pdf.AcroFields;
using PdfSharp.Pdf.Content.Objects;
using System.Text.RegularExpressions;
using kasssa.Models;
using iTextSharp.text;
using Org.BouncyCastle.Asn1.X509;

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
        private string Employee_number = "";
        private decimal _ChangedTotal = 0;
        private decimal _MultiScanned = 0;
        private string s;
        private int SPItems;

        //stackpanel
        private StackPanel sp;

        ProjectDB _db = new ProjectDB();
        public MainWindow(int employee_number)
        {
            InitializeComponent();
            CurrentStringTextBlock.DataContext = this;
            Employee_number = employee_number.ToString();
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

        public void After_order()
        {
            TbAmount.Text = "";
            foreach (var item in LbPrices.Items)
            {
                if (LbPrices.SelectedIndex > -1)
                {


                    Grid container = LbPrices.SelectedItem as Grid;
                    decimal prijsRegel = 0;

                    foreach (StackPanel sp in container.Children.OfType<StackPanel>())
                    {
                        foreach (TextBlock item in sp.Children.OfType<TextBlock>())
                        {
                            if (item.Name.StartsWith("AllPrice"))
                            {
                                string prijs = item.Text;
                                prijsRegel = decimal.Parse(prijs);
                            }
                        }
                    }

                    LbPrices.Items.Remove(LbPrices.SelectedItem);
                    _totalPrice -= prijsRegel;
                    string total = _totalPrice.ToString("0.00");
                    TXTTotal.Text = total;

                }
            }
           
        }
        private void Add_Num_key(object sender, KeyEventArgs e)
        {

            //cope logic for the numbers, adds number to string
            if (!TbAmount.IsFocused && e.Key >= Key.D0 && e.Key <= Key.D9)
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
            }
            else if (_currentString.Count(ch => ch == ',') == 1 && _currentString.Length - _currentString.IndexOf(",") > 2)
            {
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
                Grid container = new Grid();
                container.ColumnDefinitions.Add(new ColumnDefinition() { Width = new GridLength(1, GridUnitType.Star) });
                container.ColumnDefinitions.Add(new ColumnDefinition() { Width = GridLength.Auto });

                // transfers string into decimal
                decimal d = decimal.Parse(_currentString);
                string s = d.ToString("0.00");
                TextBlock Pricing;
                TextBlock Valuta;
                Button RemoveSP;
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
                    Name = "AllPrice" + i,
                };
                RemoveSP = new Button()
                {
                    Content = "X",
                    HorizontalAlignment = HorizontalAlignment.Right,

                };

                Grid.SetColumn(sp, 0);
                Grid.SetColumn(RemoveSP, 1);

                container.Children.Add(sp);
                container.Children.Add(RemoveSP);

                sp.Children.Add(Valuta);
                sp.Children.Add(Pricing);

                RemoveSP.Click += LbPrices_MouseDoubleClick;

                LbPrices.Items.Add(container);

                _totalPrice = _totalPrice + d;
                string total = _totalPrice.ToString("0.00");
                TXTTotal.Text = total;
                _currentString = "";
                UpdateTextBlock();
                SPItems = +1;
                i++;
            }


        }

        private void LbPrices_MouseDoubleClick(object sender, RoutedEventArgs e)
        {

            if (LbPrices.SelectedIndex > -1)
            {
                if (MessageBox.Show("Weet u zeker dat u dit wilt verwijderen?", "", MessageBoxButton.YesNo) == MessageBoxResult.Yes)
                {
                    Grid container = LbPrices.SelectedItem as Grid;
                    decimal prijsRegel = 0;

                    foreach (StackPanel sp in container.Children.OfType<StackPanel>())
                    {
                        foreach (TextBlock item in sp.Children.OfType<TextBlock>())
                        {
                            if (item.Name.StartsWith("AllPrice"))
                            {
                                string prijs = item.Text;
                                prijsRegel = decimal.Parse(prijs);
                            }
                        }
                    }

                    LbPrices.Items.Remove(LbPrices.SelectedItem);
                    _totalPrice -= prijsRegel;
                    string total = _totalPrice.ToString("0.00");
                    TXTTotal.Text = total;
                }
            }
        }

        void Cam_NewFrame(object sender, AForge.Video.NewFrameEventArgs eventArgs)
        {
            Bitmap bitmap = (Bitmap)eventArgs.Frame.Clone();
            BarcodeReader reader = new BarcodeReader();
        }

        private void NumberValidationTextBox(object sender, TextCompositionEventArgs e)
        {
            Regex regex = new Regex("[^0-9]+");
            e.Handled = regex.IsMatch(e.Text);
        }
        private void ScanBarCode(object sender, RoutedEventArgs e)
        {
            //opens new window to scan barcode and get the scanned barcode
            scanner scan = new scanner();
            scan.ShowDialog();
            string FetchedBarcode = scan.BarcodeNumbers;
          

            string isBarcodeFound = _db.GetScannedBarcode(FetchedBarcode);
            if (isBarcodeFound != "")
            {
                string[] data = isBarcodeFound.Split('-');
                Add_Product(isBarcodeFound);
            }
            else
            {

            }
        }

        private void Add_Product(string isBarcodeFound)
        {
            string[] data = isBarcodeFound.Split('-');
            // Display three message boxes with the values
            string name = data[0].Trim();
            string barcode = data[1].Trim();
            string price = data[2].Trim();
            string Putamount = TbAmount.Text;

            decimal putprice = Convert.ToDecimal(price);

            if (Putamount == "" || Putamount == null || Putamount == "0")
            {
                putprice = putprice;
                Putamount = "1";
            }
            else
            {
                putprice = putprice * Convert.ToInt32(Putamount);
            }
            sp = new StackPanel()
            {
                Background = Brushes.AliceBlue,
                Orientation = Orientation.Horizontal,
            };

            Grid container = new Grid();

            // create a grid inside the stackpanel
            container.RowDefinitions.Add(new RowDefinition() { Height = new GridLength(20) });
            container.RowDefinitions.Add(new RowDefinition() { Height = new GridLength(20) });
            container.ColumnDefinitions.Add(new ColumnDefinition() { Width = new GridLength(1, GridUnitType.Star) });
            container.ColumnDefinitions.Add(new ColumnDefinition() { Width = GridLength.Auto });

            // transfers string into decimal
            TextBlock Name;
            TextBlock Barcode;
            TextBlock BarcodeBack;
            TextBlock Pricing;
            TextBlock Amount;
            TextBlock PutAmt;
            Button RemoveSP;

            Name = new TextBlock()
            {
                Foreground = Brushes.Black,
                Text = name,
                Name = "ProductName",
            };
            Barcode = new TextBlock()
            {
                Foreground = Brushes.Black,
                Text = barcode,
                Name = "Barcode",
            };
            BarcodeBack = new TextBlock()
            {
                Foreground = Brushes.Black,
                Text = barcode,
                Name = "BarcodeUsed",
                Visibility = Visibility.Hidden,
            };
            Pricing = new TextBlock()
            {
                Foreground = Brushes.Black,
                Text = price,
                HorizontalAlignment = HorizontalAlignment.Left,
                Name = "SinglePrice",
            };
            Amount = new TextBlock()
            {
                Foreground = Brushes.Black,
                Text = Putamount,
                Name = "Amount",
            };
            PutAmt = new TextBlock()
            {
                Text = putprice.ToString(),
                Visibility = Visibility.Hidden,
                Name = "AllPrice",
            };
            RemoveSP = new Button()
            {
                Content = "X",
                HorizontalAlignment = HorizontalAlignment.Right,

            };

            Grid.SetColumn(sp, 0);
            Grid.SetColumn(RemoveSP, 1);
            Grid.SetRow(Barcode, 1);
            Grid.SetColumn(Amount, 1);
            Grid.SetRow(Amount, 1);

            container.Children.Add(sp);
            container.Children.Add(RemoveSP);
            container.Children.Add(Barcode);
            container.Children.Add(Amount);
            //   container.Children.Add(PutAmt);

            sp.Children.Add(Name);
            //   sp.Children.Add(Barcode);
            sp.Children.Add(Pricing);
            //add child to sp so the delete function works
            sp.Children.Add(PutAmt);
            sp.Children.Add(BarcodeBack);
            RemoveSP.Click += LbPrices_MouseDoubleClick;

            LbPrices.Items.Add(container);

            _totalPrice = _totalPrice + putprice;
            string total = _totalPrice.ToString("0.00");
            TXTTotal.Text = total;
            _currentString = "";
            UpdateTextBlock();
            SPItems = +1;


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

            //Strings that needs to be added in the pdf
            //text for header of the pdf
            string CompanyName = "Groene Vingers";

            //data for the company to add to the invoice
            string KVKNummer = "KVK: 18057469";
            string Invoice = "23041";
            string Employee_line = "Werknemers nummer : " + Employee_number;
            string BTWNummer = "NL215523775B93";

            string ProductName = "";

            double btwPrice = 0;
            string BtwPrice = "";
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
            XPen lineBlack = new XPen(XColors.Black, 1);

            //text for total price string
            string TotalPrice = "€ " + _totalPrice.ToString("0.00");

            //get the total price including 21% btw
            btwPrice = Convert.ToDouble(_totalPrice) * 1.21;
            BtwPrice = "Inclusief 21% BTW € " + btwPrice.ToString("0.00");

            //data for the logo of GroeneVingers
            string ImagePath = @"../../Images/GroeneVingersLogo.png";
            XImage image = XImage.FromFile(ImagePath);


            //header for the page
            gfx.DrawImage(image, 0, 0, 100, 100);
            gfx.DrawString(CompanyName, HeaderFont, XBrushes.Black, new XRect(225, 50, 0, 20), XStringFormats.TopLeft);
            gfx.DrawString(CompanyName, font, XBrushes.Black, new XRect(420, 50, 0, 0));
            gfx.DrawString(Employee_line, font, XBrushes.Black, new XRect(420, 70, 0, 0));
       

            //header line,like bold letters
            int BoldSpacing = 50;
            string BoldLine = "Naam" + new string(' ', BoldSpacing - 4) + "Barcode" +new string(' ', 44) + "Totaal";

            gfx.DrawString(BoldLine, font, XBrushes.Black, new XRect(100, 150, page.Width, page.Height), XStringFormats.TopLeft);
            // Loop through the items in the listbox and draw them on the page
            int i = 6;


            foreach (var item in LbPrices.Items)
            {
                // retrieve the Grid containing the StackPanels
                Grid container = item as Grid;

                if (container != null)
                {
                    // loop through each StackPanel in the Grid
                    foreach (var child in container.Children)
                    {
                        StackPanel stackPanel = child as StackPanel;

                        if (stackPanel != null)
                        {
                            string productName = string.Empty;
                            string allPrice = string.Empty;
                            string barcodeUsed = string.Empty;
                            // loop through each TextBlock in the StackPanel
                            foreach (var grandChild in stackPanel.Children)
                            {
                                TextBlock textBlock = grandChild as TextBlock;

                                if (textBlock != null)
                                {
                                    if (textBlock.Name.StartsWith("ProductName"))
                                    {
                                        productName = textBlock.Text;
                                    }

                                    // Retrieve the price from the TextBlock with the name "AllPrice"
                                    if (textBlock.Name.StartsWith("AllPrice"))
                                    {
                                        allPrice = textBlock.Text;
                                       
                                    }
                                    //retrieve the barcode from the TextBlock with the name "BarcodeUsed"
                                    if (textBlock.Name.StartsWith("BarcodeUsed"))
                                    {
                                        barcodeUsed = textBlock.Text;
                                    }
                                }

                            }
                            if (!string.IsNullOrEmpty(productName) && !string.IsNullOrEmpty(barcodeUsed) && !string.IsNullOrEmpty(allPrice))
                            {
                     
                                int barcodeUsedX = 285; // set the Barcode on a specific X position 
                                int allPriceX = 480; // same goes for the allPrice
                        
                                string ProductText = $"{productName}";
                                string BarcodeText = $"{barcodeUsed}";
                                string PriceText = $"€ {allPrice}";
                             
                                gfx.DrawString(ProductText, font, XBrushes.Black, new XRect(100, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                                gfx.DrawString(BarcodeText, font, XBrushes.Black, new XRect(barcodeUsedX, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                                gfx.DrawString(PriceText, font, XBrushes.Black, new XRect(allPriceX, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                            }
                          /*  else if (!string.IsNullOrEmpty(productName) && !string.IsNullOrEmpty(barcodeUsed))
                            {
                                // Only product name and barcode used exist, display them together
                                string displayText = $"{productName} ({barcodeUsed})";
                                gfx.DrawString(displayText, font, XBrushes.Black, new XRect(100, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                            }
                            else if (!string.IsNullOrEmpty(productName) && !string.IsNullOrEmpty(allPrice))
                            {
                                // Only product name and all price exist, display them together
                                string displayText = $"{productName}: {allPrice}";
                                gfx.DrawString(displayText, font, XBrushes.Black, new XRect(100, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                            }
                            else if (!string.IsNullOrEmpty(productName))
                            {
                                // Only product name exists, display it alone
                                gfx.DrawString(productName, font, XBrushes.Black, new XRect(100, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                            }*/
                            else if (!string.IsNullOrEmpty(allPrice))
                            {
                                // Only all price exists, display it alone
                                gfx.DrawString("Winkel Product", font, XBrushes.Black, new XRect(100, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                                gfx.DrawString("€"+allPrice, font, XBrushes.Black, new XRect(480, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
                               
                            }


                            if (!string.IsNullOrEmpty(productName) || !string.IsNullOrEmpty(allPrice))
                            {
                                gfx.DrawLine(lineBlack, 50, 65 + i * 20, page.Width - 50, 65 + i * 20);
                                i++;
                            }
                        }

                    }
                }
            }

            //output of the total price
            gfx.DrawString(TotalPrice, font, XBrushes.Black, new XRect(480, 50 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
            gfx.DrawString(BtwPrice, font, XBrushes.Black, new XRect(375, 70 + i * 20, page.Width, page.Height), XStringFormats.TopLeft);
            //footer output
            gfx.DrawString(BTWNummer, font, XBrushes.Black,new XRect(page.Width / 2, page.Height - 40, page.Width / 2, 40), XStringFormats.TopLeft);
            gfx.DrawString(KVKNummer, font, XBrushes.Black, new XRect(page.Width / 2, page.Height - 30, page.Width / 2, 40), XStringFormats.TopLeft);
            // Save the PDF document to a file
            string filePath = "listbox.pdf";
            document.Save(filePath);

            // Open the PDF document using the default PDF viewer
            System.Diagnostics.Process.Start(filePath);
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

    }
}


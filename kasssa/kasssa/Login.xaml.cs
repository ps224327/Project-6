using Org.BouncyCastle.Crypto.Generators;
using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Windows;
using kasssa.Models;


namespace kasssa
{
    /// <summary>
    /// Interaction logic for Login.xaml
    /// </summary>
    public partial class Login : Window
    {
        private ProjectDB _usersdb = new ProjectDB();
        public Login()
        {
            InitializeComponent();
            DataContext = this;
        }
        private void TextBox_GotFocus(object sender, RoutedEventArgs e)
        {
            TxtUserName.Text = "";
        }

        private void PasswordBox_GotFocus(object sender, RoutedEventArgs e)
        {
            txtPassword.Password = "";
        }

        private void Login_Confirm(object sender, RoutedEventArgs e)
        {
            int employee_number = 1132;
            MainWindow win = new MainWindow(employee_number);
            win.Show();
            this.Close();

         /*   List<Users> users = new List<Users>();
            users = _usersdb.GetUserDetails();
            string name = TxtUserName.Text;
            string password = txtPassword.Password;

            try
            {
                for (int i = 0; i < users.Count; i++)
                {
                    if (users[i].Role == "admin" || users[i].Role == "employee")
                    {
                        if (users[i].Name == name)
                        {
                            if (users[i].Password == password)
                            {
                                int employee_number = users[i].Employee_number;
                                MainWindow win = new MainWindow(employee_number);
                                win.Show();
                                this.Close();
                                break;
                            }
                            else
                            {
                                MessageBox.Show("Wachtwoord is incorrect!");
                            }
                           
                        }
                        else
                        {

                        }
                    }
                    else
                    {

                        MessageBox.Show("toegang gewijgerd");
                    }
                   
                }

            }
            catch 
            {

                throw;
            }*/
        }

        
    }
}

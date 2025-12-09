# CMCNZ Chat Widget

A modern, AI-powered chat widget for the Chinese Medicine Council of New Zealand (CMCNZ) website, built with n8n automation and WordPress integration.

## 🌟 Features

### 🎨 **Official CMCNZ Branding**
- **Colors**: Teal (#5bbfbf), Tan/Beige (#c4a882), Dark Grey (#4a4a4a)
- **Logo**: Official CMCNZ logo integration
- **Typography**: Modern Poppins font family

### 🗣️ **Multilingual Support**
- **English** and **Chinese (中文)** language options
- **Language-specific suggested questions**
- **Backend language preference tracking**

### 🤖 **AI-Powered Responses**
- **Instant responses** (no more 24-hour wait times)
- **Intelligent conversation flow**
- **Context-aware suggestions**

### 📱 **Modern UX/UI**
- **Responsive design** for all devices
- **Smooth animations** and transitions
- **Accessibility compliant**
- **Mobile-first approach**

## 🚀 Quick Start

### Local Testing
```bash
# Start local server
python3 -m http.server 8000

# Open in browser
# http://localhost:8000/test.html
```

### WordPress Integration
1. Upload `cmcnz-chat-widget.php` to your WordPress plugins folder
2. Activate the "CMCNZ Chat Widget" plugin
3. Configure webhook URL and branding in WordPress admin

## 📁 File Structure

```
├── cmcnz-chatbot.js          # Main chatbot JavaScript widget
├── cmcnz-chat-widget.php     # WordPress plugin integration
├── test.html                 # Local testing page
└── README.md                 # This documentation
```

## ⚙️ Configuration

### WordPress Settings
- **Webhook URL**: Your n8n endpoint
- **Branding**: Logo, name, welcome text
- **Colors**: Primary, secondary, background, text colors
- **Position**: Left or right side launcher

### JavaScript Configuration
```javascript
window.ChatWidgetConfig = {
    webhook: {
        url: 'https://n8n.mediagiant.co.nz/webhook/...',
        route: 'general'
    },
    branding: {
        logo: 'https://www.chinesemedicinecouncil.org.nz/images/Logos/CMCNZ_logo_big.png',
        name: 'CMCNZ Chat',
        welcomeText: 'How can we help you today?',
        responseTimeText: 'Get instant AI-powered responses'
    },
    style: {
        primaryColor: '#5bbfbf',    // CMCNZ Teal
        secondaryColor: '#c4a882',  // CMCNZ Tan/Beige
        backgroundColor: '#ffffff', // White
        fontColor: '#4a4a4a',       // CMCNZ Dark Grey
        position: 'right'
    }
};
```

## 🎯 User Flow

1. **Launcher Click**: User clicks the chat button (bottom-right)
2. **Language Selection**: Choose English or Chinese
3. **Registration**: Enter name only (simplified)
4. **AI Chat**: Instant responses with contextual suggestions
5. **Language-Based Questions**: Dynamic suggestions in selected language

## 🔧 Technical Details

### Backend Integration
- **n8n Webhook**: RESTful API communication
- **Session Management**: Unique conversation IDs
- **Metadata Tracking**: User info, language, timestamps
- **Error Handling**: Graceful fallbacks

### Registration Data
```json
{
  "userName": "John Doe",
  "userLanguage": "english",
  "sessionId": "uuid-v4",
  "metadata": {
    "isUserInfo": true
  }
}
```

### Message Format
```json
{
  "action": "sendMessage",
  "sessionId": "uuid-v4",
  "route": "general",
  "chatInput": "User message",
  "metadata": {
    "userId": "John Doe",
    "userName": "John Doe",
    "userLanguage": "english"
  }
}
```

## 🌐 Multilingual Content

### English Questions
- How do I register as a practitioner?
- What are the accreditation requirements?
- How can I find continuing professional development?
- What are the professional standards?

### Chinese Questions (中文)
- 如何注册成为从业者？
- 认证要求是什么？
- 如何找到继续专业发展机会？
- 专业标准是什么？

## 🎨 Design System

### Color Palette
- **Primary**: `#5bbfbf` - CMCNZ Teal (buttons, links, accents)
- **Secondary**: `#c4a882` - CMCNZ Tan/Beige (gradients, highlights)
- **Text**: `#4a4a4a` - CMCNZ Dark Grey (body text)
- **Background**: `#ffffff` - White (surfaces)
- **Light**: `#e7f4f4` - Light teal (borders, subtle backgrounds)

### Typography
- **Font Family**: Poppins (Google Fonts)
- **Weights**: 400, 500, 600, 700
- **Sizes**: Responsive scaling

### Components
- **Launcher**: Fixed position, gradient background
- **Chat Window**: Rounded corners, shadow, smooth animations
- **Messages**: Bubble design with proper spacing
- **Forms**: Clean inputs with focus states
- **Buttons**: Gradient backgrounds with hover effects

## 🔒 Security & Privacy

- **No PII Storage**: Minimal user data collection
- **Secure Webhooks**: HTTPS-only communication
- **Session Isolation**: Unique conversation IDs
- **Input Sanitization**: Client-side validation

## 📱 Browser Support

- **Modern Browsers**: Chrome, Firefox, Safari, Edge
- **Mobile**: iOS Safari, Chrome Mobile
- **Responsive**: Adapts to all screen sizes
- **Progressive Enhancement**: Graceful degradation

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test locally with `test.html`
5. Submit a pull request

## 📄 License

This project is developed for the Chinese Medicine Council of New Zealand.

## 🆘 Support

For technical support or questions:
- Check the WordPress admin settings
- Test with the local `test.html` file
- Verify webhook URL configuration

## 🔄 Updates

- **v1.0.1**: Initial release with multilingual support
- **v1.0.0**: Basic chatbot functionality

---

**Built with ❤️ by Oxford Consulting for the Chinese Medicine Council of New Zealand**

*Empowering traditional medicine practitioners with modern AI technology*

# Final Project Proposal

## Topic

This website is meant to visualize a road trip I and a few friends plan to take late this summer. It will describe the locations we will visit day by day.

## Audience

The intended audience of this application is me, a few friends, and possibly their parents.

## Design & Style

I'd like to maintain a mostly minimal color scheme composed of black and white. Dividers and some sub-text may be grey. Components will generally have rounded corners and thin borders.

3 websites that inspire the design theory:

- [Travel + Leisure](<https://www.travelandleisure.com>)
- [Behance](<https://www.behance.net>)
- [Google Flights](<https://www.google.com/travel/flights>)

## Scope

1. How many pages are you planning to have? 4 distinct pages
   - What are the pages?
      - Day. Presents each day of the trip, currently undetermined how many days will be displayed.
      - Create Account.
      - Your Favorites. Shows the locations that each signed-in user favorited.
      - Upvoted Restaurants. Displays the restaurants in descending order of how many upvotes users have given them. Guest users will also be allowed to upvote.
  
2. If it is a single page website, how many sections are you planning to have? N/A

---

## Database

1. What data will be stored in the database?
   - The database will store account informations, favorites, upvotes, and the locations planned for each day of the trip.

2. Where is data coming from?
   - I will manually insert all image URLs and day by day attractions into the database. Accounts will come from the account creation functionality. When a user adds a location to their 'favorites' list that will also insert a record into the database.

## Database Diagram

<img width="1015" alt="ERD" src="https://user-images.githubusercontent.com/46798485/118374467-0f721a00-b571-11eb-8c16-20b9bc49ad2b.png">

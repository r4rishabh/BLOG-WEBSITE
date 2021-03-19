public class Constructoroverl
{
	private String name;
	private int age;
	private String state;

	public statci void Constructoroverl(String name, int age, String state)
	{
		this.name = name;
		this.age = age;
		this.state = state;

	}

	public statci void Constructoroverl(int age, String name,  String state)
	{
		this.name = name;
		this.age = age;
		this.state = state;

	}


	public static void main(String args[])
	{
		Constructoroverl obj = new Constructoroverl("rishabh", 22, "up");
		System.out.println(obj.name,obj.age,obj.state);
		Constructoroverl obj2 = new Constructoroverl(22, "rishabh", "up");
		System.out.println(obj1.age,obj1.name,obj1.state);
	}
}
class LovelyBox
  module Runners
    class Yum
      #
      # @param [Array] packages
      #
      def self.run(packages)
        system(Shellwords.join(%w{yum install -y} + packages))
      end
    end
  end
end